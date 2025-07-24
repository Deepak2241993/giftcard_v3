<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // Extend Authenticatable
use Illuminate\Notifications\Notifiable;

class Patient extends Authenticatable
{
    use HasFactory, Notifiable;

    // Specify the table if it's not the default 'patients'
    protected $table = 'patients';

    // Define the fillable attributes for mass assignment
    protected $fillable = [
        'fname', 'lname', 'city', 'country', 'zip_code', 'phone', 'address', 'email', 'status', 'user_token', 'created_at', 'updated_at', 'patient_login_id', 'password', 'tokenverify', 'image', 'is_deleted', 'updated_by'
    ];

    // Hide sensitive fields
    protected $hidden = [
        'password',
    ];
}
