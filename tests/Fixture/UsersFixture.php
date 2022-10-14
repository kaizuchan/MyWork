<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UsersFixture
 */
class UsersFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'enterprise_id' => 1,
                'employee_id' => 'Lorem ipsum dolor sit amet',
                'last_name' => 'Lorem ipsum dolor sit amet',
                'first_name' => 'Lorem ipsum dolor sit amet',
                'last_name_kana' => 'Lorem ipsum dolor sit amet',
                'first_name_kana' => 'Lorem ipsum dolor sit amet',
                'phone_number' => 'Lorem ipsum dolor sit amet',
                'email' => 'Lorem ipsum dolor sit amet',
                'gender' => 1,
                'birthday' => '2022-10-14',
                'postalcode' => 'Lorem ipsum dolor sit amet',
                'prefecture_id' => 1,
                'city' => 'Lorem ipsum dolor sit amet',
                'block' => 'Lorem ipsum dolor sit amet',
                'building' => 'Lorem ipsum dolor sit amet',
                'role' => 1,
                'password' => 'Lorem ipsum dolor sit amet',
                'created_at' => '2022-10-14 15:08:18',
                'modified_at' => '2022-10-14 15:08:18',
                'deleted_at' => '2022-10-14 15:08:18',
            ],
        ];
        parent::init();
    }
}
