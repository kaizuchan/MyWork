<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\Datasource\ConnectionManager;
use Cake\Http\Client;
/**
 * Users Controller
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->Authentication->allowUnauthenticated(['index', 'login', 'logout']);
    }

    public function index()
    {
        if (($this->request->is('post')) == false){
            $this->redirect(['action' => 'login']);
        }
        // postとして飛んできた場合、
        // 企業ID 及び 社員ID から「Users.id」を求めて、$_POST['id']
        // 受け取ったパスワードを$_POST['password']として、/users/loginへリダイレクト
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            //debug($data);
            $connection = ConnectionManager::get('default');
            $query = 'SELECT id FROM enterprises where login_id = "'.$data['enterprise_id'].'";';
            $enterprise = $connection->execute($query)->fetch('assoc');
            //debug($enterprise['id']);
            $query = 'SELECT id FROM users where enterprise_id = '.$enterprise['id'].' and employee_id = "'.$data['employee_id'].'";';
            //$query = 'SELECT id FROM users';
            $user = $connection->execute($query)->fetch('assoc');
            //debug($user['id']);
            $this->request = $this->request->withData('id', (string) $user['id']);
            $_POST['id'] = (string) $user['id'];
        }

        // 無理やりリダイレクト処理書いてます...
        // 要変更
        echo '<form method="post" action="/users/login" id="myform">';
        echo '<input type="hidden" name="id" value="'. $user["id"].'" />';
        echo '<input type="hidden" name="password" value="'.$data["password"].'" />';
        echo '<input type="hidden" name="_csrfToken" autocomplete="off"
        value="'.$this->request->getAttribute('csrfToken').'">';
        echo '</form><script>document.getElementById("myform").submit();</script>';
    }

    public function login()
    {
        // sample code
/*         if ($this->request->is('post')) {
            $data = $this->request->getData();
            debug($data);
            $connection = ConnectionManager::get('default');
            $query = 'SELECT id FROM enterprises where login_id = "'.$data['enterprise_id'].'";';
            $enterprise = $connection->execute($query)->fetch('assoc');
            debug($enterprise['id']);
            $query = 'SELECT id FROM users where enterprise_id = '.$enterprise['id'].' and employee_id = "'.$data['employee_id'].'";';
            $user = $connection->execute($query)->fetch('assoc');
            debug($user['id']);
            $this->request = $this->request->withData('id', (string) $user['id']);
            $this->request['loin'];
        } */

        $result = $this->Authentication->getResult();
        // 認証成功
        if ($result->isValid()) {
            $target = $this->Authentication->getLoginRedirect() ?? '/';
            return $this->redirect($target);
        }
        // ログインできなかった場合
        if ($this->request->is('post') && !$result->isValid()) {
            $this->Flash->error('Invalid username or password');
        }
    }

    public function logout()
    {
        $this->Authentication->logout();
        return $this->redirect(['action' => 'login']);
    }
}
