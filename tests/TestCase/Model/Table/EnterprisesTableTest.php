<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EnterprisesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EnterprisesTable Test Case
 */
class EnterprisesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\EnterprisesTable
     */
    protected $Enterprises;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.Enterprises',
        'app.Users',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Enterprises') ? [] : ['className' => EnterprisesTable::class];
        $this->Enterprises = $this->getTableLocator()->get('Enterprises', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Enterprises);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\EnterprisesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
