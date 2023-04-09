<?php

namespace App\Observers;

use App\Models\Touchpoint;
use Carbon\Carbon;

class TouchpointObserver
{
    /**
     * Handle the Touchpoint "created" event.
     *
     * @param  \App\Models\Touchpoint  $touchpoint
     * @return void
     */
    public function created(Touchpoint $touchpoint)
    {
        //
    }

    /**
     * Handle the Touchpoint "updated" event.
     *
     * @param  \App\Models\Touchpoint  $touchpoint
     * @return void
     */
    public function updated(Touchpoint $touchpoint)
    {
        // Check if the call_result has been set to 'Not Interested'
        if ($touchpoint->isDirty('call_result') && $touchpoint->call_result === 'Not Interested') {
            dump("We getting dirty in here");
            // Delete all future Touchpoint models with the same contact_id as the updated Touchpoint
            $this->deleteFutureTouchpoints($touchpoint);
        }
    }

    /**
     * Handle the Touchpoint "deleted" event.
     *
     * @param  \App\Models\Touchpoint  $touchpoint
     * @return void
     */
    public function deleted(Touchpoint $touchpoint)
    {
        //
    }

    /**
     * Handle the Touchpoint "restored" event.
     *
     * @param  \App\Models\Touchpoint  $touchpoint
     * @return void
     */
    public function restored(Touchpoint $touchpoint)
    {
        //
    }

    /**
     * Handle the Touchpoint "force deleted" event.
     *
     * @param  \App\Models\Touchpoint  $touchpoint
     * @return void
     */
    public function forceDeleted(Touchpoint $touchpoint)
    {
        //
    }

    /**
     * Delete all future Touchpoint models with the same contact_id as the provided Touchpoint.
     *
     * @param  \App\Models\Touchpoint  $touchpoint
     * @return void
     */
    protected function deleteFutureTouchpoints(Touchpoint $touchpoint)
    {
        Touchpoint::where('contact_id', $touchpoint->contact_id)
            ->where('date', '>', Carbon::now())
            ->delete();

        dump("We just deleted in here");
    }
}
