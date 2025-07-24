<?php

namespace App\Listeners;

use App\Events\EventPatientLogout;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\TimelineEvent;

class ListnerPatientLogout
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
     * @param  \App\Events\EventPatientLogout  $event
     * @return void
     */
    public function handle(EventPatientLogout $event)
    {
        $timelineEvent = TimelineEvent::create([
            'patient_id' => $event->username,
            'event_type' => 'Logout',
            'subject' => 'Account Logout',
            'metadata' => "You have successfully logout"
        ]);
    }
}
