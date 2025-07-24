<?php

namespace App\Listeners;

use App\Events\TimelineServiceRefund;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\GiftcardsNumbers;
use App\Models\Patient;
use App\Models\TimelineEvent;
use App\Models\Giftsend;
use Illuminate\Support\Facades\Log;
class TimelineLinstnerServicecardRefund
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
     * @param  \App\Events\TimelineServiceRefund  $event
     * @return void
     */
    public function handle(TimelineServiceRefund $event)
    {
        try {
            $refundData = $event->result;
    
            // Create a timeline event with stripped details
            TimelineEvent::create([
                'patient_id' => $refundData['patient_id'] ?? null, // Ensure patient_id exists
                'event_type' => 'Service Refund',
                'subject' => 'Service Refund Processed',
                'metadata' => "Refund ID: " . $refundData['refund_id'] . 
                              ", Amount: $" . ($refundData['amount'] ?? 'N/A') . 
                              ", Status: " . ($refundData['status'] ?? 'unknown'),
            ]);
    
            Log::info('Service Refund successfully created', [
                'refund_id' => $refundData['refund_id'],
                'status' => $refundData['status']
            ]);
            
        } catch (\Exception $e) {
            Log::error('Failed to create Service Refund event', [
                'error' => $e->getMessage(),
                'event_data' => $event->result,  // Safe since sensitive data was stripped earlier
            ]);
        }
    }
    

}
