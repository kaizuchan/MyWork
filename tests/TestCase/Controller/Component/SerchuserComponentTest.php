<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Component;

use App\Controller\Component\SerchUserComponent;
use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Component\SerchUserComponent Test Case
 */
class SerchUserComponentTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Controller\Component\SerchUserComponent
     */
    protected $SerchUser;

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->SerchUser = new SerchUserComponent($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->SerchUser);

        parent::tearDown();
    }
}
