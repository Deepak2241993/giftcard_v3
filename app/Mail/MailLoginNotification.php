<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailLoginNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $patient_full_name;
    public $ipAddress;
    public $browser;
    public $os;
    public $loginTime;

    /**
     * Create a new message instance.
     */
    public function __construct($patient_full_name, $ipAddress, $browser, $os,$loginTime)
    {
        $this->patient_full_name = $patient_full_name;
        $this->ipAddress = $ipAddress;
        $this->browser = $browser;
        $this->os = $os;
        $this->loginTime = $loginTime;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('🔐 Successful Login Notification')
                    ->view('email.login_notification')
                    ->with([
                        'patient_full_name' => $this->patient_full_name,
                        'ipAddress' => $this->ipAddress,
                        'browser' => $this->browser,
                        'os' => $this->os,
                        'loginTime' => $this->loginTime,
                    ]);
    }
}
