<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * EnterprisesFixture
 */
class EnterprisesFixture extends TestFixture
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
                'login_id' => 'Lorem ipsum dolor sit amet',
                'name' => 'Lorem ipsum dolor sit amet',
                'name_kana' => 'Lorem ipsum dolor sit amet',
                'role' => 1,
                'created_at' => '2022-10-14 14:54:27',
                'modified_at' => '2022-10-14 14:54:27',
                'deleted_at' => '2022-10-14 14:54:27',
            ],
        ];
        parent::init();
    }
}
