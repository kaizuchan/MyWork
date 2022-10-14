<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PunchesFixture
 */
class PunchesFixture extends TestFixture
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
                'user_id' => 'Lorem ipsum dolor sit amet',
                'date' => '2022-10-14',
                'time' => '10:06:59',
                'identify' => 1,
                'punched_by' => 1,
                'modified_info' => 1,
            ],
        ];
        parent::init();
    }
}
