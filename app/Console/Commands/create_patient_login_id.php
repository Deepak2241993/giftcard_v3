<?php

namespace App\Console\Commands;
use App\Models\Giftsend;
use App\Models\Patient;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Console\Command;

class create_patient_login_id extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'patient_login_id:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generating Patient_login_id in Patient Table and giftcards sends table';

    /**
     * Execute the console command.
     *
     * @return int
     * 
     * 
     */


public function handle(Giftsend $giftcards,Patient $patient)
{
    $result = Giftsend::where('patient_login_id', null)
                  ->where('user_token', 'FOREVER-MEDSPA')
                  ->get();

if ($result->isNotEmpty()) {
    foreach ($result as $value) {
        // Log the first result's 'your_name' field
        Log::info('Processing record for:', ['your_name' => $value->your_name]);

        // Initialize first and last name variables
        $fname = '';
        $lname = '';

        // Divide patient name into fname and lname properly
        $nameToUse = !empty($value->recipient_name) ? $value->recipient_name : $value->your_name;
        
        $patient_name = explode(' ', $nameToUse);

        // Ensure array keys exist to avoid errors
        $fname = $patient_name[0] ?? '';
        $lname = isset($patient_name[1]) ? $patient_name[1] : '';
        $lname .= isset($patient_name[2]) ? ' ' . $patient_name[2] : '';
        $lname .= isset($patient_name[3]) ? ' ' . $patient_name[3] : '';

        // Find patient data and update or create if not exists
        $patient_data = Patient::where('email', $value->gift_send_to)
                              ->where('user_token', 'FOREVER-MEDSPA')
                              ->first();

        if ($patient_data) {
            // Update existing patient record
            $patient_data->update([
                'fname' => $fname,
                'lname' => $lname,
                'patient_login_id' => $fname . "_" . $value->gift_send_to,
                'password' => Hash::make('0987654321')
            ]);
            Giftsend::where('gift_send_to', $value->gift_send_to)
            ->update(['patient_login_id' => $fname . "_" . $value->gift_send_to]);

                 
            Log::info('Updated patient record for:', ['login_id' => $fname . "_" . $value->gift_send_to]);
        } else {
            // Create new patient record if not exists
            Patient::create([
                'fname' => $fname,
                'lname' => $lname,
                'email' => $value->gift_send_to,
                'user_token' => 'FOREVER-MEDSPA',
                'patient_login_id' => $fname . "_" . $value->gift_send_to,
                'password' => Hash::make('0987654321')
            ]);
            Giftsend::where('gift_send_to', $value->gift_send_to)
            ->update(['patient_login_id' => $fname . "_" . $value->gift_send_to]);
            Log::info('Updated patient record for:', ['login_id' => $fname . "_" . $value->gift_send_to]);
        }
    }
} else {
    Log::warning('No records found for Giftsend with patient_login_id null and user_token FOREVER-MEDSPA.');
}
}

}
