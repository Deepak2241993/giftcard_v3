<?php

namespace App\Listeners;

use App\Events\TimelineServiceCancel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\GiftcardsNumbers;
use App\Models\Patient;
use App\Models\TimelineEvent;
use App\Models\Giftsend;
use Illuminate\Support\Facades\Log;
class TimelineLinstnerServicecardCancel
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\TimelineServiceCancel  $event
     * @return void
     */
    public function handle(TimelineServiceCancel $event)
{
    try {
        // Create a timeline event
        TimelineEvent::create([
            'patient_id' => $event->result['patient_id'],
            'event_type' => 'Service Cancel',
            'subject' => 'Services Cancel',
            'metadata' => "Service Cancel Transaction ID: " .$event->result['transaction_id']
        ]);

        Log::info('Service Cancel successfully created', ['transaction_id' => $event->result['transaction_id']]);
        
    } catch (\Exception $e) {
        Log::error('Failed to Service Cancel ', [
            'error' => $e->getMessage(),
            'event_data' => $event->result,
        ]);
    }
}

}
