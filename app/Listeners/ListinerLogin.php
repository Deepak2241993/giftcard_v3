<?php

namespace App\Listeners;

use App\Events\EventLogin;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Giftsend;
use App\Models\TimelineEvent;
use App\Mail\MailLoginNotification;
use Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ListinerLogin
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
     * @param  \App\Events\EventLogin  $event
     * @return void
     */
    public function handle(EventLogin $event)
    {
        try {
            Log::info('GiftcardsBuyFromCenter event triggered.');

            $email = Auth::guard('patient')->user()->email;
            $userName = Auth::guard('patient')->user()->patient_login_id;
            $fname = Auth::guard('patient')->user()->fname;
            $lname = Auth::guard('patient')->user()->lname;
            $patient_full_name =$fname. " ".$lname;
            $ipaddress = Request::ip(); // Get user's IP address

            // Get browser and OS information
            $agent = new Agent();
            $browser = $agent->browser();
            $os = $agent->platform();
            // Get the current time in New Jersey (Eastern Time)
            $loginTime = Carbon::now('America/New_York')->format('Y-m-d H:i:s');

            Log::info("User Login Detected: Email: $email, Username: $userName, IP: $ipaddress, Browser: $browser, OS: $os");

            // Update Giftsend records
            $updateGiftSend = Giftsend::where('gift_send_to', $email)->update(['gift_send_to' => $userName]);
            $updateReceiptEmail = Giftsend::where('receipt_email', $email)->update(['receipt_email' => $userName]);

            Log::info("Giftsend table updated: gift_send_to ($updateGiftSend), receipt_email ($updateReceiptEmail)");

            // Save to TimelineEvent
            $timelineEvent = TimelineEvent::create([
                'patient_id' => $userName,
                'event_type' => 'Login',
                'subject' => 'Account Login',
                'metadata' => "You have successfully logged in on $loginTime from IP: $ipaddress, Browser: $browser, OS: $os"
            ]);

            Log::info("TimelineEvent created with ID: " . $timelineEvent->id);

            // Send Login Notification Email
            Mail::to($email)->send(new MailLoginNotification($patient_full_name, $ipaddress, $browser, $os ,$loginTime));

            Log::info("Login notification email sent to $email.");

        } catch (\Exception $e) {
            Log::error("Error in GiftcardsBuyFromCenter event: " . $e->getMessage());
        }
    }
}
