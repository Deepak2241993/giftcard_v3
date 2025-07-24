<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PatientCredentialsMail extends Mailable
{
    use Queueable, SerializesModels;

    public $patient_login_id;
    public $password;
    public $full_name;

    public function __construct($patient_login_id, $password,$full_name)
    {
        $this->patient_login_id = $patient_login_id;
        $this->password = $password;
        $this->full_name = $full_name;
    }

    public function build()
    {
        return $this->subject('Your Account Credentials')
                    ->view('email.patient_credentials')
                    ->with([
                        'patient_login_id' => $this->patient_login_id,
                        'password' => $this->password,
                        'full_name' => $this->full_name,
                    ]);
    }
}

