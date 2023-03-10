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

    /**
     * Generate a raw DB query to search for a JSON field.
     *
     * @param  array|json  $json
     *
     * @throws \Exception
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function castToJson($json)
    {
        // Convert from array to json and add slashes, if necessary.
        if (is_array($json)) {
            $json = addslashes(json_encode($json));
        }
        // Or check if the value is malformed.
        elseif (is_null($json) || is_null(json_decode($json))) {
            throw new \Exception('A valid JSON string was not provided.');
        }
        return \DB::raw("CAST('{$json}' AS JSON)");
    }
}
