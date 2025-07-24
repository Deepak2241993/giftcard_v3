<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
    use HasFactory;
    protected $fillable = ['service_id', 'description', 'created_at', 'updated_at', 'status','is_deleted','unit_id'];
}
