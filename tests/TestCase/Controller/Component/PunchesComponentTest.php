<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Component;

use App\Controller\Component\PunchesComponent;
use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Component\PunchesComponent Test Case
 */
class PunchesComponentTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Controller\Component\PunchesComponent
     */
    protected $Punches;

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->Punches = new PunchesComponent($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Punches);

        parent::tearDown();
    }
}
