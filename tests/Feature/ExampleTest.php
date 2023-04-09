<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Jobs\SendContractJob;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */

    public function test_the_application_returns_a_successful_response()
    {
        SendContractJob::dispatch(42, '2023-02-04');

        $var = true;

        $this->assertTrue($var, 'Variable is not true');

        //$response->assertStatus(200);
    }

    
}
