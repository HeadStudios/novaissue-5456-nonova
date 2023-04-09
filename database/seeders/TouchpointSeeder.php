<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Touchpoint;
use Illuminate\Support\Facades\DB;
use App\Models\Contact;

class TouchpointSeeder extends Seeder
{


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $souls = 5;

        $contacts = Contact::all();
        
        $touchpoints = DB::select("
        SELECT
    air_contact_id,
    SUM(consecutive_voicemails) AS total_consecutive_voicemails
FROM (
    SELECT
        air_contact_id,
        COUNT(*) AS consecutive_voicemails
    FROM (
        SELECT
            *,
            DATE(date) - INTERVAL @rank:=IF(@prev_contact = air_contact_id AND call_result = 'Voicemail', @rank + 1, 1) DAY AS voicemail_group,
            @prev_contact:=air_contact_id
        FROM touchpoints
        CROSS JOIN (SELECT @rank:=0, @prev_contact:=0) AS vars
        WHERE call_result NOT IN ('Not Interested', 'Disqualified')
          AND date <= NOW()
          AND NOT (air_contact_id IN (SELECT air_contact_id FROM touchpoints WHERE DATE(date) = CURDATE()))
        ORDER BY air_contact_id, date
    ) AS t
    WHERE call_result = 'Voicemail'
    GROUP BY air_contact_id, voicemail_group
) AS u
GROUP BY air_contact_id
ORDER BY total_consecutive_voicemails ASC
LIMIT 10;
    ");

    dump("The full shebang of touchpoitns are: ");
    dump($touchpoints);

    foreach ($touchpoints as $touchpoint) {
        

        $newTouchpoint = new Touchpoint;
        $newTouchpoint->air_contact_id = $touchpoint->air_contact_id;
        $newTouchpoint->date = now()->toDateString();
        $newTouchpoint->save();
    }

        
    }
}
