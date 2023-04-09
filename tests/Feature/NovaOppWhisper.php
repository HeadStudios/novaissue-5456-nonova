<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Opps;
use App\Models\Campaign;
use App\Nova\Actions\AttachContacts;
use App\Nova\Actions\SendContract;
use Illuminate\Support\Collection;


use JoshGaber\NovaUnit\Actions\NovaActionTest;

class NovaOppWhisper extends TestCase
{
    use NovaActionTest;
    /**
     * A basic feature test example. 
     *
     * @return void
     */
    public function test_example()
    {
        $action = $this->novaAction(SendContract::class);

        $opp = Opps::find(42);
        $collection = new Collection([$opp]);

        $response = $action->handle([], $collection);

        $response->assertMessageContains('ENVTESTER!');
    }
}
