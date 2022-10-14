<?php
declare(strict_types=1);

use Migrations\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class Enterprises extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        // テーブルの作成
        $table = $this->table('enterprises', ['id' => false, 'primary_key' => 'id']);
        $table
            ->addColumn('id', 'integer', [
                'default' => null,
                'limit' => MysqlAdapter::INT_BIG,
                'null' => false,
            ])
            ->addColumn('login_id', 'string')
            ->addColumn('name', 'string')
            ->addColumn('name_kana', 'string')
            ->addColumn('role', 'integer', [
                'default' => 1,
                'limit' => MysqlAdapter::INT_TINY,
                'null' => false,
            ])
            ->addColumn('created_at', 'datetime', [
                'default' => 'CURRENT_TIMESTAMP',
                'null' => false,
            ])
            ->addColumn('modified_at', 'datetime', [
                'default' => 'CURRENT_TIMESTAMP',
                'null' => false,
            ])
            ->addColumn('deleted_at', 'datetime', [
                'default' => null,
                'null' => true,
            ])
            ->create();

            // カラムの追加
            $rows = [
                [
                'id' => 1, 
                'login_id' => 'hal.tokyo',
                'name' => 'HAL東京',
                'name_kana' => 'ハルトウキョウ'
                ],
                [
                'id' => 2, 
                'login_id' => 'hal.nagoya',
                'name' => 'HAL名古屋',
                'name_kana' => 'ハルナゴヤ'
                ],
                [
                'id' => 3, 
                'login_id' => 'hal.osaka',
                'name' => 'HAL大阪',
                'name_kana' => 'ハルオオサカ'
                ]
            ];
            $this->insert('enterprises', $rows);
    }
}
