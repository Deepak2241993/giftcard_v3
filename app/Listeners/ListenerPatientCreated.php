<?php
namespace App\Listeners;

use App\Events\EventPatientCreated;
use App\Models\TimelineEvent;
use Illuminate\Support\Facades\Log;

class ListenerPatientCreated
{
    public function handle(EventPatientCreated $event)
    {
        try {
            TimelineEvent::create([
                'patient_id' => $event->data->patient_login_id ?? null,
                'event_type' => "Patient Created",
                'subject' => "Patient Created",
                'metadata' => "Patient Created at Forever Medspa Wellness Center at: " . now(),
            ]);

            Log::info('Patient Created successfully for patient ID: ' . ($event->data->patient_login_id ?? 'Unknown'));
        } catch (\Exception $e) {
            Log::error('Failed to log Patient Created activity', [
                'error' => $e->getMessage(),
                'patient_data' => $event->data
            ]);
        }
    }
}
