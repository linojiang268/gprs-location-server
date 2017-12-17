<?php

namespace Tests\GL;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    /**
     * @inheritdoc
     */
    protected function tearDown()
    {
        parent::tearDown();

        // reset current time in case it's bended
        Carbon::setTestNow(null);
    }
}
