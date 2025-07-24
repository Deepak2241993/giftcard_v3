<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use app\Events\ServicePurchasesPayment;
use App\Models\GiftcardsNumbers;
use App\Models\Patient;
use App\Models\TimelineEvent;
use App\Models\Giftsend;
use Illuminate\Support\Facades\Log;
use Auth;
class ListenerServicePurchasesPayment
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
     * @param  object  $event
     * @return void
     */
    public function handle(ServicePurchasesPayment $event)
    {


        try {
            // Log activity or store it in the database
            TimelineEvent::create([
                'patient_id' => $event->paymentData['patient_id'],
                'event_type' => "Transaction Completed",
                'subject' => "Payment Done ".$event->paymentData['session_id'],
                'metadata' => "Payment of $"."{$event->paymentData['amount']} USD successfully processed.",
            ]);

            Log::info('Payment activity successfully logged', ['session_id' => $event->paymentData['session_id']]);
        } catch (\Exception $e) {
            Log::error('Failed to log payment activity', ['error' => $e->getMessage()]);
        }

         
        
    }
}

