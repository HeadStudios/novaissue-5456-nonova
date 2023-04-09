<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;



class SendPortalSync extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        foreach($models as $model) {

            $parsedown = new \Parsedown();
            //$content = $parsedown->text($model->copy);
            $now = Carbon::now();

            $email_body = preg_replace('/{{link}}/i', $model->full_url, $model->email_body);
            
            
            $email_body = $parsedown->text($email_body);
            
            

            $data = [
                'workspace_id' => 1,
                'name' => $model->headline,
                'status_id' => 1,
                'template_id' =>1,
                'email_service_id' => 2,
                'subject' => $model->email_subject,
                'content' => $email_body,
                'from_name' => 'Kosta Kondratenko',
                'from_email' => 'kosta@headstudios.com.au',
                'is_open_tracking' => 1,
                'is_click_tracking' => 1,
                'save_as_draft' => 1,
                'send_to_all' => 0,
                'created_at' => $now,
                'updated_at' => $now,
                'scheduled_at' => $now,
            ];
            
            $name = $model->headline;

            if($model->sendportal_id) {

                
                

                $insert_id = DB::table('sendportal_campaigns')->updateOrInsert(
                    ['id' => $model->sendportal_id],
                    $data
                );
            
        } else {

            $insert_id = DB::table('sendportal_campaigns')->updateOrInsert(
                ['name' => $name],
                $data
            );

        }

         
            
            if ($insert_id) {
                $model->sendportal_id = $insert_id;
                $model->save();
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
        return [];
    }
}
