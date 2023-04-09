<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Contact;
use Propaganistas\LaravelPhone\PhoneNumber;
use Illuminate\Support\Facades\DB;
use App\Hydraulics\MMSHolder;

class SyncSMSUnsub extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:sms ';

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
    $records = DB::connection('remote_mysql')
        ->table('Message')->where('status', 'Received')
        ->where(function ($query) {
            $query->where(DB::raw('LOWER(message)'), 'REGEXP', '\\b(stop|no|remove|wrong|unsubscribe)\\b')
                ->orWhere(DB::raw('LOWER(message)'), 'REGEXP', '\\b(stop|no|remove|wrong|unsubscribe)[[:punct:]]')
                ->orWhere(DB::raw('LOWER(message)'), 'REGEXP', '[[:punct:]](stop|no|remove|wrong|unsubscribe)\\b');
        })->get();

    $val = '';

    foreach ($records as $record) {
        if (!ctype_alpha($record->number)) {
            try {
                $remote_mob = PhoneNumber::make($record->number, 'AU')->formatE164();
            } catch (\Exception $e) {
                // Put here to find bad numbers
                continue;
            }

            $contacts = Contact::whereRaw('LOWER(mobile) = LOWER(?)', [$remote_mob])->get();
            dump("The message we're receiving is: ");
            dump($record);
            foreach ($contacts as $contact) {
                 $contact->unsubscribed = 1;
                 $contact->save();
                // MMSHolder::unsubscribeThem($remote_mob, $contact->name);
                $this->info('So we are unsubscribing: ' . $contact->name);
            }
        }
    }

    return Command::SUCCESS;
}
}
