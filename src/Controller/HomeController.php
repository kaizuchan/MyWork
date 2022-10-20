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
        $me = $this->Authentication->getIdentity();
        $this->set(compact('me'));
    }

    public function home($id = null)
    {   
        // ログイン中のユーザー情報取得
        $me = $this->Authentication->getIdentity();

        $user = $this->Authentication->getIdentity();


        // 勤務状況表示
        
        $users = $this->users->find('all')->where([
            ['enterprise_id' => $user->enterprise_id],
            'not' => ['role'=>9]
        ]);


        if ($this->request->is('post')) {

            // 打刻処理
            if(isset($_POST['attend'])) {
                    
                // エンティティーの生成
                $punches = $this->punch->newEmptyEntity();

                $punches->user_id = $me->id;
                $punches->date = date("Y/m/d");
                $punches->time = date("H:i:s");
                $punches->identify = 1;

                // データ登録
                try {
                    $this->punch->saveOrFail($punches);
                } catch (\Cake\ORM\Exception\PersistenceFailedException $e) {
                    echo $e->getEntity();
                }
            }
            if(isset($_POST['leave'])) {
                    
                $punches = $this->punch->newEmptyEntity();

                $punches->user_id = $me->id;
                $punches->date = date("Y/m/d");
                $punches->time = date("H:i:s");
                $punches->identify = 4;

                try {
                    $this->punch->saveOrFail($punches);
                } catch (\Cake\ORM\Exception\PersistenceFailedException $e) {
                    echo $e->getEntity();
                }
            }
            if(isset($_POST['restStart'])) {
                    
                $punches = $this->punch->newEmptyEntity();

                $punches->user_id = $me->id;
                $punches->date = date("Y/m/d");
                $punches->time = date("H:i:s");
                $punches->identify = 2;

                try {
                    $this->punch->saveOrFail($punches);
                } catch (\Cake\ORM\Exception\PersistenceFailedException $e) {
                    echo $e->getEntity();
                }
            }
            if(isset($_POST['restFinish'])) {
                    
                $punches = $this->punch->newEmptyEntity();

                $punches->user_id = $me->id;
                $punches->date = date("Y/m/d");
                $punches->time = date("H:i:s");
                $punches->identify = 3;

                try {
                    $this->punch->saveOrFail($punches);
                } catch (\Cake\ORM\Exception\PersistenceFailedException $e) {
                    echo $e->getEntity();
                }
            }
            // 社員検索処理
            if(isset($_POST['searchButton'])) {

                // 配列
                $searchUsers = [];
                
                // 入力値受け取り
                $find = $this->request->getData('find');
                // debug($find);

                // 入力値が条件に合うかどうか検索
                $users = $this->users->find('all')->where([
                    'or' => [
                        ['last_name LIKE' => '%'.$find.'%',],
                        ['first_name LIKE' => '%'.$find.'%']
                    ],
                    'not' => ['role' => '9']
                ]);

                //ユーザーの人数を取得
                //debug($count);
                // 条件にあったデータを渡す
                //$this->set('searchUsers', $searchUsers);
                $count = $users->count();
            $this->set('count', $count);
            
                // 出勤状況表示部分
                $searchStatus = $this->solve($searchUsers);
                $this->set('searchStatus', $searchStatus);
            }
        }
        
        // 出勤状況表示部分
        $status = $this->solve($users);
        $this->set('status', $status);
        
        // Viewへの受け渡し
        $this->set('users', $users);
    }

    public function works($month = null, $year = null)
    {
        $me = $this->Authentication->getIdentity()->get('id');
        $data = $this->PuncheData->getMonthlyData($me, $month, $year);
        $this->set(compact('data'));

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
            //debug($user->id);
            array_push($array, $this->solveStatus($user->id));
        }
        //debug($array);
        return $array;
    }
    private function solveStatus($id)
    {
        $this->loadModel('Punches');

        //debug(date('Y-m-d'));
        
        // 当日のその人のデータを全て取得

        if($this->checkStatus($id, 4)){
            // 退勤済み
            return "退勤";
            exit();
        }elseif($this->checkStatus($id, 3)){
            // 休憩終了後 勤務中
            return "勤務中";
            exit();
        }elseif($this->checkStatus($id, 2)){
            // 休憩終了開始後
            return "休憩中";
            exit();
        }elseif($this->checkStatus($id, 1)){
            // 出勤後
            return "勤務中";
            exit();
        }elseif($this->checkStatus($id, 4, "yesterday")){
            // 退勤済み
            return "退勤";
            exit();
        }elseif($this->checkStatus($id, 3, "yesterday")){
            // 休憩終了後 勤務中
            return "勤務中";
            exit();
        }elseif($this->checkStatus($id, 2, "yesterday")){
            // 休憩終了開始後
            return "休憩中";
            exit();
        }elseif($this->checkStatus($id, 1, "yesterday")){
            // 出勤後
            return "勤務中";
            exit();
        }else{
            // 直近2日間の勤怠情報がない場合
            return "退勤";
            exit();
        }

    }
    private function checkStatus($id,$identify,$date = null)
    {
        if($date!=null){
            // 昨日
            $date = date('Y-m-d', strtotime('-1 day'));
        }else{
            // 今日
            $date = date('Y-m-d');
        }
        // 指定されたユーザー 及び 日付の最新（最後に追加された）データを取得
        $query = $this->Punches
        ->find('all')
        ->where(['user_id'=>$id, 'date'=>$date, 'identify'=>$identify])
        ->last();
        //debug($query->id);
        // 取得したデータが空ならFalse あるならTrueを返す
        if($query == null){
            return false;
        }else{
            return true;
        }
    }
    
}
