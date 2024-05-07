<?php
namespace Nisimpo\Requisition\Test;

class Test extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();

        require_once __DIR__.'/../database/migrations/create_password_resets_table.php';


    }

    public function it_can_create_migration()
    {

    }
}
