<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\I18n\FrozenTime;
use Migrations\Command\Phinx\Dump;

class AdminController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        // コンポーネントの読み込み
        $this->loadComponent("PuncheData");
        $this->loadComponent("SerchUser");
        // ログイン中のユーザー情報を読み込み
        $me = $this->Authentication->getIdentity();
        $this->set(compact('me'));
    }

    public function index()
    {        
        // ログイン中のユーザー情報取得
        $me = $this->Authentication->getIdentity();
        
        // 使うモデルの選択
        $this->loadModel('Users');

        // 社員全員の情報を取り出す
        $users = $this->SerchUser->getEmployee($me->enterprise_id);

        if ($this->request->is('post')) {

            // 検索
            if(isset($_POST['find'])){
                // 入力値受け取り
                $find = $this->request->getData('find');
                // 条件に一致する社員の情報を取り出す
                $users = $this->SerchUser->getEmployee($me->enterprise_id, $find);
                // 取り出した社員の人数を数える
                $count = $users->count();
                // 人数を渡す
                $this->set('count', $count);
            }
            
            // 削除処理
            if(isset($_POST['yesButton'])){
                // データ取得                                                                                                                                                       
                $userId = $this->request->getData('delete');
                if($userId == null){
                    // 何も選択されてない場合　なにもしない
                    header('Location: /admin');
                    exit();
                }else{
                    // 削除処理
                    //debug($userId);
                    // 現在時刻
                    $time = FrozenTime::now();

                    // 書き換える部分
                    $data = array(
                        'users.employee_id' => '',
                        'users.role' => '9',
                        'users.deleted_at' => $time,
                    );
                    //debug($data);
                    
                    foreach($userId as $i){
                        // 条件
                        $where = array(
                            'users.id' => $i,
                        );
                        //debug($where);
                        $this->Users->updateAll($data, $where);
                    }
                }
            }
        }
        
        // データセット
        $this->set(compact('users'));
    }

    public function adduser()
    {
        /*
         * Users.email の isUniqueを削除
         * ↑ 自動生成のままだと、emailはuniqueとして扱われる
         * 原則同じメールアドレスは使われないはずだが、消しておいたほうがいい
         */
        if ($this->request->is('post')) {
            // 同じ社員IDを持ったユーザーがいないかの確認
            $me = $this->Authentication->getIdentity();
            $this->loadModel('Users');
            $employee_id = $this->request->getData('employee_id');
            $res = $this->Users->find('all')->where([
                'enterprise_id' => $me->enterprise_id,
                'employee_id'   => $employee_id
            ])->first();
            if($res == null){
                $user = $this->Users->newEmptyEntity();
                // 送信されたデータを登録
                $user = $this->Users->patchEntity($user, $this->request->getData());
    
                // 誕生日のみ連結処理が必要
                $year = $this->request->getData("birthday_year");
                $month = $this->request->getData("birthday_month");
                $date = $this->request->getData("birthday_date");
                $user->birthday = mktime(0,0,0,$month,$date,$year);
    
                if ($this->Users->save($user)) {
                    // 登録成功
                    $this->Flash->success(__('登録しました'));
                    return $this->redirect(['controller' => 'admin', 'action' => 'index']);
                }
                    // 登録失敗
                $this->Flash->error(__('社員登録に失敗しました'));
            }else{
                $this->Flash->error(__('同じ社員IDが既に存在します'));
            }
        }
    }

    public function edituser($id)
    {
        // ログイン中のユーザー情報取得
        $me = $this->Authentication->getIdentity();
        // データセット
        $this->set(compact('me'));
        
        $this->loadModel('Users');

        if ($this->request->is('post')) {
            // 同じ社員IDを持ったユーザーがいないかの確認
            $me = $this->Authentication->getIdentity();
            $employee_id = $this->request->getData('employee_id');
            $res = $this->Users->find('all')->where([
                'enterprise_id' => $me->enterprise_id,
                'employee_id'   => $employee_id,
                'not' => ['id' => $id],
            ])->first();
            if($res == null){


                $user = $this->Users->get($id);
                // 3.4.0 より前は $this->request->data() が使われました。
                $user = $this->Users->patchEntity($user, $this->request->getData());

                // 誕生日のみ連結処理が必要
                $year = $this->request->getData("birthday_year");
                $month = $this->request->getData("birthday_month");
                $date = $this->request->getData("birthday_date");

                $user->birthday = mktime(0,0,0,$month,$date,$year);
                if ($this->Users->save($user)) {
                    $this->Flash->success(__('更新しました'));
                    return $this->redirect(['controller' => 'admin', 'action' => 'index']);
                }
                $this->Flash->error(__('社員更新に失敗しました'));
            }else{
                $this->Flash->error(__('同じ社員IDが既に存在します'));
            }
        }else{
            // 初めに動く処理
            // idが合致するユーザー情報を取得
            $user = $this->Users->find('all')->where(['id' => $id])->first();
            $this->set(compact('user'));
        }
    }

    public function works($id, $month = null, $year = null)
    {
        $this->loadModel('Users');
        $user = $this->Users->find('all')->where(['id'=> $id])->first();
        $dates = $this->PuncheData->getMonthlyData($id, $month, $year);
        $this->set(compact('dates', 'id', 'user'));

    }

    public function editwork($id, $date)
    {
        // 該当する打刻データを取得して、Viewに送信
        $times = $this->PuncheData->getPunchdData($date, $id); 
        $this->set(compact('times', 'date'));

        // データベース登録処理
        //debug($times);
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            //debug($data);
            $this->loadModel('Punches');

            $identify = array('start_work', 'start_break', 'end_break', 'end_work');
            
            $stmt = false;
            for ($i = 1; $i <= 4; $i++) {
                // 更新されたデータを特定し、そのデータのみ登録処理を行う
                if($times[$identify[$i-1]] != $data[$identify[$i-1]]){
                    $punche = $this->Punches->newEmptyEntity();
                    $punche->user_id = $id;
                    $punche->date = $date;
                    $punche->time = $data[$identify[$i-1]];
                    $punche->identify = $i;
                    $punche->modified_info = 1;
                    $stmt = $this->Punches->save($punche);
                }
            }

            if ($stmt) {
                $this->Flash->success(__('更新しました'));
                return $this->redirect(['controller' => 'admin', 'action' => 'works', $id]);
            }else{
                $this->Flash->error(__('更新に失敗しました'));
            }
        }
        // 
    }

}
