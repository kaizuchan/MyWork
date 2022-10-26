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
        // アクセス制限にかからないよう
        $this->Authorization->skipAuthorization();
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
            $this->loadModel('Enterprises');
            $enterprise = $this->Enterprises->find('all')->where([
                'login_id'=>$data['enterprise_id'],
            ])->first();
            if($enterprise != null){
                $res = $this->Users->find('all')->where([
                    'enterprise_id'=>$enterprise->id,
                    'employee_id'=>$data['employee_id'],
                ])->first();
            }
        }

        // 無理やりリダイレクト処理書いてます...
        // 要変更
        echo '<form method="post" action="/users/login" id="myform">';
        echo '<input type="hidden" name="id" value="';
        if(isset($res['id'])){
            echo $res['id'];
        }
        echo '" />';
        echo '<input type="hidden" name="password" value="'.$data["password"].'" />';
        echo '<input type="hidden" name="_csrfToken" autocomplete="off"
        value="'.$this->request->getAttribute('csrfToken').'">';
        echo '</form><script>document.getElementById("myform").submit();</script>';
    }

    public function login()
    {
        $result = $this->Authentication->getResult();
        // 認証成功
        if ($result->isValid()) {
            $target = $this->Authentication->getLoginRedirect() ?? '/';
            return $this->redirect($target);
        }
        // ログインできなかった場合
        if ($this->request->is('post') && !$result->isValid()) {
            $this->Flash->error('社員IDまたはパスワードが正しくありません。');
        }
    }

    public function logout()
    {
        $this->Authentication->logout();
        $this->Flash->success(__('ログアウトしました'));
        return $this->redirect(['action' => 'login']);
    }
}
