<?php
declare(strict_types=1);

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Datasource\ModelAwareTrait;

/**
 * SerchUser component
 */
class SerchUserComponent extends Component
{
    
    // loadModel()を使うために読み込む
    use ModelAwareTrait;


    public function getEmployee($id, $keyword = null){
        $this->loadModel('Users');
        $where = [
            'enterprise_id' => $id,
            'not' => ['role' => '9'],
        ];
        if($keyword != null){
            $where = array_merge($where, ['or' => [
                ['last_name LIKE' => '%'.$keyword.'%'],
                ['first_name LIKE' => '%'.$keyword.'%'],
                ['CONCAT(last_name,first_name) LIKE' => '%'.$keyword.'%'],
            ]]);
        }
        $users = $this->Users->find('all')->where($where);
        return $users;
    }
    public function sample(){
        echo"hello";
    }
}
