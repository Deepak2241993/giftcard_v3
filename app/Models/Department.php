<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table = 'departments';
    protected $fillable = ['clinic_id', 'department_name', 'description', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_deleted'];
}
