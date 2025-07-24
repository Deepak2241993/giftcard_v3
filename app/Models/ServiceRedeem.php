<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRedeem extends Model
{
    use HasFactory;
    protected $fillable=['id', 'order_id', 'product_id', 'service_type', 'service_order_id', 'number_of_session_use', 'transaction_id', 'refund_amount', 'user_token', 'comments', 'patient_login_id', 'is_deleted', 'updated_by', 'status', 'created_at', 'updated_at'];
}
