<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GiftCoupon extends Model
{
    use HasFactory;
    public $timestamps = true;

    protected $fillable=['title', 'coupon_code', 'category_id', 'discount_rate', 'status', 'created_at', 'updated_at','apply_condition','redeem_description','discount_type','user_token'];
}
