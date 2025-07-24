<?php

namespace App\Listeners;

use App\Events\TimelineServiceRedeem;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\GiftcardsNumbers;
use App\Models\Patient;
use App\Models\TimelineEvent;
use App\Models\Giftsend;
use Illuminate\Support\Facades\Log;
class TimelineLinstnerServicecardRedeem
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
     * @param  \App\Events\TimelineServiceRedeem  $event
     * @return void
     */
    public function handle(TimelineServiceRedeem $event)
{
    try {
        // Create a timeline event
        TimelineEvent::create([
            'patient_id' => $event->result['patient_id'],
            'event_type' => 'Service Redeem',
            'subject' => 'Services Redeem',
            'metadata' => "Service Redeem Transaction ID: " .$event->result['transaction_id']
        ]);

        Log::info('Service Redeem successfully created', ['transaction_id' => $event->result['transaction_id']]);
        
    } catch (\Exception $e) {
        Log::error('Failed to Service Redeem ', [
            'error' => $e->getMessage(),
            'event_data' => $event->result,
        ]);
    }
}

}
