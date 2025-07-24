<?php
namespace App\Listeners;

use App\Events\GiftcardsBuyFromCenter;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\GiftcardsNumbers;
use App\Models\Patient;
use App\Models\TimelineEvent;
use App\Models\Giftsend;
use Illuminate\Support\Facades\Log;

class ListenerGiftcardsBuyFromCenter
{
    /**
     * Handle the event.
     *
     * @param  \App\Events\GiftcardsBuyFromCenter  $event
     * @return void
     */
    public function handle(GiftcardsBuyFromCenter $event)
    {
    
        $patient_login_id = $event->data['data']->gift_send_to;

// Retrieve the transaction from the database
$transaction_result = Giftsend::where('transaction_id', $event->data['data']->transaction_id)->first();

if ($transaction_result && $transaction_result->gift_send_to === $patient_login_id) {

    // Initialize giftcard number as empty
    $giftcardnumber = '';

    try {
        // Fetch all gift card numbers for the transaction
        $giftcards = GiftcardsNumbers::where('transaction_id', $transaction_result->transaction_id)
            ->pluck('giftnumber')
            ->toArray();

        if (!empty($giftcards)) {
            $giftcardnumber = implode(', ', $giftcards);
        }

        // Create a timeline event
        TimelineEvent::create([
            'patient_id' => $transaction_result->gift_send_to,
            'event_type' => 'Giftcard Purchase',
            'subject' => 'Giftcards Transaction-'.$transaction_result->transaction_id,
            'metadata' => "Giftcard purchased for <b>Self</b> from Forever Medspa Wellness Center. Card No(s): <b>$giftcardnumber</b>",
        ]);

        Log::info('Timeline event stored', ['transaction_id' => $event->data['data']->transaction_id]);

    } catch (\Exception $e) {
        Log::error('Failed to store timeline event', [
            'transaction_id' => $event->data['data']->transaction_id,
            'error' => $e->getMessage(),
        ]);
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
                    'subject' => 'Giftcards Transaction-'.$transaction_result->transaction_id,
                    'metadata' => "Giftcard sent by ".$patient_name."<br> Giftcards:".$giftcardnumber

                ]);

                Log::info('Timeline event stored', ['transaction_id' => $event->data['data']->transaction_id]);
                    }catch (\Exception $e) {
                        Log::error('Failed to store timeline event', ['error' => $e->getMessage()]);
                    }
                }
    }
}
