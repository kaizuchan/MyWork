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
        // 自分の情報をViewに送信
        $me = $this->Authentication->getIdentity();
        $this->loadModel('Enterprises');
        $enterprise = $this->Enterprises->find('all')->where(['id'=>$me->enterprise_id])->first()->get('name');
        $this->set(compact('me', 'enterprise'));
        // アクセス制限
        $this->loadModel('Users');
        $user = $this->Users->get($me->id);
        $this->Authorization->authorize($user, 'view');
    }

    public function index()
    {        
        // ログイン中のユーザー情報取得
        $me = $this->Authentication->getIdentity();
/*         $this->loadModel('Users');
        $user = $this->Users->get($me->id);
        $this->Authorization->authorize($user, 'view'); */
        
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
                $users = $this->SerchUser->getEmployee($me->enterprise_id, null, $find);
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
                    
                    foreach($userId as $i){
                        // 条件
                        $where = array(
                            'users.id' => $i,
                        );
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
        // データベース登録処理
        if ($this->request->is('post')) {
            $this->loadModel('Punches');
            $data = $this->request->getData();

            // 対象データを削除済みに変更
            if(isset($data['delete'])){
                $punche = $this->Punches->get($data['id']);
                $punche->info = 9;
                if ($this->Punches->save($punche)) {
                    $this->Flash->success(__('削除しました'));
                    return $this->redirect('/admin/works/'.$id.'/edit/'.$date);
                }else{
                    $this->Flash->error(__('削除に失敗しました'));
                }
            }
            if(isset($data['update'])){
                // 元データを削除済みに変更
                $punche_old = $this->Punches->get($data['id']);
                $punche_old->info = 9;
                if ($this->Punches->save($punche_old)) {
                    $this->Flash->success(__('削除しました'));
                }else{
                    $this->Flash->error(__('削除に失敗しました'));
                }
                // 更新データの登録
                $punch_date = substr($date, 0, 4).'/'.substr($date, 4, 2).'/'.substr($date, 6, 2);
                $punche_new = $this->Punches->newEmptyEntity();
                $punche_new->user_id = $id;
                $punche_new->date = $punch_date;
                $punche_new->time = $punch_date.' '.$data['time'];
                $punche_new->identify = $data['identify'];
                $punche_new->info = 2;
                if ($this->Punches->save($punche_new)) {
                    $this->Flash->success(__('更新しました'));
                    return $this->redirect('/admin/works/'.$id.'/edit/'.$date);
                }else{
                    $this->Flash->error(__('更新に失敗しました'));
                }
            }
        }



        // 該当する打刻データを取得して、Viewに送信
        $user = $this->Users->find('all')->where(['id'=> $id])->first();
        $times = $this->PuncheData->getPunchedData($id, $date);
        
        $this->set(compact('times', 'date', 'user'));

    }

}