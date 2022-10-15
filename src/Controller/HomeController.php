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
        }
        

        $user = $this->Authentication->getIdentity();

        $query = $this->users->find('all')->where(['enterprise_id' => $user->enterprise_id]);

        $this->set('users', $query);
    }
    public function works()
    {
    }
}
