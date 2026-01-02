  <div style="line-height: 24px; padding: 20px; font-size: 16px; word-wrap: break-word; font-family: arial, helvetica, sans-serif;">
    Welcome to {{ config('app.name') }}!
    <p><b>Username: {{ $maildata->patient_login_id }}</b></p>
    <br>
    <p>For more information contact the Admin admin@forevermedspanj.com</p>

    <p>Thank you, <br> The {{ config('app.name') }} Team</p>
</div>
