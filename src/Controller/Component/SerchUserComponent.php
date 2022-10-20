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
                ['last_name_kana LIKE' => '%'.$keyword.'%'],
                ['first_name_kana LIKE' => '%'.$keyword.'%'],
                ['CONCAT(last_name_kana,first_name_kana) LIKE' => '%'.$keyword.'%'],
            ]]);
        }
        $users = $this->Users->find('all')->where($where);
        return $users;
    }
}
