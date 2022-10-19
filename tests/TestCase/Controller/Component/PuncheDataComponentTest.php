<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Component;

use App\Controller\Component\PuncheDataComponent;
use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Component\PuncheDataComponent Test Case
 */
class PuncheDataComponentTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Controller\Component\PuncheDataComponent
     */
    protected $PuncheData;

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->PuncheData = new PuncheDataComponent($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->PuncheData);

        parent::tearDown();
    }
}
