<?php

namespace Tests;

use Illuminate\Foundation\Testing\{
    TestCase as BaseTestCase,
    RefreshDatabase,
    WithFaker,
};

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, RefreshDatabase, WithFaker;
}
