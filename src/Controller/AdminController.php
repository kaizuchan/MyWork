<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\I18n\FrozenTime;

class AdminController extends AppController
{
    public function index()
    {
        // ログイン中のユーザー情報取得
        $user = $this->Authentication->getIdentity();
        
        // 使うモデルの選択
        $this->loadModel('Users');
        // データの取り出し
        $users = $this->Users->find('all')->where(['enterprise_id' => $user->enterprise_id, 'not' => ['role' => '9']]);
        //debug($users);
        // データセット
        $this->set(compact('users'));

        // 検索
        if ($this->request->is('post')) {

            if(isset($_POST['find'])){
                // 配列
                $searchUsers = [];
                            
                // 入力値受け取り
                $find = $this->request->getData('find');
                // debug($find);
                // 入力値が条件に合うかどうか検索
                $searchUsers = $this->Users->find('all')->where(['or' => [
                    ['last_name LIKE' => '%'.$find.'%',],
                    ['first_name LIKE' => '%'.$find.'%'],
                ],
                'not' => ['role' => '9']
                ]);
                // 条件にあったデータを渡す
                $this->set('searchUsers', $searchUsers);
            }
            
            // 削除処理
            if(isset($_POST['deleteButton'])){
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
    }
    public function adduser()
    {
        /*
         * Users.email の isUniqueを削除
         * ↑ 自動生成のままだと、emailはuniqueとして扱われる
         * 原則同じメールアドレスは使われないはずだが、消しておいたほうがいい
         */
        // ログイン中のユーザー情報取得
        $me = $this->Authentication->getIdentity();
        // データセット
        $this->set(compact('me'));

        $this->loadModel('Users');
        $user = $this->Users->newEmptyEntity();
        if ($this->request->is('post')) {
            // 3.4.0 より前は $this->request->data() が使われました。
            $user = $this->Users->patchEntity($user, $this->request->getData());

            // 誕生日のみ連結処理が必要
            $year = $this->request->getData("birthday_year");
            $month = $this->request->getData("birthday_month");
            $date = $this->request->getData("birthday_date");
            $user->birthday = mktime(0,0,0,$month,$date,$year);

            if ($this->Users->save($user)) {
                $this->Flash->success(__('登録しました'));
                return $this->redirect(['controller' => 'admin', 'action' => 'index']);
            }
            $this->Flash->error(__('社員登録に失敗しました'));
        }
    }

    public function edituser($id)
    {
        // ログイン中のユーザー情報取得
        $me = $this->Authentication->getIdentity();
        // データセット
        $this->set(compact('me'));

        $this->loadModel('Users');
        $user = $this->Users->get($id);
        if ($this->request->is('post')) {
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
            // 初めに動く処理
            // idが合致するユーザー情報を取得
            $user = $this->Users->find('all')->where(['id' => $id])->first();
            $this->set(compact('user'));
        }
    }

    public function works()
    {
    }

    public function workedit()
    {
    }
}
