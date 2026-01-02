            <div style="font-size: 18px; font-weight: bold; margin-bottom: 10px;">
                
            <p style="line-height: 24px; padding: 20px; font-size: 16px; word-wrap: break-word; font-family: arial, helvetica, sans-serif;">
              
                <a href="{{ route('patient_email_verify', ['token' => $maildata->tokenverify]) }}"
                    target="_blank"
                    style="
                        display:inline-block;
                        padding:12px 24px; 24px;
                        background-color:#0d6efd;
                        color:#ffffff;
                        text-decoration:none;
                        border-radius:6px;
                        font-size:16px;
                        font-weight:600;
                        font-family:Arial, sans-serif;
                    ">
                    Verify Email
                    </a>

                <br/>
            </p>
            <p style="line-height: 15px; padding-left: 20px; padding-top: 10px; font-size: 16px; word-wrap: break-word; font-family: arial, helvetica, sans-serif;">
            If you did not create an account, no further action is required.</p>
            </div>
