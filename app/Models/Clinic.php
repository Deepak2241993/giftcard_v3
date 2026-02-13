<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clinic extends Model
{
    protected $table = 'clinics';
    protected $fillable = ['clinic_name', 'address', 'city', 'state', 'pincode', 'phone', 'email', 'status', 'is_deleted', 'created_by', 'updated_by', 'created_at', 'updated_at'];
}
