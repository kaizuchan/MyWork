<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

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
        $table = $this->table('users');
        $table
              ->addColumn('enterprise_id', 'integer')
              ->addColumn('employee_id', 'string')
              ->addColumn('last_name', 'string')
              ->addColumn('first_name', 'string')
              ->addColumn('last_name_kana', 'string')
              ->addColumn('first_name_kana', 'string')
              ->addColumn('phone_number', 'string')
              ->addColumn('email', 'string')
              ->addColumn('gender', 'integer')
              ->addColumn('birthday', 'date')
              ->addColumn('postalcode', 'string')
              ->addColumn('prefecture_id', 'integer')
              ->addColumn('city', 'string')
              ->addColumn('block', 'string')
              ->addColumn('building', 'string')
              ->addColumn('role', 'integer')
              ->addColumn('password', 'string')
              ->addColumn('created_at', 'datetime')
              ->addColumn('modified_at', 'datetime')
              ->addColumn('deleted_at', 'datetime')
              ->create();
    }
}
