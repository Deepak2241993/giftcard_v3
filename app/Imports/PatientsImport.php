<?php

namespace App\Imports;

use App\Models\Patient;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;

class PatientsImport implements ToCollection, WithHeadingRow
{
    public $skipped = [];

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // Skip empty rows
            if (!$row['email'] && !$row['phone']) continue;

            $exists = Patient::where('email', $row['email'])
                ->orWhere('phone', $row['phone'])
                ->exists();

            if ($exists) {
                // Keep skipped record for later display
                $this->skipped[] = [
                    'fname' => $row['fname'],
                    'lname' => $row['lname'],
                    'email' => $row['email'],
                    'phone' => $row['phone'],
                    'reason' => 'Already exists'
                ];
                continue;
            }

            // Create new patient record
            Patient::create([
                'fname'             => $row['fname'],
                'lname'             => $row['lname'],
                'city'              => $row['city'],
                'country'           => $row['country'],
                'zip_code'          => $row['zip_code'],
                'phone'             => $row['phone'],
                'address'           => $row['address'],
                'email'             => $row['email'],
                'status'            => $row['status'] ?? 1,
                'user_token'        => $row['user_token'] ?? null,
                'patient_login_id'  => $row['patient_login_id'] ?? null,
                'password'          => bcrypt($row['password'] ?? '12345678'),
                'tokenverify'       => $row['tokenverify'] ?? null,
                'image'             => $row['image'] ?? null,
                'is_deleted'        => $row['is_deleted'] ?? 0,
                'updated_by'        => $row['updated_by'] ?? 2,
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ]);
        }
    }
}
