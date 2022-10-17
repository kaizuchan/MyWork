<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\TableRegistry;
use Cake\ORM\Table;
use Migrations\Command\Phinx\Dump;

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
        // テーブル取得
        $this->users = TableRegistry::getTableLocator()->get('users');
    }

    public function home($id = null)
    {   

        if ($this->request->is('post')) {

                // 配列
                $searchUsers = [];
                
                // 入力値受け取り
                $find = $this->request->getData('find');
                // debug($find);

                // 入力値が条件に合うかどうか検索
                $searchUsers = $this->users->find('all')->where(['or' => [
                    ['last_name LIKE' => '%'.$find.'%',],
                    ['first_name LIKE' => '%'.$find.'%']
                ]
            ]);
            // 条件にあったデータを渡す
            $this->set('searchUsers', $searchUsers);
            
            // 出勤状況表示部分
            $searchStatus = $this->solve($searchUsers);
            $this->set('searchStatus', $searchStatus);
        }
        

        $user = $this->Authentication->getIdentity();

        $query = $this->users->find('all')->where(['enterprise_id' => $user->enterprise_id]);

        $this->set('users', $query);
        
        // 出勤状況表示部分
        $status = $this->solve($query);
        $this->set('status', $status);
    }
    public function works()
    {
    }

    // 実験用
    public function index()
    {
        debug($this->solveStatus(1));
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
