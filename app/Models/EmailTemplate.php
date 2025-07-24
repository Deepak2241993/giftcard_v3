<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    use HasFactory;
    public $timestamps = true;

    protected $fillable=['title', 'message_email', 'image', 'status', 'created_at', 'updated_at', 'footer_message'];
}
