<?php

namespace App\Http\Controllers;
use App\Models\Gift;
use App\Models\Product;
use App\Models\Patient;
use App\Models\ServiceUnit;
use App\Models\Giftsend;
use App\Models\EmailTemplate;
use App\Models\GiftcardsNumbers;
use App\Models\TransactionHistory;
use Illuminate\Http\Request;

use Stripe\Stripe;
use Stripe\Charge;
use Stripe\Customer;

use Session;
use Mail;
use Auth;
use App\Mail\GeftcardMail;
use App\Mail\GiftReceipt;
use Illuminate\Support\Facades\DB;
use App\Mail\ServicePurchaseConfirmation;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Events\GiftcardPurchases;
use App\Events\ServicePurchases;
use App\Events\TimelineGiftcardRedeem;
use App\Events\ServicePurchasesPayment;

class StripeController extends Controller
{

    protected $transactionHistoryController;
    protected $ServiceOrderController;
    

    public function __construct(TransactionHistoryController $transactionHistoryController,ServiceOrderController $ServiceOrderController)
    {
        $this->transactionHistoryController = $transactionHistoryController;
        $this->ServiceOrderController = $ServiceOrderController;
    }


    public function formview(Request $request){
        $giftDetails = $request->session()->get('gift_details');
        if( $giftDetails)
        {
       

            return view('stripe.form',compact('giftDetails'));
        }
        else{
            return redirect('/');
        }
        
    }

       public function makepayment(Request $request,Gift $gift,TransactionHistory $transaction,EmailTemplate $template)
       {
        
        // dd($request->session()->get('gift_details'));

       Stripe::setApiKey(env('STRIPE_SECRET'));

       try {
           $user_id= session('gift_details')['user_id'];
           $amount= session('gift_details')['amount'];
           $template_id = session('gift_details')['template_id'];
           $tomail=session('gift_details')['to'];
          
        //    if template not exist in tamplate list

        if ($template->find($template_id))
        {
            $mail_data = array(session('gift_details'));
        }
        else
        {
            $mail_data = array(session('gift_details'));
            $mail_data['template_id'] = 0;
        }
        
           // Create a charge
          $data= Charge::create([
               'amount' => session('gift_details')['amount'] * 100 , // Amount in cents
               'currency' => 'usd',
               'source' => $request->stripeToken,
               'description' => 'Forever Medspa Giftcards UserId='.$user_id.' Amount $ ='.$amount,
           ]);

        //    Payment successful, you can handle success here

           if($data)
           {
            $giftdata=session('gift_details');
            $result=$gift->create($giftdata);
            $transaction_entry=array(
                'transaction_id'=>$data->source->id,
                'amount'=>($data->amount)/100,
                'user_id'=>$user_id,
                'status'=>$data->status,
                'card_type'=>$data->payment_method_details->card->brand,
                'last_for_digit'=>'xxxx-xxxx-xxxx-'.$data->payment_method_details->card->last4,
            );
            $transaction->create($transaction_entry);
            // $mail_data=array(
            //             'to'=>session('gift_details')['to'],
            //             'from'=>session('gift_details')['from'],
            //             'code'=>session('gift_details')['code'],
            //             'to_name'=>session('gift_details')['to_name'],
            //             'from_name'=>session('gift_details')['from_name'],
            //             'amount'=>session('gift_details')['amount'],
            //             'template_id'=>session('gift_details')['template_id'],
            //             'msg'=>$result->msg,
            //         );
            
            // dd($mail_data);
            Mail::to("$tomail")->send(new GeftcardMail($mail_data));

            $request->session()->flush('gift_details');
            return view('stripe.thanks',compact('data'))->with('success', 'Payment successful.');
           }
       } catch (\Exception $e) {
           // Payment failed, handle the error
           return back()->with('error', $e->getMessage());
       }
    }


    //  Giftcardspayment

    public function giftcardpayment(Request $request, Giftsend $giftsend, GiftcardsNumbers $cardnumber)
    {
        $id = Session::get('gift_id');
        $giftsend = Giftsend::find($id);
    // dd($giftsend);
        Stripe::setApiKey(env('STRIPE_SECRET'));
    
        try {
            $data = Charge::create([
                'amount' => (($giftsend['amount'] * $giftsend['qty']) - $giftsend['discount']) * 100,
                'currency' => 'usd',
                'source' => $request->stripeToken,
                'description' => 'Forever Medspa Giftcards UserId=' . $giftsend['id'] . ' Amount $ =' . $giftsend['amount'] * $giftsend['qty'],
            ]);
    
            Log::info('Payment attempted', [
                'user_id' => $giftsend->id,
                'amount' => $data->amount / 100,
                'status' => $data->status,
            ]);
     
        } catch (\Exception $e) {
            Log::error('Payment failed', ['error' => $e->getMessage()]);
            return view('stripe.failed')->with('error', $e->getMessage());
        }
        if ($data->status == 'succeeded') {
                $transaction_entry = [
                    'transaction_id' => $data->source->id,
                    'transaction_amount' => $data->amount / 100,
                    'payment_status' => $data->status,
                    'payment_time' => $data->created,
                    'payment_mode' => 'Payment Gateway',
                ];
    
                Log::info('Transaction entry update', $transaction_entry);
                $giftsend->update($transaction_entry);
    
                $GeneratedGiftcards = [];
    
                for ($i = 1; $i <= $giftsend->qty; $i++) {
                    $cardgenerate = [
                        'user_id' => $giftsend->id,
                        'transaction_id' => $data->source->id,
                        'user_token' => $giftsend->user_token,
                        'amount' => $giftsend->amount,
                        'status' => 1,
                        'comments' => $giftsend->message,
                        'actual_paid_amount' => $giftsend->discount != 0 
                            ? ($giftsend->amount * $giftsend->qty - $giftsend->discount) / $giftsend->qty 
                            : $giftsend->amount,
                    ];
    
                    $cardresult = $cardnumber->create($cardgenerate);
    
                    if ($cardresult) {
                        $gift_card_code = 'FEMS-' . time() . $cardresult->id;
                        $cardresult->update(['giftnumber' => $gift_card_code]);
    
                        Log::info('Gift card generated', [
                            'gift_card_code' => $gift_card_code,
                            'user_id' => $giftsend->id,
                        ]);
    
                        $GeneratedGiftcards[] = $gift_card_code;
                    }
                }

            
            // This section handles the email sending logic based on user type

                // if (in_array($giftsend->usertype, ['regular', 'guest'])) {

                //     $receipt_email = Patient::where('patient_login_id', $giftsend->receipt_email)
                //     ->value('email') ?? $giftsend->receipt_email;
                //     $gift_send_to = $giftsend->gift_send_to;
                    
                //     $giftcard_receiver_email_id = Patient::where('email', $giftsend->gift_send_to)
                //     ->value('patient_login_id') ?? $giftsend->gift_send_to;
                //     $giftsend->update(['gift_send_to' => $giftcard_receiver_email_id]);
                // }


                
if (in_array($giftsend->usertype, ['regular', 'guest'])) {

    // 📌 Check or map receipt_email to patient_login_id
    $receipt_email = Patient::where('patient_login_id', $giftsend->receipt_email)
        ->value('email') ?? $giftsend->receipt_email;

    $gift_send_to = $giftsend->gift_send_to;
    if($giftsend->recipient_name!=null){
        $patient_name = $giftsend->recipient_name;
    }
    else{
       $patient_name = $giftsend->your_name;
    }

    // 📌 Try to find patient by recipient email
    $existingPatient = Patient::where('email', $gift_send_to)->first();

    if (!$existingPatient && $giftsend->usertype === 'guest') {
        // 🚀 Create new patient for guest
        $newPatient = Patient::create([
            'fname'             => $patient_name, // default or get from request
            'lname'             => '(Guest User)',  // default or get from request
            'email'             => $gift_send_to,
            'status'          =>0, // random password
            'user_token'          =>'FOREVER-MEDSPA', // random password
        ]);

        $giftcard_receiver_email_id = $newPatient->email;
    } else {
        // 📌 Use existing patient_login_id or fallback to email
        $giftcard_receiver_email_id = $existingPatient->email ?? $gift_send_to;
    }

    // 📌 Update gift_send_to with patient_login_id
    $giftsend->update([
        'gift_send_to' => $giftcard_receiver_email_id
    ]);
}

            
    // This Section Send Email To (Giftcard Sender)  For Future Date and receipt get to current date

                if ($giftsend->in_future != null && $giftsend->gift_card_send_type == 'other') {
                    Mail::to($receipt_email)->send(new GiftReceipt($giftsend));
                    Log::info('Gift card email sent', ['to' => $receipt_email]);
                }
 
                if($giftsend->gift_card_send_type == 'other' &&  $giftsend->in_future == null){
                    Mail::to($receipt_email)->send(new GiftReceipt($giftsend));
                    Log::info('Gift receipt email sent', ['to' => $receipt_email]);

                    Mail::to($gift_send_to)->send(new GeftcardMail($giftsend));
                    Log::info('Gift sent email', ['to' => $giftsend]);
                }
                
                
                if($giftsend->gift_card_send_type == 'self')
                {
                    Mail::to($receipt_email)->send(new GeftcardMail($giftsend));
                    Log::info('Gift card email sent', ['to' => $receipt_email]);
                }
                
                Session::pull('amount');
                return view('stripe.thanks', compact('data'))->with('success', 'Payment successful.');
            }
    }
    


   public function CheckoutProcess(Request $request)
    {
        $request->validate([
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'zip_code' => 'required|digits:5',
            'email' => 'required|email|max:255',
            'phone' => 'required|digits_between:7,10',
        ]);

        DB::beginTransaction();  // Start transaction

        try {
        
            // Generate New Order For this 
            $orderId = 'MSWC-SER-'.date('Y')."-".time();
            $gift_number = null;
            $gift_amount = null;
            $totalAmount = 0;

    //  If Gift card applyed for redeem
            // if (session()->has('total_gift_applyed') && $cards = session('cart', []) ) {
            //     $cards = session('cart', []);
            //     $giftcards = session('giftcards', []);
            //     $gift_numbers = [];
            //     $gift_amounts = [];
    
            //     foreach ($giftcards as $giftcard) {
            //         if (isset($giftcard['number'])) {
            //             $gift_numbers[] = $giftcard['number'];
            //             $gift_amounts[] = $giftcard['amount'];
            //         }
            //     }

            //     $gift_number = implode('|', $gift_numbers);
            //     $gift_amount = implode('|', $gift_amounts);
            //     $sub_amount = session('totalValue', 0) + session('total_gift_applyed', 0) - session('tax_amount', 0);
            //     $final_amount = session('totalValue', 0);
            //     $taxamount = session('tax_amount', 0);
                
            // }
            //  If Gift card Not applyed for redeem
            if ($cards = session('front_cart', []))
            {
            

                foreach ($cards as $item) {
                    if($item['type']=='product')
                    {

                        $cart_data = Product::find($item['unit_id']);
                       
                        $totalAmount += $item['quantity']*$cart_data->discounted_amount ??  $item['quantity']*$cart_data->amount;
                    }
                    if($item['type']=='unit')
                        {
                            $cart_data = ServiceUnit::find($item['unit_id']);
                    
                        $totalAmount += $item['quantity']*$cart_data->discounted_amount ??  $item['quantity']*$cart_data->amount;
                    }

                }

                $taxamount = ($totalAmount * 0) / 100;
                $sub_amount = $totalAmount;
                $final_amount = $totalAmount + $taxamount;
            }

            $data = [
                'fname' => $request->fname,
                'lname' => $request->lname,
                'city' => $request->city,
                'country' => $request->country,
                'zip_code' => $request->zip_code,
                'email' => $request->email,
                'phone' => $request->phone,
                'order_id' => $orderId,
                'gift_card_applyed' => $gift_number ? $gift_number:null,
                'gift_card_amount' => $gift_amount ? $gift_amount :null,
                'sub_amount' => $sub_amount,
                'final_amount' => $final_amount,
                'address' => $request->address,
                'tax_amount' => $taxamount,
                'user_token' => 'FOREVER-MEDSPA',
                'payment_mode' => 'online',
                'patient_login_id' => Auth::guard('patient')->user()->patient_login_id ?? null,

            ];
           
            
                // Insert data and get the latest inserted ID
                $latestId = DB::table('transaction_histories')->insertGetId($data);

                // Concatenate order_id with the prefix and latest ID
                $orderId = 'FMSWCSU' . str_pad($latestId, 8, '0', STR_PAD_LEFT); // Example: MSWC-SER-00000001

                // Update the order_id field
                DB::table('transaction_histories')
                    ->where('id', $latestId)
                    ->update(['order_id' => $orderId]);

                // Optional: Store updated data in the controller
                $data['order_id'] = $orderId;
                // $this->transactionHistoryController->store(new \Illuminate\Http\Request($data));
            // Store data in ServiceOrder table
        
            
            foreach ($cards as $item) {
                if($item['type']=='product')
                {

                    $cart_data = Product::find($item['unit_id']);
                }
                if($item['type']=='unit')
                {

                    $cart_data = ServiceUnit::find($item['unit_id']);
                }

                $order_data = [
                    'order_id' => $orderId,
                    'service_id' => $item['unit_id'],
                    'status' => 0,
                    'number_of_session' => $cart_data->session_number?$item['quantity']*$cart_data->session_number:$item['quantity'],
                    'user_token' => 'FOREVER-MEDSPA',
                    'actual_amount' => $cart_data->amount,
                    'discounted_amount' => $cart_data->discounted_amount ?? 0.00,
                    'payment_mode' => 'online',
                    'qty' => $item['quantity'],
                    'service_type' => $item['type'],
                     'patient_login_id' => Auth::guard('patient')->user()->patient_login_id ?? null,
                ];
                // ServiceOrderController::create($order_data);
                $this->ServiceOrderController->store(new \Illuminate\Http\Request($order_data));
                event(new ServicePurchases($order_data));
            }

            DB::commit();  // Commit transaction

        } catch (\Exception $e) {
            DB::rollBack();  // Rollback transaction
            Log::error('Checkout Process Error: ' . $e->getMessage());
            return back()->withErrors(['error' => $e->getMessage()]);
        }

        // Stripe Checkout Session
        try {
            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
            $redirecturl = route('strip_checkout_success') . '?session_id={CHECKOUT_SESSION_ID}';

            $response = $stripe->checkout->sessions->create([
                'success_url' => $redirecturl,
                'customer_email' => $request->email,
                'payment_method_types' => ['link', 'card'],
                'line_items' => [
                    [
                        'price_data' => [
                            'product_data' => [
                                'name' => $orderId ?: '',
                            ],
                            'unit_amount' => session()->get('totalValue') ? session()->get('totalValue') * 100 : $final_amount * 100,
                            'currency' => 'USD',
                        ],
                        'quantity' => 1
                    ],
                ],
                'mode' => 'payment',
                'allow_promotion_codes' => false,
            ]);

            // Update payment_session_id in TransactionHistory
            TransactionHistory::where('order_id', $orderId)->update(['payment_session_id' => $response->id]);

        // Trigger the payment event with relevant data
            // event(new ServicePurchasesPayment([
            // 'session_id' => $response->id,
            // 'payment_intent' => $response->payment_intent,
            // 'email' => $request->email,
            // 'order_id' => $orderId,
            // 'amount' => session()->get('totalValue') ?? $final_amount,
            // 'patient_id' => Auth::guard('patient')->user()->patient_login_id ?? null,
            // ]));
            return redirect($response['url']);

        } catch (\Exception $e) {
            Log::error('Stripe Checkout Session Error: ' . $e->getMessage());
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }




    public function stripcheckoutSuccess(Request $request)
{
    try {
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        $response = $stripe->checkout->sessions->retrieve($request->session_id);

        $transaction_data = \App\Models\TransactionHistory::where('payment_session_id', $response->id)->first(); 
        $ServiceOrder = \App\Models\ServiceOrder::where('order_id', $transaction_data->order_id)->first(); 
        
        if ($transaction_data) {
            // Prepare the data to be updated
            $data = [
                'payment_status' => $response->payment_status,
                'status' => ($response->status == 'complete') ? 1 : 0,
                'payment_intent' => $response->payment_intent,
                'transaction_status' => $response->status,
                'transaction_amount' => $response->amount_total / 100,
            ];

            // Update the transaction history record
            $transaction_data->update($data);
            $ServiceOrder->where('order_id', $ServiceOrder->order_id)->update(['status' => 1]);


            if ($transaction_data->gift_card_applyed != null) {
                $giftcardnumbers = explode('|', $transaction_data->gift_card_applyed);
                $giftcardamounts = explode('|', $transaction_data->gift_card_amount);

                foreach ($giftcardnumbers as $key => $value) {
                    $giftcard_result = \App\Models\GiftcardsNumbers::where('giftnumber', $value)->first();

                    if ($giftcard_result) {
                        $data_arr = [
                            'gift_card_number' => $value,
                            'amount' => $giftcardamounts[$key],
                            'comments' => "You have redeemed your giftcard " . $giftcardnumbers[$key] . " on the purchase of the service Order Number: " . $transaction_data->order_id,
                            'user_id' => $giftcard_result->user_id,
                            'user_token' => 'FOREVER-MEDSPA',
                        ];

                        $data = json_encode($data_arr);

                        $result = $this->postAPI('gift-card-redeem', $data);

                        if ($result['status'] == 200) {
                            $data_arr['gift_card_number'] = $value;
                            $data_arr['user_token'] = 'FOREVER-MEDSPA';

                            $data = json_encode($data_arr);
                            $statement = $this->postAPI('gift-card-statment', $data);
                            $giftcard_result = \App\Models\GiftcardsNumbers::where('giftnumber', $value)->first();
                            $statement['giftCardHolderDetails'] = $result['giftCardHolderDetails'];
                            \Mail::to($result['giftCardHolderDetails']['gift_send_to'])->send(new \App\Mail\GiftCardStatement($statement));
                        }
                    }
                }
            }
            session::pull('giftcards');
            session::pull('total_gift_applyed');
            session::pull('tax_amount');
            session::pull('totalValue');
            session::pull('front_cart');
        }

        //  For Purchase Confirmation Mail
        // dd($transaction_data);
        Mail::to($transaction_data->email)->send(new ServicePurchaseConfirmation($transaction_data));

        return redirect()->route('invoice')
                     ->with('transaction_data', $transaction_data)
                     ->with('success', 'Payment successful.');
   
    } catch (\Exception $e) {
        // Log the error message
        \Log::error('Transaction Status : ' . $e->getMessage());
        return view('stripe.failed')->with('error', 'Payment processing failed. Please contact support.');
    }
}


public function invoice()
{
    // Retrieve flash data
    $transaction_data = session('transaction_data');
    return view('invoice.service_invoice', compact('transaction_data'));
}












        public function InternalServicePurchase(Request $request)
        {
            // dd($request->all());
            // Validation
            $request->validate([
                'cart_total' => 'required|numeric|min:0',
                'discount' => 'nullable|numeric|min:0',
                'tax' => 'nullable|numeric|min:0',
                'pay_amount' => 'required|numeric|min:0',
                'payment_status' => 'required|string|max:255',
            ], [
                'cart_total.required' => 'The cart total amount is required.',
                'cart_total.numeric' => 'The cart total must be a numeric value.',
                'pay_amount.required' => 'The payment amount is required.',
                'pay_amount.numeric' => 'The payment amount must be a numeric value.',
                'payment_status.required' => 'The payment status is required.',
            ]);

            DB::beginTransaction(); // Start transaction
            try {
                $orderPrefix = 'FMSWCSU';
                $orderId = $orderPrefix . str_pad(0, 6, '0', STR_PAD_LEFT);
                $taxAmount = $request->tax ?? 0;
                $discount = $request->discount ?? 0;
                $cartTotal = $request->cart_total ?? 0;
                $giftApply = $request->giftapply ?? 0;
                $subtotal = $request->subtotal ?? 0;
                $taxrate = $request->taxrate ?? 0;
                
                // {{dd($cartTotal, $discount, $giftApply, $taxAmount, $taxrate );}}
                // Get patient details
                $patient = Patient::find($request->patient_id);
                $patientLoginId = $patient ? $patient->patient_login_id : null;
               
                // Process Gift Cards
                $giftNumbers = $giftAmounts = [];
                if (!empty($request->gift_cards)) {
                    foreach ($request->gift_cards as $giftcard) {
                        if (!empty($giftcard['card_number']) && isset($giftcard['amount'])) {
                            $giftNumbers[] = $giftcard['card_number'];
                            $giftAmounts[] = $giftcard['amount'];
                        }
                    }
                }



                // Create transaction record
                $transaction = TransactionHistory::create([
                    'fname' => $patient->fname,
                    'lname' => $patient->lname,
                    'email' => $patient->email,
                    'phone' => $patient->phone,
                    'gift_card_applyed' => $giftNumbers ? implode('|', $giftNumbers) : null,
                    'gift_card_amount' => $giftAmounts ? implode('|', $giftAmounts) : null,
                    'sub_amount' => $subtotal,
                    'final_amount' => $cartTotal,
                    'transaction_amount' => $cartTotal,
                    'tax_amount' => $taxAmount,
                    'discount' => $discount,
                    'user_token' => 'FOREVER-MEDSPA',
                    'payment_mode' => 'store',
                    'patient_login_id' => $patientLoginId,
                ]);
                
                // Update order ID after transaction is created
                if ($transaction) {
                    $updatedOrderId = $orderId . $transaction->id;
                    $paymentSessionId = 'MEDSPA-CENTER-' . $transaction->id;
                    $paymentIntent = 'MEDSPA-CENTER-' . $transaction->id;

                    $transaction->update([
                        'order_id' => $updatedOrderId,
                        'payment_session_id' => $paymentSessionId,
                        'transaction_status' => $request->payment_status =='paid' ? 'complete':'pending',
                        'payment_status' => $request->payment_status,
                        'status' => $request->payment_status =='paid' ? 1:0,
                        'payment_intent' => $paymentIntent,
                    ]);
               
                }

                // Process Cart Items
                $cart = session()->get('cart', []);
                
                foreach ($cart as $item) {
                    if ($item['type'] == 'product') {
                        $cartData = Product::find($item['unit_id']);
                    } elseif ($item['type'] == 'unit') {
                        $cartData = ServiceUnit::find($item['unit_id']);
                    } else {
                        continue; // Skip if type is not recognized
                    }
                //    dd($cartData);

                    if ($cartData) {
                        $discountedAmount = $cartData->discounted_amount ?? $cartData->amount;
                        $cartTotal += $item['quantity'] * $discountedAmount;

                        $orderData = [
                            'order_id' => $updatedOrderId,
                            'service_id' => $item['unit_id'],
                            'status' => 0,
                            'number_of_session' => $cartData->session_number
                                ? $item['quantity'] * $cartData->session_number
                                : $item['quantity'],
                            'user_token' => 'FOREVER-MEDSPA',
                            'actual_amount' => $cartData->amount,
                            'discounted_amount' => $discountedAmount,
                            'payment_mode' => 'store',
                            'qty' => $item['quantity'],
                            'service_type' => $item['type'],
                            'patient_login_id' => $patientLoginId,
                        ];

                        $serviceOrder = new ServiceOrderController();
                        $serviceOrder->store(new \Illuminate\Http\Request($orderData));

                        event(new ServicePurchases($orderData));
                    }
                }

                // Process Gift Card Redemption
                if (!empty($request->gift_cards)) {
                    $redeemOrderId = 'REDEEM' . time();
                    foreach ($request->gift_cards as $giftcard) {
                       $giftcard_data= GiftcardsNumbers::where('giftnumber',$giftcard['card_number'])->first();
                        if (!empty($giftcard['card_number']) && isset($giftcard['amount'])) {
                            $giftcardEntry = GiftcardsNumbers::create([
                                'transaction_id' => $redeemOrderId,
                                'user_id' => $giftcard_data->user_id,
                                'user_token' => 'FOREVER-MEDSPA',
                                'giftnumber' => $giftcard['card_number'],
                                'amount' => '-'.$giftcard['amount'],
                                'actual_paid_amount' => '-'.$giftcard['amount'],
                                'comments' => 'Gift card used in purchase service with order number ' . $updatedOrderId,
                            ]);
                            
                            // Update the transaction_id with the newly created entry ID
                            $giftcardEntry->update(['transaction_id' => $redeemOrderId . $giftcardEntry->id]);
                            event(new TimelineGiftcardRedeem([
                                'patient_id' => $patientLoginId ?? null,
                                'event_type'=>'Giftcard Redeem',
                                'metadata'=>'Giftcard Use in Purchase services with order id '.$redeemOrderId . $giftcardEntry->id,
                                'subject' => 'Giftcards Redeem'
                                ]));
                        }
                    }
                }

                session()->forget('cart'); // Clear cart session
                session()->forget('patient_id'); // Clear cart session
                DB::commit(); // Commit transaction
                    //  dd($transaction);
                $transaction['taxrate'] = $taxrate;
                Mail::to($transaction->email)->send(new ServicePurchaseConfirmation($transaction));

                return response()->json([
                    'message' => 'Order placed successfully',
                    'invoice_id' => $transaction->id
                ], 200);

            } catch (\Exception $e) {
                DB::rollBack(); // Rollback transaction on error
                return response()->json(['error' => 'Something went wrong: ' . $e->getMessage()], 500);
            }
        }

}

    



