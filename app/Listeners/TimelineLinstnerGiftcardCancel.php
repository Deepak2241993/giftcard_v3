<?php

namespace App\Listeners;

use App\Events\TimelineGiftcardCancel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\GiftcardsNumbers;
use App\Models\Patient;
use App\Models\TimelineEvent;
use App\Models\Giftsend;
use Illuminate\Support\Facades\Log;
class TimelineLinstnerGiftcardCancel
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
     * @param  \App\Events\TimelineGiftcardCancel  $event
     * @return void
     */
    public function handle(TimelineGiftcardCancel $event)
{
    try {
        // Use object properties directly instead of array keys
        $patient_id = $event->result->user_id ?? null;

        if (!$patient_id) {
            Log::error('Missing user ID in event data');
            return;
        }

        // Fetch the gift card record using the provided patient ID
        $giftcardDate = Giftsend::where('id', $patient_id)->first();

        if (!$giftcardDate) {
            Log::error('Gift card data not found', ['user_id' => $patient_id]);
            return;
        }

        $gift_send_to = $giftcardDate->gift_send_to ?? null;
        $transaction_id = $giftcardDate->transaction_id ?? 'N/A';

        if (!$gift_send_to) {
            Log::error('Giftcard data is missing required gift_send_to information.');
            return;
        }

        // Create a timeline event
        TimelineEvent::create([
            'patient_id' => $gift_send_to,
            'event_type' => 'Giftcard Cancel',
            'subject' => 'Giftcards Cancel',
            'metadata' => "Giftcard Cancel Transaction ID: " . ($event->result->transaction_id ?? 'N/A')
        ]);

        Log::info('Timeline event successfully created', ['transaction_id' => $event->result->transaction_id ?? 'N/A']);
        
    } catch (\Exception $e) {
        Log::error('Failed to create timeline event for gift card cancellation', [
            'error' => $e->getMessage(),
            'event_data' => $event->result,
        ]);
    }
}


}
