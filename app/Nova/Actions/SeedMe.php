<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;
use Brightspot\Nova\Tools\DetachedActions\DetachedAction;
use Illuminate\Support\Facades\Artisan;
use Database\Seeders\TouchpointSeeder;
use App\Models\Contact;
use Laravel\Nova\Fields\Number;
use App\Models\Touchpoint;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Laravel\Nova\Fields\Select;




class SeedMe extends DetachedAction
{
    use InteractsWithQueue, Queueable;

    public function label()
    {
        return __('Seed Me');
    }

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {

        if ($fields->type === 'freezer') {
            $touchpoints = DB::select("
    SELECT
        c.air_id,
        c.name,
        IFNULL(u.total_consecutive_voicemails, 0) AS total_consecutive_voicemails
    FROM contacts c
    LEFT JOIN (
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
                WHERE call_result NOT IN ('Not Interested', 'Disqualified', 'Wrong Data', 'Redirect')
                  AND date <= NOW()
                ORDER BY air_contact_id, date
            ) AS t
            WHERE call_result = 'Voicemail'
            GROUP BY air_contact_id, voicemail_group
        ) AS u
        GROUP BY air_contact_id
    ) AS u ON c.air_id = u.air_contact_id
    WHERE NOT EXISTS (
        SELECT 1
        FROM touchpoints
        WHERE air_contact_id = c.air_id
          AND call_result IN ('Not Interested', 'Disqualified', 'Wrong Data', 'Redirect')
    )
    AND NOT EXISTS (
        SELECT 1
        FROM touchpoints
        WHERE air_contact_id = c.air_id
          AND date >= NOW()
    )
    AND NOT EXISTS (
        SELECT 1
        FROM touchpoints
        WHERE air_contact_id = c.air_id
          AND DATE(date) = DATE(NOW())
    )
    AND c.city NOT LIKE '%Texas%'
    AND TIMESTAMP(CONVERT_TZ(UTC_TIMESTAMP(), 'UTC', c.timezone)) >= TIMESTAMP(DATE(CONVERT_TZ(UTC_TIMESTAMP(), 'UTC', c.timezone)), '8:00:00')
    AND TIMESTAMP(CONVERT_TZ(UTC_TIMESTAMP(), 'UTC', c.timezone)) < TIMESTAMP(DATE(CONVERT_TZ(UTC_TIMESTAMP(), 'UTC', c.timezone)), '18:00:00')
    ORDER BY total_consecutive_voicemails ASC, c.air_id ASC
    
LIMIT ".$fields->souls.";
");

    foreach ($touchpoints as $touchpoint) {

        dump("Touchpoing iiiiis");
        dump($touchpoint);
        

        $newTouchpoint = new Touchpoint;
        $newTouchpoint->air_contact_id = $touchpoint->air_id;
        $newTouchpoint->date = now()->toDateString();
        $newTouchpoint->save();
    }
        } elseif ($fields->type === 'hotones') {
            $contacts = Contact::whereHas('touchpoints', function ($query) {
                $query->where('journey', 'LIKE', '%UEC%')
                    ->where('call_result', '<>', 'Not Interested')
                    ->where('date', '<', Carbon::now());
            })->take($fields->souls)->get();

            dump("Contacts returned are: ");
            dump($contacts);

            foreach($contacts as $contact) {

                $newTouchpoint = new Touchpoint;
                $newTouchpoint->air_contact_id = $contact->air_id;
                $newTouchpoint->date = now()->toDateString();
                $newTouchpoint->save();

            }
        }

        
        
    }

    /**
     * Get the fields available on the action.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [

            Select::make('Type', 'type')->options([
                'freezer' => 'Freezer',
                'hotones' => 'Hot Ones',
            ])->default('freezer')->displayUsingLabels(),
            Number::make('Souls')->default(25),

        ];
    }
}
