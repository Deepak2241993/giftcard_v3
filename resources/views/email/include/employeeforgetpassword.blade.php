<div style="line-height: 24px; padding: 20px; font-size: 16px; word-wrap: break-word; font-family: arial, helvetica, sans-serif;">
<p style="text-align: center; margin: 30px 0;">
    <a href="{{ route('EmployeeResetPasswordView', ['token' => $maildata->remember_token]) }}"
       target="_blank"
       style="background-color:#0d6efd;
              color:#ffffff;
              text-decoration:none;
              padding:12px 30px;
              border-radius:5px;
              display:inline-block;
              font-size:16px;
              font-weight:bold;">
        Reset Password
    </a>
</p>
   
 </div>
