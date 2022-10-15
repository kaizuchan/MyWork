<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\TableRegistry;
use Cake\ORM\Table;

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
            $searchUsers = [];
            $find = $this->request->getData('find');
            // debug($find);
            $searchUsers = $this->users->find('all')->where(['last_name LIKE' => '%'.$find.'%']);
            $this->set('searchUsers', $searchUsers);
        }
        

        $user = $this->Authentication->getIdentity();

        $query = $this->users->find('all')->where(['enterprise_id' => $user->enterprise_id]);

        $this->set('users', $query);
    }
    public function works()
    {
    }
}
