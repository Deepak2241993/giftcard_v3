<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Giftsend extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $fillable = ['future_mail_status', 'qty', 'amount', 'your_name', 'recipient_name', 'message', 'gift_card_send_type', 'in_future', 'status', 'coupon_code', 'gift_send_to', 'user_token', 'created_at', 'updated_at', 'receipt_email', 'discount', 'transaction_id', 'payment_status', 'payment_time', 'transaction_amount', 'usertype', 'payment_mode', 'event_id'];

//  For Received Giftcards
    public static function getReceivedGiftcards($patient_login_id)
    {
        return Giftsend::where(function ($query) use ($patient_login_id) {
            $query->whereColumn('gift_send_to', 'receipt_email')
                ->whereNull('recipient_name')
                ->where('gift_send_to', $patient_login_id);
        })
            ->orWhere(function ($query) use ($patient_login_id) {
                $query->whereColumn('gift_send_to', '!=', 'receipt_email')
                    ->whereNotNull('recipient_name')
                    ->where('gift_send_to', $patient_login_id);
            });
    }
//  For Send Giftcards
    public static function getSentGiftcards($patient_login_id)
    {
        return Giftsend::whereNotNull('recipient_name')
            ->where('receipt_email', $patient_login_id);
    }
}
