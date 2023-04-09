<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Campaign;
use App\Nova\Actions\SyncContactsFromAirtable;
use App\Nova\Actions\AttachContacts;



use JoshGaber\NovaUnit\Actions\NovaActionTest;

class NovaWhisper extends TestCase
{
    use NovaActionTest;
    /**
     * A basic feature test example. 
     *
     * @return void
     */
    public function test_example()
    {
        $action = $this->novaAction(AttachContacts::class);

        $camp = Campaign::find(306);

        $response = $action->handle(['top'=>10,'left'=>10,'size'=>24], $camp);

        $response->assertMessageContains('Coopa');
    }
}
