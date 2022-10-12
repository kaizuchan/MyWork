<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class Prefectures extends AbstractMigration
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
        $table = $this->table('prefectures');
        $table
              ->addColumn('name', 'string')
              ->addColumn('name_kana', 'string')
              ->create();
    }
}
