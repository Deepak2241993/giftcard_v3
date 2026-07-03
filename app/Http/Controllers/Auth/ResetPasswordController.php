<?php

namespace App\Http\Controllers\Auth;
use App\Models\User;
use App\Mail\Mastermail;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    /**
     * Redirect after password reset.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Show Forgot Password Page.
     */
    public function ForgotPasswordView()
    {
        return view('auth.employee-forgot-password');
    }

    /**
     * Handle Forgot Password Form.
     */
     public function ForgotPassword(Request $request)
    {
        // Validate Email
        $request->validate([
            'email' => 'required|email',
        ]);

        $email = $request->email;

        // Find Employee
        $employee = User::where('email', $email)->first();
       
        if ($employee) {

            // Generate Reset Token
            $employee->update([
                'remember_token' => bin2hex(random_bytes(32))
            ]);

            // Send Email (Use your Employee template ID)
            Mail::to($employee->email)->send(new Mastermail($employee, $template_id = 15));

            return view('auth.ForgetMailSendSuccessfully')
                ->with('success', 'A password reset email has been sent to your registered email address.');
        }
        return back()->with('error', 'This employee does not exist.');
    }


    public function ResetPassword($token){
        return view('auth.employee-reset', ['token' => $token]);
    }

    public function ResetPasswordPost(Request $request){
        $validator = Validator::make($request->all(), [
            'remember_token' => 'required|string|max:255',
            'password' => 'required|string|min:8',
            'cpassword' => 'required|same:password',
        ], [], [
            'remember_token' => 'Token is Not Verify',
            'password' => 'Password',
            'cpassword' => 'Confirm Password',
        ]);
    
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }        
    
        $employee = User::where('remember_token', $request->remember_token)->first();
        if($employee)
        {
            $employee->update([
                'password' => Hash::make($request->password),
                'remember_token' => null
            ]);
            
            return view('auth.employee-password-reset-successfully');
        }
        else
        {
            return back()->with('error', 'Token is Not Verify');
        }
    }
}