<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;
    protected $fillable=['title', 'image', 'url', 'status', 'sort_order', 'is_deleted', 'created_at', 'updated_at','type','deals_and_service'];
}
