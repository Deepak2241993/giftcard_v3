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

    public function PatientQuickCreate(Request $request, Patient $patient)
    {
        $validator = Validator::make($request->all(), [
            'fname' => 'required|string|max:255',
            'email' => 'required|email|unique:patients,email',
        ], [], [
            'fname.required' => 'First name is required',
            'email.required' => 'Please enter Email, this is a required field',
            'email.email' => 'Please enter a valid email address',
            'email.unique' => 'This email is already registered',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        try {
            DB::beginTransaction();

            $randomPassword = Str::random(10);
            $data = $request->except('_token');
            $data['password'] = Hash::make($randomPassword);
            $data['user_token'] = 'FOREVER-MEDSPA';
            $data['status'] = 1;
            $full_name = $request->fname . " " . $request->lname;

            $result = $patient->create($data);

            $result['plain_password'] = $randomPassword;
            $result['full_name'] = $full_name;

            if ($result) {
                try {
                    Mail::to($request->email)->send(new Mastermail($result->patient_login_id, $template_id = 12));
                } catch (\Exception $e) {
                    Log::error('Email sending failed: ' . $e->getMessage());
                }

                // Commit the transaction
                DB::commit();

                // Fire the event
                event(new EventPatientCreated($result));

                return response()->json(['success' => true, 'message' => 'Patient created successfully. Credentials sent to email.']);
            }

            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Failed to create patient.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'An unexpected error occurred.']);
        }
    }
        
}

