<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\TableRegistry;
use Cake\ORM\Table;
use Punches;

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
        $this->punch = TableRegistry::getTableLocator()->get('punches');
    }

    public function home($id = null)
    {   

        $user = $this->Authentication->getIdentity();

        if ($this->request->is('post')) {

            if(isset($_POST['attend'])) {
                    
                // エンティティーの生成
                $punches = $this->punch->newEmptyEntity();

                $punches->id = 5;
                $punches->user_id = 0;
                $punches->date = "2022-10-15";
                $punches->time = "12:00:00";
                $punches->identify = 1;
                $punches->punched_by = 0;
                $punches->modified_info = 0;

                // データ登録
                try {
                    $this->punch->saveOrFail($punches);
                } catch (\Cake\ORM\Exception\PersistenceFailedException $e) {
                    echo $e->getEntity();
                }
            }

            if(isset($_POST['searchButton'])) {

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

        }

        $query = $this->users->find('all')->where(['enterprise_id' => $user->enterprise_id]);

        $this->set('users', $query);

    }

    public function works()
    {
    }
}
