<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;
    protected $fillable=['program_name', 'status', 'created_at', 'updated_at', 'unit_id', 'is_deleted'];

}
