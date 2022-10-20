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
            $password = '$2y$10$ETyJeKcwexrb/INDLOWN0OXPR7xDShEolp20VQAPgJ7PgRDs7Qzii';
            $rows = [
                [
                    "enterprise_id" => 2,
                    "employee_id" => "20221031",
                    "last_name" => "谷",
                    "first_name" => "まさる",
                    "last_name_kana" => "タニ",
                    "first_name_kana" => "マサル",
                    "phone_number" => "052-551-1001",
                    "email" => "nagoya-hal@hal.ac.jp",
                    "gender" => 0,
                    "birthday" => '1936-01-01',
                    "postalcode" => "4500002",
                    "prefecture_id" => 23,
                    "city" => "名古屋市中村区",
                    "block" => "名駅4-27-1",
                    "building" => "スパイラルタワーズ",
                    "role" => 2,
                    "password" => $password
                ],
                [
                    "enterprise_id" => 2,
                    "employee_id" => "99872",
                    "last_name" => "樋口",
                    "first_name" => "芽愛子",
                    "last_name_kana" => "ヒグチ",
                    "first_name_kana" => "メイコ",
                    "phone_number" => "0772-52-2926",
                    "email" => "meiko8858@nejk.ge.ha",
                    "gender" => 1,
                    "birthday" => '2002-4-14',
                    "postalcode" => "4530805",
                    "prefecture_id" => 23,
                    "city" => "名古屋市中村区",
                    "block" => "深川町",
                    "building" => "ロイヤルパレス深川町310",
                    "role" => 1,
                    "password" => $password
                ],[
                    "enterprise_id" => 2,
                    "employee_id" => "55668",
                    "last_name" => "赤木",
                    "first_name" => "佳那子",
                    "last_name_kana" => "アカギ",
                    "first_name_kana" => "カナコ",
                    "phone_number" => "053-571-4347",
                    "email" => "Kanako_Akagi@bocckjos.ba.klz",
                    "gender" => 1,
                    "birthday" => '1964-3-19',
                    "postalcode" => "6150816",
                    "prefecture_id" => 26,
                    "city" => "京都市右京区",
                    "block" => "西京極東町",
                    "building" => "西京極東町コンフォート419",
                    "role" => 1,
                    "password" => $password
                ],[
                    "enterprise_id" => 2,
                    "employee_id" => "48059",
                    "last_name" => "伊東",
                    "first_name" => "幸作",
                    "last_name_kana" => "イトウ",
                    "first_name_kana" => "コウサク",
                    "phone_number" => "088-766-7803",
                    "email" => "kousaku30802@aodbb.keo",
                    "gender" => 0,
                    "birthday" => '1981-5-20',
                    "postalcode" => "9708004",
                    "prefecture_id" => 7,
                    "city" => "いわき市",
                    "block" => "平下平窪中島町",
                    "building" => "",
                    "role" => 1,
                    "password" => $password
                ],[
                    "enterprise_id" => 2,
                    "employee_id" => "85422",
                    "last_name" => "今川",
                    "first_name" => "孝吉",
                    "last_name_kana" => "イマガワ",
                    "first_name_kana" => "コウキチ",
                    "phone_number" => "0848-16-1360",
                    "email" => "koukichi61013@gkytvfhbi.leb",
                    "gender" => 0,
                    "birthday" => '1987-3-26',
                    "postalcode" => "9100357",
                    "prefecture_id" => 18,
                    "city" => "坂井市",
                    "block" => "丸岡町儀間",
                    "building" => "タワー丸岡町儀間117",
                    "role" => 1,
                    "password" => $password
                ],[
                    "enterprise_id" => 2,
                    "employee_id" => "84466",
                    "last_name" => "神保",
                    "first_name" => "勇夫",
                    "last_name_kana" => "ジンボ",
                    "first_name_kana" => "イサオ",
                    "phone_number" => "099-447-7062",
                    "email" => "isao442@vsulghbx.ftg",
                    "gender" => 0,
                    "birthday" => '1994-8-7',
                    "postalcode" => "6302201",
                    "prefecture_id" => 29,
                    "city" => "山辺郡山添村",
                    "block" => "峰寺",
                    "building" => "峰寺アパート407",
                    "role" => 1,
                    "password" => $password
                ],[
                    "enterprise_id" => 2,
                    "employee_id" => "21125",
                    "last_name" => "長浜",
                    "first_name" => "晴夫",
                    "last_name_kana" => "ナガハマ",
                    "first_name_kana" => "ハルオ",
                    "phone_number" => "045-261-3722",
                    "email" => "haruo13837@yyshi.xh",
                    "gender" => 0,
                    "birthday" => '1981-6-17',
                    "postalcode" => "5200004",
                    "prefecture_id" => 25,
                    "city" => "大津市",
                    "block" => "見世",
                    "building" => "",
                    "role" => 1,
                    "password" => $password
                ],[
                    "enterprise_id" => 2,
                    "employee_id" => "17856",
                    "last_name" => "田所",
                    "first_name" => "孝行",
                    "last_name_kana" => "タドコロ",
                    "first_name_kana" => "タカユキ",
                    "phone_number" => "04-3519-1498",
                    "email" => "takayuki54023@fdiuoronxk.hcx.sh",
                    "gender" => 0,
                    "birthday" => '1992-8-3',
                    "postalcode" => "9140028",
                    "prefecture_id" => 18,
                    "city" => "敦賀市",
                    "block" => "中",
                    "building" => "中レジデンス204",
                    "role" => 1,
                    "password" => $password
                ],[
                    "enterprise_id" => 2,
                    "employee_id" => "99558",
                    "last_name" => "芳賀",
                    "first_name" => "雪子",
                    "last_name_kana" => "ハガ",
                    "first_name_kana" => "ユキコ",
                    "phone_number" => "093-621-8400",
                    "email" => "yukiko91257@qrkzj.ypr",
                    "gender" => 1,
                    "birthday" => '1973-5-13',
                    "postalcode" => "7793620",
                    "prefecture_id" => 36,
                    "city" => "美馬市",
                    "block" => "脇町上ノ原",
                    "building" => "",
                    "role" => 1,
                    "password" => $password
                ],[
                    "enterprise_id" => 2,
                    "employee_id" => "84089",
                    "last_name" => "嶋田",
                    "first_name" => "麻里子",
                    "last_name_kana" => "シマダ",
                    "first_name_kana" => "マリコ",
                    "phone_number" => "096-124-7259",
                    "email" => "mariko951@cgfhztwyy.jh",
                    "gender" => 1,
                    "birthday" => '1973-5-20',
                    "postalcode" => "8010821",
                    "prefecture_id" => 40,
                    "city" => "北九州市門司区",
                    "block" => "黒川",
                    "building" => "",
                    "role" => 1,
                    "password" => $password
                ],[
                    "enterprise_id" => 2,
                    "employee_id" => "41048",
                    "last_name" => "森下",
                    "first_name" => "璃子",
                    "last_name_kana" => "モリシタ",
                    "first_name_kana" => "リコ",
                    "phone_number" => "073-841-3922",
                    "email" => "rikomorishita@blfal.yayzr.bdc",
                    "gender" => 1,
                    "birthday" => '1970-4-20',
                    "postalcode" => "6250083",
                    "prefecture_id" => 26,
                    "city" => "舞鶴市",
                    "block" => "余部上",
                    "building" => "余部上アパート319",
                    "role" => 1,
                    "password" => $password
                ],
            ];
            $this->insert('users', $rows);
    }
}
