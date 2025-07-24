<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceOrder extends Model
{
    use HasFactory;
    protected $fillable=['order_id', 'service_id', 'number_of_session', 'status', 'created_at', 'updated_at', 'is_deleted', 'updated_by', 'user_token', 'actual_amount', 'discounted_amount','payment_mode','qty','service_type','patient_login_id'];
}
