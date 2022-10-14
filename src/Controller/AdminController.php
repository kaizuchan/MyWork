<?php
declare(strict_types=1);

namespace App\Controller;

class AdminController extends AppController
{
    public function index()
    {
        // ログイン中のユーザー情報取得
        $user = $this->Authentication->getIdentity();
        
        // 使うモデルの選択
        $this->loadModel('Users');
        // データの取り出し
        $users = $this->Users->find('all')->where(['enterprise_id' => $user->enterprise_id]);
        // データセット
        $this->set(compact('users'));
    }

    public function adduser($id = null)
    {
    }

    public function works()
    {
    }

    public function workedit()
    {
    }
}
