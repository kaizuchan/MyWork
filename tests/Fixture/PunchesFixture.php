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
                'user_id' => 1,
                'date' => '2022-10-17',
                'time' => '10:10:19',
                'identify' => 1,
                'modified_info' => 1,
            ],
        ];
        parent::init();
    }
}
