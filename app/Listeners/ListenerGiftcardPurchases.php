<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use app\Events\GiftcardPurchases;
use App\Models\GiftcardsNumbers;
use App\Models\Patient;
use App\Models\TimelineEvent;
use App\Models\Giftsend;
use Illuminate\Support\Facades\Log;
use Auth;
class ListenerGiftcardPurchases
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(GiftcardPurchases $event)
    {

            $patient_login_id = Auth::guard('patient')->user()->patient_login_id;
            $transaction_result = Giftsend::where('transaction_id', $event->transaction_entry['transaction_id'])->first();
   
            //  For Purchase Self
            if($transaction_result['gift_send_to'] ==  $patient_login_id)
            {
                    if ($transaction_result) {
                        $giftcards = GiftcardsNumbers::select('giftnumber')
                            ->where('transaction_id', $transaction_result->transaction_id)
                            ->pluck('giftnumber')
                            ->toArray();
                    
                        $giftcardnumber = implode(",", $giftcards);
                    } 
                    else {
                        $giftcardnumber = ''; // Handle the case when no transaction is found
                    }
                    
                try {
                    TimelineEvent::create([
                        'patient_id' => $transaction_result['gift_send_to'], 
                        'event_type' => 'Giftcard Purchase',
                        'subject' => 'Giftcards Transaction-'.$transaction_result->transaction_id,
                        'metadata' => "Giftcard purchased for Self<br>Giftcards:".$giftcardnumber

                    ]);
                    Log::info('Timeline event stored', ['transaction_id' => $event->transaction_entry['transaction_id']]);
                        }catch (\Exception $e) {
                            Log::error('Failed to store timeline event', ['error' => $e->getMessage()]);
                        }
            }
            //  Gift cards For Other
            else{
               
                    if ($transaction_result) {
                        $giftcards = GiftcardsNumbers::select('giftnumber')
                            ->where('transaction_id', $transaction_result->transaction_id)
                            ->pluck('giftnumber')
                            ->toArray();
                    
                        $giftcardnumber = implode(",", $giftcards);
                    } 
                    else {
                        $giftcardnumber = ''; // Handle the case when no transaction is found
                    }
                    
                try {
                    //  Message Show for Sender 
                    $sender_patient = Patient::where('patient_login_id',$transaction_result['gift_send_to'])->first();
                    // First Details Get By UserName
                    if($sender_patient){
                        $patient_name = $sender_patient->fname." ".$sender_patient->lname;
                    }
                    // If No Found User Name Then Get By Email
                    else{
                        $sender_patient = Patient::where('email',$transaction_result['gift_send_to'])->first();
                        $patient_name = $sender_patient->fname." ".$sender_patient->lname;
                    }
                    TimelineEvent::create([
                        'patient_id' => $transaction_result['receipt_email'], 
                        'event_type' => 'Giftcard Purchase',
                        'subject' => 'Giftcards Transaction-'.$transaction_result->transaction_id,
                        'metadata' => "Giftcard Sent to ".$patient_name."<br> Giftcards:".$giftcardnumber

                    ]);
                    //  Message Show for Receiver
                    $receiver_patient = Patient::where('patient_login_id',$transaction_result['receipt_email'])->first();
                    if($receiver_patient){
                        $patient_name = $receiver_patient->fname." ".$receiver_patient->lname;
                    }
                    // If No Found User Name Then Get By Email
                    else{
                        $receiver_patient = Patient::where('email',$transaction_result['receipt_email'])->first();
                        $patient_name = $receiver_patient->fname." ".$receiver_patient->lname;
                    }

                    TimelineEvent::create([
                        'patient_id' => $transaction_result['gift_send_to'], 
                        'event_type' => 'Giftcard Purchase',
                        'subject' => 'Giftcards Transaction',
                        'metadata' => "Giftcard sent by ".$patient_name."<br> Giftcards:".$giftcardnumber

                    ]);

                    Log::info('Timeline event stored', ['transaction_id' => $event->transaction_entry['transaction_id']]);
                        }catch (\Exception $e) {
                            Log::error('Failed to store timeline event', ['error' => $e->getMessage()]);
                        }
                    }
        }
                
        
    }

