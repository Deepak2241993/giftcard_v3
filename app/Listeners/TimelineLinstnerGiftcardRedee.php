<?php

namespace App\Listeners;

use App\Events\TimelineGiftcardRedeem;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\GiftcardsNumbers;
use App\Models\Patient;
use App\Models\TimelineEvent;
use App\Models\Giftsend;
use Illuminate\Support\Facades\Log;
class TimelineLinstnerGiftcardRedee
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
     * @param  \App\Events\TimelineGiftcardRedeem  $event
     * @return void
     */
    public function handle(TimelineGiftcardRedeem $event)
{
    try {
        // Ensure the user_id exists in the event result
        $patient_id = $event->result['user_id'] ?? null;

        if (!$patient_id) {
            Log::error('Missing user ID in event data');
            return;
        }

        // Fetch the gift card record using the provided ID
        $giftcardDate = Giftsend::where('id', $patient_id)->first();

        if (!$giftcardDate) {
            Log::error('Gift card data not found', ['user_id' => $patient_id]);
            return;
        }

        // Ensure required fields are present
        $gift_send_to = $giftcardDate->gift_send_to ?? null;

        if (!$gift_send_to) {
            Log::error('Giftcard data is missing required gift_send_to information.');
            return;
        }

        // Create a timeline event
        TimelineEvent::create([
            'patient_id' => $gift_send_to,
            'event_type' => $event->result['event_type'],
            'subject' => $event->result['subject'],
            'metadata' => $event->result['metadata']
        ]);

        Log::info('Timeline event successfully created', ['transaction_id' => $event->result['transaction_id']]);
        
    } catch (\Exception $e) {
        Log::error('Failed to create timeline event for gift card redemption', [
            'error' => $e->getMessage(),
            'event_data' => $event->result,
        ]);
    }
}

}
