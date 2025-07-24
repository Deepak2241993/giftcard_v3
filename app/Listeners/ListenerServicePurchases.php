<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use app\Events\ServicePurchases;
use App\Models\GiftcardsNumbers;
use App\Models\Patient;
use App\Models\TimelineEvent;
use App\Models\Giftsend;
use Illuminate\Support\Facades\Log;
use Auth;
class ListenerServicePurchases
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
    public function handle(ServicePurchases $event)
    {


        try {
            // Log activity or store it in the database
            TimelineEvent::create([
                'patient_id' => $event->orderData['patient_login_id'],
                'event_type' => "Order Placed",
                'subject' => "Order Placed ".$event->orderData['order_id'],
                'metadata' => "Order Placed with Order No: " . $event->orderData['order_id'],
            ]);

            Log::info('Service purchase activity logged successfully');
        } catch (\Exception $e) {
            Log::error('Failed to log service purchase activity', ['error' => $e->getMessage()]);
        }

         
        
    }
}

