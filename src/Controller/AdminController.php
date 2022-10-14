<?php
declare(strict_types=1);

namespace App\Controller;

class AdminController extends AppController
{
    public function index()
    {
        // 使うモデルの選択
        $this->loadModel('Users');
        // データの取り出し
        $users = $this->Users->find('all');
        // データセット
        $this->set(compact('users'));
    }

    public function adduser($id = null)
    {
    }
}
