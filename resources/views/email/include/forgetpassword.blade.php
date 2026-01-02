<div style="line-height: 24px; padding: 20px; font-size: 16px; word-wrap: break-word; font-family: arial, helvetica, sans-serif;">
     <h2>Reset Your Password</h2>
     <p>Hi {{ $maildata->fname . ' ' . $maildata->lname }},</p>
     <p>Click the button below to reset your password:</p>
     <p>
         <a href="{{ route('ResetPasswordView', ['token' => $maildata->tokenverify]) }}" target="_blank">Reset Password</a>
     </p>
     <p><b>User Name:{{ $maildata->patient_login_id }}</b></p>
   
 </div>
