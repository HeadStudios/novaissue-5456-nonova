<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AirCImporter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'air:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync air contacts';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->call('route:clear');
        $this->call('config:clear');
        $this->call('cache:clear');
        $this->call('view:clear');

        app()->call('App\Http\Controllers\PlayAround@air_contacts');

        $this->info('AirContactsCommand executed successfully.');
    }
}
