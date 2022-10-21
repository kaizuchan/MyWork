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

    /* 従業員を取得する
     * $id = 企業ID
     * 企業IDに該当するユーザー情報を取得する
     * $keywordを設定すれば、名前が一致するユーザーのみを取得 
     */
    public function getEmployee($enterprise_id, $id = null, $keyword = null){
        $this->loadModel('Users');
        $where = [
            'enterprise_id' => $enterprise_id,
            'not' => ['role' => '9'],
        ];
        if($keyword != null){
            $where = array_merge($where, ['or' => [
                ['last_name LIKE' => '%'.$keyword.'%'],
                ['first_name LIKE' => '%'.$keyword.'%'],
                ['CONCAT(last_name,first_name) LIKE' => '%'.$keyword.'%'],
                ['last_name_kana LIKE' => '%'.$keyword.'%'],
                ['first_name_kana LIKE' => '%'.$keyword.'%'],
                ['CONCAT(last_name_kana,first_name_kana) LIKE' => '%'.$keyword.'%'],
            ]]);
        }
        $order = [];
        if($id != null){
            array_push($order, 'id = '.$id.' DESC');
        }
        array_push($order, 'employee_id ASC');
        $users = $this->Users->find('all')->where($where)->order($order)/* ->order(['id'=>'ASC']) */;
        return $users;
    }
}
