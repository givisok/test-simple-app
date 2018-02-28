<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected $customSeeders = [];

    use CreatesApplication;

    /**
     * @throws \Exception
     */
    public function setUp()
    {
        parent::setUp();
        // Make migrations in transaction for speed up :) good hack
        // but in some cases we can have a problems ... but not in simple cases
        \DB::beginTransaction();
        $this->artisan('migrate');
        $this->artisan('db:seed');
        foreach ($this->customSeeders as $seederClass) {
            $this->runAdditionalSeed($seederClass);
        }
    }

    /**
     *
     */
    public function tearDown()
    {
        // Clear database before next test
        \DB::rollBack();
        parent::tearDown();
    }

    /**
     * @param string $class
     */
    protected function runAdditionalSeed(string $class)
    {
        $this->artisan('db:seed', ['--class' => $class]);
    }
}
