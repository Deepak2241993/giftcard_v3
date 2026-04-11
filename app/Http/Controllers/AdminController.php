<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Giftsend;
use App\Models\TimelineEvent;
use App\Models\Patient;
use App\Mail\PatientEmailVerify;
use App\Mail\ForgotPasswordMail;
use Redirect;
use Mail;
use Auth;
use Session;
use Validator;
use Hash;
use Str;
use App\Events\EventLogin;
use App\Events\EventPatientLogout;
use App\Events\EventPatientCreated;
use Illuminate\Support\Facades\DB;
use App\Mail\PatientCredentialsMail;
use App\Mail\Mastermail;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    //  for User Login

       
}

