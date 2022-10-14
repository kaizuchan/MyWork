<?php
declare(strict_types=1);

use Migrations\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class Users extends AbstractMigration
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
        $table = $this->table('users', ['id' => false, 'primary_key' => 'id']);
        $table
            ->addColumn('id', 'integer', [
                'default' => null,
                'identity' => true,
                'limit' => MysqlAdapter::INT_BIG,
                'null' => false,
            ])
            ->addColumn('enterprise_id', 'integer', [
                'default' => null,
                'limit' => MysqlAdapter::INT_BIG,
                'null' => false,
            ])
            ->addColumn('employee_id', 'string')
            ->addColumn('last_name', 'string')
            ->addColumn('first_name', 'string')
            ->addColumn('last_name_kana', 'string')
            ->addColumn('first_name_kana', 'string')
            ->addColumn('phone_number', 'string')
            ->addColumn('email', 'string')
            ->addColumn('gender', 'boolean')
            ->addColumn('birthday', 'date')
            ->addColumn('postalcode', 'string')
            ->addColumn('prefecture_id', 'integer', [
                'default' => null,
                'limit' => MysqlAdapter::INT_TINY,
                'null' => false,
            ])
            ->addColumn('city', 'string')
            ->addColumn('block', 'string')
            ->addColumn('building', 'string', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('role', 'integer', [
                'default' => 1,
                'limit' => MysqlAdapter::INT_TINY,
                'null' => false,
            ])
            ->addColumn('password', 'string')
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
            ->addForeignKey('enterprise_id', 'enterprises', 'id')
            ->addForeignKey('prefecture_id', 'prefectures', 'id')
            ->create();

            //カラムの追加
            // password = p@ssw0rd
            $password = '$2y$10$chRR/dnRQgyJ4gVlscsIc.aiDsFs1QUT/.AiCfPf.Rru5LixtAfP6';
            $rows = [
                    "enterprise_id" => 2,
                    "employee_id" => "masaru",
                    "last_name" => "谷",
                    "first_name" => "まさる",
                    "last_name_kana" => "タニ",
                    "first_name_kana" => "マサル",
                    "phone_number" => "052-551-1001",
                    "email" => "nagoya-hal@hal.ac.jp",
                    "gender" => 0,
                    "birthday" => 1936-01-01,
                    "postalcode" => "4500002",
                    "prefecture_id" => 23,
                    "city" => "名古屋市中村区",
                    "block" => "名駅4-27-1",
                    "building" => "スパイラルタワーズ",
                    "role" => 2,
                    "password" => $password
            ];
            $this->insert('users', $rows);
    }
}
