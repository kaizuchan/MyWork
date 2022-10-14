<?php
declare(strict_types=1);

namespace App\Controller;

class AdminController extends AppController
{
    public function index()
    {
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

            if ($this->Users->save($user)) {
                $this->Flash->success(__('登録しました'));
                return $this->redirect(['controller' => 'admin', 'action' => 'index']);
            }
            $this->Flash->error(__('社員登録に失敗しました'));
        }
    }

    public function works()
    {
    }

    public function workedit()
    {
    }
}
