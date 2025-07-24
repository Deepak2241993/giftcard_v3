<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GiftcardRedeem extends Model
{
    use HasFactory;
    public $timestamps = true;

    protected $fillable=[ 'amount', 'comment', 'code', 'created_at', 'updated_at'];
}
