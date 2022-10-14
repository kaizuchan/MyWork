<?php
declare(strict_types=1);

use Migrations\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

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
        $table = $this->table('prefectures', ['id' => false, 'primary_key' => 'id']);
        $table
            ->addColumn('id', 'integer', [
                'default' => null,
                'limit' => MysqlAdapter::INT_TINY,
                'null' => false,
            ])
              ->addColumn('name', 'string')
              ->addColumn('name_kana', 'string')
              ->create();

        //カラムの追加
        $rows = [
            ['id' => 1, 'name' => '北海道', 'name_kana' => 'ホッカイドウ'],
            ['id' => 2, 'name' => '青森県', 'name_kana' => 'アオモリケン'],
            ['id' => 3, 'name' => '岩手県', 'name_kana' => 'イワテケン'],
            ['id' => 4, 'name' => '宮城県', 'name_kana' => 'ミヤギケン'],
            ['id' => 5, 'name' => '秋田県', 'name_kana' => 'アキタケン'],
            ['id' => 6, 'name' => '山形県', 'name_kana' => 'ヤマガタケン'],
            ['id' => 7, 'name' => '福島県', 'name_kana' => 'フクシマケン'],
            ['id' => 8, 'name' => '茨城県', 'name_kana' => 'イバラキケン'],
            ['id' => 9, 'name' => '栃木県', 'name_kana' => 'トチギケン'],
            ['id' => 10, 'name' => '群馬県', 'name_kana' => 'グンマケン'],
            ['id' => 11, 'name' => '埼玉県', 'name_kana' => 'サイタマケン'],
            ['id' => 12, 'name' => '千葉県', 'name_kana' => 'チバケン'],
            ['id' => 13, 'name' => '東京都', 'name_kana' => 'トウキョウト'],
            ['id' => 14, 'name' => '神奈川県', 'name_kana' => 'カナガワケン'],
            ['id' => 15, 'name' => '新潟県', 'name_kana' => 'ニイガタケン'],
            ['id' => 16, 'name' => '富山県', 'name_kana' => 'トヤマケン'],
            ['id' => 17, 'name' => '石川県', 'name_kana' => 'イシカワケン'],
            ['id' => 18, 'name' => '福井県', 'name_kana' => 'フクイケン'],
            ['id' => 19, 'name' => '山梨県', 'name_kana' => 'ヤマナシケン'],
            ['id' => 20, 'name' => '長野県', 'name_kana' => 'ナガノケン'],
            ['id' => 21, 'name' => '岐阜県', 'name_kana' => 'ギフケン'],
            ['id' => 22, 'name' => '静岡県', 'name_kana' => 'シズオカケン'],
            ['id' => 23, 'name' => '愛知県', 'name_kana' => 'アイチケン'],
            ['id' => 24, 'name' => '三重県', 'name_kana' => 'ミエケン'],
            ['id' => 25, 'name' => '滋賀県', 'name_kana' => 'シガケン'],
            ['id' => 26, 'name' => '京都府', 'name_kana' => 'キョウトフ'],
            ['id' => 27, 'name' => '大阪府', 'name_kana' => 'オオサカフ'],
            ['id' => 28, 'name' => '兵庫県', 'name_kana' => 'ヒョウゴケン'],
            ['id' => 29, 'name' => '奈良県', 'name_kana' => 'ナラケン'],
            ['id' => 30, 'name' => '和歌山県', 'name_kana' => 'ワカヤマケン'],
            ['id' => 31, 'name' => '鳥取県', 'name_kana' => 'トットリケン'],
            ['id' => 32, 'name' => '島根県', 'name_kana' => 'シマネケン'],
            ['id' => 33, 'name' => '岡山県', 'name_kana' => 'オカヤマケン'],
            ['id' => 34, 'name' => '広島県', 'name_kana' => 'ヒロシマケン'],
            ['id' => 35, 'name' => '山口県', 'name_kana' => 'ヤマグチケン'],
            ['id' => 36, 'name' => '徳島県', 'name_kana' => 'トクシマケン'],
            ['id' => 37, 'name' => '香川県', 'name_kana' => 'カガワケン'],
            ['id' => 38, 'name' => '愛媛県', 'name_kana' => 'エヒメケン'],
            ['id' => 39, 'name' => '高知県', 'name_kana' => 'コウチケン'],
            ['id' => 40, 'name' => '福岡県', 'name_kana' => 'フクオカケン'],
            ['id' => 41, 'name' => '佐賀県', 'name_kana' => 'サガケン'],
            ['id' => 42, 'name' => '長崎県', 'name_kana' => 'ナガサキケン'],
            ['id' => 43, 'name' => '熊本県', 'name_kana' => 'クマモトケン'],
            ['id' => 44, 'name' => '大分県', 'name_kana' => 'オオイタケン'],
            ['id' => 45, 'name' => '宮崎県', 'name_kana' => 'ミヤザキケン'],
            ['id' => 46, 'name' => '鹿児島県', 'name_kana' => 'カゴシマケン'],
            ['id' => 47, 'name' => '沖縄県', 'name_kana' => 'オキナワケン']
        ];
        $this->insert('prefectures', $rows);
    }
}
