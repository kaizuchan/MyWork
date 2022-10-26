<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\TableRegistry;
use Cake\ORM\Table;
use Punches;
use Migrations\Command\Phinx\Dump;
use App\Utils\AppUtility;

/**
 * Home Controller
 *
 * @method \App\Model\Entity\Home[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class HomeController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        // コンポーネントの読み込み
        $this->loadComponent("PuncheData");
        $this->loadComponent("SerchUser");
        // テーブル取得
        $this->users = TableRegistry::getTableLocator()->get('users');
        $this->punch = TableRegistry::getTableLocator()->get('punches');
        // 自分の情報をViewに送信
        $me = $this->Authentication->getIdentity();
        $this->loadModel('Enterprises');
        $this->set(compact('me'));
        // アクセス制限にかからないよう
        $this->Authorization->skipAuthorization();
    }

    public function home()
    {   
        // ログイン中のユーザー情報取得
        $me = $this->Authentication->getIdentity();

        // 社員情報を取得
        $users = $this->SerchUser->getEmployee($me->enterprise_id, $me->id);
        //debug($users);
        //$users = $users->where(['not' => ['id' => $me->id]]);


        if ($this->request->is('post')) {
            // 社員検索処理
            if(isset($_POST['searchButton'])) {
                // 入力値受け取り
                $find = $this->request->getData('find');
                // 条件に一致する社員の情報を取り出す
                $users = $this->SerchUser->getEmployee($me->enterprise_id, $me->id, $find);
                //ユーザーの人数を取得
                $count = $users->count();
                $this->set('count', $count);
            }
        }
        
        // 出勤状況表示部分
        $status = $this->solve($users);
        // ログイン中ユーザーの勤怠情報を送信
        $flag = $this->PuncheData->getPunchStatement($me->id);

        
        // 企業情報をViewに送信
        $enterprise = $this->Enterprises->find('all')->where(['id'=>$me->enterprise_id])->first()->get('name');
        $this->set(compact('enterprise'));
        
        // Viewへの受け渡し
        $this->set(compact('users', 'flag', 'status'));
    }

    public function works($month = null, $year = null)
    {
        $me = $this->Authentication->getIdentity();
        $data = $this->PuncheData->getMonthlyData($me->id, $month, $year);
        $this->set(compact('data'));

        // 企業情報をViewに送信
        $enterprise = $this->Enterprises->find('all')->where(['id'=>$me->enterprise_id])->first()->get('name');
        $this->set(compact('enterprise'));
    }

    /* 打時刻処理 */
    public function punch(){
        $me = $this->Authentication->getIdentity();
        if ($this->request->is('post')) {
            // エンティティーの生成
            $punches = $this->punch->newEmptyEntity();
            // データの登録
            $punches->user_id = $me->id;
            $punches->time = date('Y-m-d H:i:s');
            
            // 出勤
            if(isset($_POST['attend'])) {
                $punches->date = date("Y/m/d");
                $punches->identify = 1;
            }else{
                // 出勤処理以外の場合
                // Punches.dateに 出勤打刻した日の日付を登録
                $date = $this->PuncheData->getPunchedDate($me->id);
                $punches->date = $date->i18nFormat('yyyy-MM-dd');
                

                // 休憩開始
                if(isset($_POST['restStart'])) {
                    $punches->identify = 2;
                }
                // 休憩終了
                if(isset($_POST['restFinish'])) {
                    $punches->identify = 3;
                }
                // 退勤
                if(isset($_POST['leave'])) {
                    $punches->identify = 4;
                }
            }
            // 連続で押された場合のエスケープ処理
            //$identify = $this->PuncheData->getPunchStatement($me->id);
            $identify = $this->solve(array($me));
            $identify = $identify[0];
            if($identify == '退勤'){$identify = array(1);}// 出勤
            if($identify == '勤務中'){$identify = array(2, 4);}// 休憩開始 退勤
            if($identify == '休憩中'){$identify = array(3);}// 休憩終了
            foreach($identify as $i){
                if(($i == $punches->identify)){
                    // データ登録
                    try {
                        $this->punch->saveOrFail($punches);
                    } catch (\Cake\ORM\Exception\PersistenceFailedException $e) {
                        echo $e->getEntity();
                    }
                }
            }
        }
        // HOME画面へリダイレクトさせる
        $this->redirect(['action' => 'home']);


    }

    // 実験用
    public function index()
    {
    }
    
    //内部処理
    private function solve($users)
    {
        $array = array();
        foreach($users as $user){
            switch($this->PuncheData->getPunchStatement($user->id)){
                case null:
                    $data = "退勤";
                    break;
                case 1:
                    $data = "勤務中";
                    break;
                case 2:
                    $data = "休憩中";
                    break;
                case 3:
                    $data = "勤務中";
                    break;
                case 4:
                    $data = "退勤";
                    break;
            }
            array_push($array, $data);
        }
        return $array;
    }

}
