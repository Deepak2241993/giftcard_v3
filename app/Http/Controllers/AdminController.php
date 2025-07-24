<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Giftsend;
use App\Models\TimelineEvent;
use App\Models\Patient;
use App\Mail\PatientEmailVerify;
use App\Mail\ForgotPasswordMail;
use App\Mail\RegistrationMail;
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
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function login(){
        if(Auth::check())
        {
    
            return redirect(route('root'));
        }
        else
        {
            return view('auth.login');
        }
    }


    //  for patient login
    public function Patientlogin(){
        if(Session::has('result'))
        {
            return redirect(route('patient-dashboard'));
        }
        else
        {
            
            return view('auth.patient_login');
        }
    }

    //  for User Login
    public function login_post(Request $request){
        $this->validate($request, [
            'email'   => 'required|email',
            'password'  => 'required|alphaNum|min:8'
           ]);
      
           $credentials = $request->only('email', 'password');
      
           if(Auth::attempt($credentials))
           {
                $request->session()->put('result',Auth::user()->name);
                $response = array('success' => true, 'error' => false, 'message' => 'Login successfully..');
                return redirect(route('root'));
            }
        else{
            $response = array('success' => false, 'error' => true, 'message' => 'Please Check User Details');
            return redirect(route('login'));
             }
    }


    //  for Patienet Login Process

    public function PatientLoginPost(Request $request)
{
    $request->validate([
        'patient_login_id' => 'required',
        'password' => 'required|min:8'
    ], [
        'patient_login_id.required' => 'The username field is required.',
    ]);

    $credentials = $request->only('patient_login_id', 'password');
    $remember = $request->filled('remember'); 

    // Befor Login Update Data of Patient Timeline of giftcard from center purchase  and giftcard table
    $patient = Patient::where('patient_login_id', $request->patient_login_id)->first();
    if($patient)
    {
    Giftsend::where('gift_send_to', $patient->email)->update(['gift_send_to' => $patient->patient_login_id]);
    Giftsend::where('receipt_email', $patient->email)->update(['receipt_email' => $patient->patient_login_id]);
    TimelineEvent::where('patient_id', $patient->email)->update(['patient_id' => $patient->patient_login_id]);
    }

    // Attempt login
    if (Auth::guard('patient')->attempt($credentials)) {
        $patient = Auth::guard('patient')->user();
        
        // Check if patient status is 1 (active)
        if ($patient->status != 1) {
            Auth::guard('patient')->logout();
            return back()->withErrors(['patient_login_id' => 'Your account is inactive. Please verify your Email'])->withInput();
        }

        // Handle "Remember Me" functionality
        if ($remember) {
            cookie()->queue('username', $request->patient_login_id, 43200); // 30 days
            cookie()->queue('password', $request->password, 43200); // 30 days
            cookie()->queue('remember', $request->remember, 43200); // 30 days
        } else {
            // Clear cookies if 'Remember Me' is unchecked
            cookie()->queue(cookie()->forget('username'));
            cookie()->queue(cookie()->forget('password'));
            cookie()->queue(cookie()->forget('remember'));
        }

        // Store Patient Details in Session
        $request->session()->put('patient_details', $patient);
        $request->session()->put('result.name', $patient->fname . ' ' . $patient->lname); // Store full name in session


        // Event Hit for Giftcard table update
        
        event(new EventLogin($patient));

        // Check for amount in session and redirect accordingly
        if (Session::has('amount')) {
            $amount = Session::get('amount');
            return redirect()->route('home')->with('amount', $amount);
        }
                // Check for session value and redirect accordingly
               else if (session()->has('cart')) {
                    return redirect()->route('checkout_view');
                }
        else {
            return redirect()->route('patient-dashboard')->with('success', 'Login successful!');
        }
    }

    // Return errors properly if login fails
    return back()->withErrors(['patient_login_id' => 'Invalid credentials.'])->withInput();
}




    //  for PatientLogout

    public function Patientlogout(Request $request) {
        // Retrieve the logged-in patient
        $patient = Auth::guard('patient')->user();
    
        // Log out the patient
        Auth::guard('patient')->logout();
    
        // Clear session data
        $request->session()->forget('result');
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    
        // Fire the event with the patient's data (e.g., username)
        event(new EventPatientLogout($patient->patient_login_id)); // or $patient depending on the event requirements
    
        return redirect(route('patient-login'));
    }
    

    //    for User Logout
    public function logout(Request $request) {
        Auth::logout();
        $request->session()->forget('result');
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
      }

    public function CheckUserName(Request $request){
        $request->validate([
            'username' => 'required|string',
        ]);
    
        // Check if a patient exists with the given username
        $result = Patient::where('patient_login_id', $request->username)->exists();
    
        if ($result) {
            return response()->json([
                'success' => false,
                'error' => true,
                'message' => 'This username is not available.',
            ], 200);
        } else {
            return response()->json([
                'success' => true,
                'error' => false,
                'message' => 'This username is available.',
            ]);
        }
    }

    
    public function PatientSignup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fname' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'patient_login_id' => 'required|string|unique:patients,patient_login_id|max:255',
            'password' => 'required|string|min:8',
            'cpassword' => 'required|same:password',
        ], [], [
            'fname' => 'First Name',
            'lname' => 'Last Name',
            'email' => 'Email',
            'phone' => 'Phone Number',
            'patient_login_id' => 'User Name',
            'password' => 'Password',
            'cpassword' => 'Confirm Password',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }
    
        $patient = Patient::where('email', $request->email)->first();
    
        if ($patient) {
            if (!$patient->patient_login_id && !$patient->password) {
                // Update existing patient with missing login details
                $patient->update([
                    'fname' => $request->fname,
                    'lname' => $request->lname,
                    'phone' => $request->phone,
                    'patient_login_id' => $request->patient_login_id,
                    'password' => Hash::make($request->password),
                    'tokenverify' => bin2hex(random_bytes(32)),
                ]);
                Giftsend::where('gift_send_to', $patient->email)->update(['gift_send_to' => $patient->patient_login_id]);
                Giftsend::where('receipt_email', $patient->email)->update(['receipt_email' => $patient->patient_login_id]);
                Mail::to($patient->email)->send(new PatientEmailVerify($patient));
                return response()->json(['success' => true, 'message' => 'Details updated successfully. Verify your email to login !']);
            }
            return response()->json(['success' => false, 'errors' => ['email' => 'Email already exists. Please login.']], 422);
        }
        else{
    
        // Create a new patient
       $patient = Patient::create([
            'fname' => $request->fname,
            'lname' => $request->lname,
            'email' => $request->email,
            'phone' => $request->phone,
            'status' => '0',
            'patient_login_id' => $request->patient_login_id,
            'password' => Hash::make($request->password),
            'user_token' => 'FOREVER-MEDSPA',
            'tokenverify' => bin2hex(random_bytes(32)),
        ]);
        Mail::to($request->email)->send(new PatientEmailVerify($patient));
        return response()->json(['success' => true, 'message' => 'Signup successful. Verify your email to login !']);
        }
    }
  
    //  For Email Verification 
    public function PatientEmailVerify(Request $request, $token)
    {
        $result = Patient::where('tokenverify', $token)->first();
    
        if ($result) {
            $result->update(['status' => 1, 'tokenverify' => null]);
            Mail::to($result->email)->send(new RegistrationMail($result));
            return redirect()->route('patient-login')->with('message', 'Your email has been verified successfully.');
        }
    
        return back()->with('message', 'Something went wrong. Maybe your token has expired.');
    }
    
    //  Forgot password
    public function ForgotPasswordView(Request $request){
      
       return view('auth.passwords.email');
    }

    public function forgotPassword(Request $request)
    {
        // Validate the email field
        $request->validate([
            'email' => 'required|email',
        ]);
    
        $email = $request->input('email');
        $user = Patient::where('email', $email)->first();
    
        if ($user && $user->patient_login_id !=null && $user->password !=null) {
            // Send the forgot password email
            $user->update(['tokenverify' => bin2hex(random_bytes(32))]);
            Mail::to($user->email)->send(new ForgotPasswordMail($user));
            return view('auth.passwords.forget_email_success')
                ->with('success', 'A password reset email has been sent to the registered email address.');
        } else {
            return back()->with('error', 'This user does not exist.');
        }
    }
    //  Passwor reset View
    public function ResetPassword($token){
        return view('auth.passwords.reset', ['token' => $token]);
    }

    //  Update Password 
    public function ResetPasswordPost(Request $request){
        $validator = Validator::make($request->all(), [
            'tokenverify' => 'required|string|max:255',
            'password' => 'required|string|min:8',
            'cpassword' => 'required|same:password',
        ], [], [
            'tokenverify' => 'Token is Not Verify',
            'password' => 'Password',
            'cpassword' => 'Confirm Password',
        ]);
    
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }        
    
        $patient = Patient::where('tokenverify', $request->tokenverify)->first();
        if($patient)
        {
            $patient->update([
                'password' => Hash::make($request->password),
                'tokenverify' => null
            ]);
            
            return view('auth.passwords.password_rest_successfully');
        }
    }

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

            if ($result) {
                try {
                    Mail::to($request->email)->send(new PatientCredentialsMail($result->patient_login_id, $randomPassword, $full_name));
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

