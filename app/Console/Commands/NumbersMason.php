<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class NumbersMason extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'number:mason';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->comment("Updating UEC");

        $table1Rows = DB::table('touchpoints')->get();

        foreach ($table1Rows as $row) {
            if (strpos($row->journey, 'UEC') !== false) {
                DB::table('touchpoints')
                    ->where('id', $row->id)
                    ->update(['uec' => 1]);
                $this->info("We hear you!");
                $this->table(['id', 'journey', 'uec'], [[$row->id, $row->journey, 1]]);
            }
        }
    }
}
