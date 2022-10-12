<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

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
        $table = $this->table('enterprises');
        $table
              ->addColumn('login_id', 'string')
              ->addColumn('name', 'string')
              ->addColumn('name_kana', 'string')
              ->addColumn('role', 'integer')
              ->addColumn('created_at', 'datetime')
              ->addColumn('modified_at', 'datetime')
              ->addColumn('deleted_at', 'datetime')
              ->create();
    }
}
