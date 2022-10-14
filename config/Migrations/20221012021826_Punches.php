<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class Punches extends AbstractMigration
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
        $table = $this->table('punches');
        $table
              ->addColumn('user_id', 'string')
              ->addColumn('date', 'date')
              ->addColumn('time', 'time')
              ->addColumn('identify', 'integer')
              ->addColumn('punched_by', 'integer')
              ->addColumn('modified_info', 'boolean')
              ->create();
    }
}
