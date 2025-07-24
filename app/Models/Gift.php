<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gift extends Model
{
    
    use HasFactory;
    public $timestamps = true;

    protected $fillable=['from_name', 'to_name', 'to', 'from', 'msg', 'code', 'future_data', 'is_redeemed', 'amount', 'created_at', 'updated_at','coupon_code','user_id'];
}
