<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GiftcardsNumbers extends Model
{
    use HasFactory;
    protected $fillable=['user_id', 'transaction_id', 'user_token', 'giftnumber', 'amount', 'status', 'created_at', 'updated_at', 'comments','actual_paid_amount'];
}
