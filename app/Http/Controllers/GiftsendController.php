<?php

namespace App\Http\Controllers;

use App\Models\Giftsend;
use App\Models\User;
use App\Models\GiftcardsNumbers;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Auth;
use DB;
use Session;
use App\Mail\ResendGiftcard;
use App\Mail\GiftCardStatement;
use App\Mail\GiftcardCancelMail;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;
use App\Events\GiftcardsBuyFromCenter;
class GiftsendController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data_arr = $request->except('_token');
        $data = json_encode($data_arr);
        $result =$this->postAPI('gift-for-other',$data);
        if(isset($result['error']))
        {
            session()->flash('msg', '<h5 style="color: red;">' . $result['error'] . '</h5>');
            return redirect('/register');
        }
        else{
            session()->flash('msg', '<h5 style="color: green;">' . $result['success'] . '</h5>');
            return redirect('/');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Giftsend  $giftsend
     * @return \Illuminate\Http\Response
     */
    public function show(Giftsend $giftsend)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Giftsend  $giftsend
     * @return \Illuminate\Http\Response
     */
    public function edit(Giftsend $giftsend)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Giftsend  $giftsend
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Giftsend $giftsend)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Giftsend  $giftsend
     * @return \Illuminate\Http\Response
     */
    public function destroy(Giftsend $giftsend)
    {
        //
    }


    //  For Coupon Validate
    public function giftvalidate(Request $request){
        $data_arr = $request->except('_token');
        $data = json_encode($data_arr);
        $result =$this->postAPI('coupon-validate',$data);
        if(isset($result['error'])) {
            echo json_encode(["error" => '<h5 style="color: red;">' . $result['error'] . '</h5>']);
        } else {
            echo json_encode(["success" => '<h5 style="color: green;">' . $result['success'] . '</h5>','data'=>$result['data']]);
        }
    }

    //  for giftcards  send

    public function sendgift(Request $request){
        $data_arr = $request->except('_token');
   
       
        // find User exist or not
        if($request->patient_login_id !=null)
        {
        $data_arr['gift_send_to'] = $request->gift_send_to;
        $data_arr['receipt_email'] = $request->patient_login_id;
        $data_arr['usertype'] = 'regular';
        }
        
        else{
            $data_arr['receipt_email'] = $request->receipt_email;
            $data_arr['gift_send_to'] = $request->gift_send_to;
            $data_arr['usertype'] = 'guest';
        }
        
         
        // dd($data_arr);
        $data_arr['amount'] = $data_arr['amount'] / $data_arr['qty'];
        $data = json_encode($data_arr);
        //  First API
        $resultData =$this->postAPI('gift-for-other',$data);
        $result=json_decode($resultData['result']);
        $request->session()->put('gift_id', $result->id);

        if($result->discount!=0)
        {
            $discount_dispaly="<tr style='background-color:#FCA52A;'><th>Discount: </th><th>".'$'. ($result->discount)."</th></tr>";
        }
        else{
            $discount_dispaly='';
        }
        if(isset($resultData['error'])) {
            echo json_encode(["error" => '<h5 style="color: red;">' . $resultData['error'] . '</h5>']);
        } 
        else {
            
                //  for gift send to other
                if($result->recipient_name!=null)
                {
                  
                    echo json_encode([
                        "success" => '<h5 style="color: green;">' . $resultData['success'] . '</h5>',
                        "result" => '<table class="table table-striped">
                                       <tbody>
                                         <tr><th id="giftqty"></th>
                                         <th>$'.$result->amount * $result->qty.'</th></tr>
                                         <tr><th>Your name:</th><th>'.$result->your_name.'</th></tr>
                                         <tr><th>Recipient name:</th><th>'.$result->recipient_name.'</th></tr>
                                         <tr><th>Message:</th><th>'.$result->message.'</th></tr>
                                         <tr><th>Ship To:</th><th>'.$request->gift_send_to.'</th></tr>
                                         <tr><th>Receipt To:</th><th>'.$request->receipt_email.'</th></tr>'.$discount_dispaly.'
                                         <tr><th>Total:</th><th>'.'$'.($result->amount * $result->qty) - ($result->discount ? $result->discount : 0).'</th></tr>
                                       </tbody>
                                     </table>',
                        "paymentscript" => '<script
                                             src="https://checkout.stripe.com/checkout.js"
                                             class="stripe-button"
                                             data-key="'.env('STRIPE_KEY').'"
                                             data-name="Forever Medspa"
                                             data-description="Forever Medspa Giftcards"
                                             data-amount="'.((($result->amount * $result->qty) - ($result->discount ? $result->discount : 0)) * 100).'" // Convert to cents
                                             data-email="info@forevermedspanj.com"
                                             data-image="'.url('/medspa.png').'"
                                             data-currency="usd"
                                             id="stripeButton">
                                           </script>'
                    ]);  
                }   
        }
    }

    // For Self Giftcards
    public function selfgift(Request $request){
        $data_arr = $request->except('_token');

        $patient = Patient::where('email',$request->gift_send_to)->first();

        if($patient != null && $patient->patient_login_id != null)
        {
            //  for gift send to self
            $data_arr['gift_send_to'] =  $patient->patient_login_id;
            $data_arr['receipt_email'] = $patient->patient_login_id;
            $data_arr['usertype'] = 'regular';
        }
        else{
            $data_arr['gift_send_to'] =  $request->to_email;
            $data_arr['receipt_email'] = $request->to_email;
            $data_arr['usertype'] = 'guest';
        }
       

        $data_arr['amount'] = $data_arr['amount'] / $data_arr['qty'];
        $data = json_encode($data_arr);
        // dd($data);
        //  First API
        $resultData =$this->postAPI('gift-for-self',$data);
        $result=json_decode($resultData['result']);
        $request->session()->put('gift_id', $result->id);

        if($result->discount!=0)
        {
            $discount_dispaly="<tr style='background-color: #FCA52A;'><th>Discount: </th><th>".'$'. ($result->discount)."</th></tr>";
        }
else{
    $discount_dispaly='';
}
        if(isset($resultData['error'])) {
            echo json_encode(["error" => '<h5 style="color: red;">' . $resultData['error'] . '</h5>']);
        } else {
                        
            echo json_encode([
                "success" => '<h5 style="color: green;">' . $resultData['success'] . '</h5>',
                "result" => '<table class="table table-striped">
                               <tbody>
                                 <tr><th id="giftqty"></th><th>$'.$result->amount*$result->qty.'</th></tr>
                                 <tr><th>Your name:</th><th>'.$result->your_name.'</th></tr>
                                 <tr><th>Shipping By Email:</th><th>'.$request->gift_send_to.'</th></tr>'.$discount_dispaly.'
                                 <tr><th>Total:</th><th>'.'$'.($result->amount * $result->qty) - ($result->discount ? $result->discount : 0).'</th></tr>
                               </tbody>
                             </table>',
                "paymentscript" => '<script
                                     src="https://checkout.stripe.com/checkout.js"
                                     class="stripe-button"
                                     data-key="'.env('STRIPE_KEY').'"
                                     data-name="Forever Medspa"
                                     data-description="Forever Medspa Giftcards"
                                     data-amount="'.((($result->amount * $result->qty) - ($result->discount ? $result->discount : 0)) * 100).'" // Convert to cents
                                     data-email="info@forevermedspanj.com"
                                     data-image="'.url('/medspa.png').'"
                                     data-currency="usd"
                                     id="stripeButton">
                                   </script>'
            ]); 
            
        }
    }

    // for balnce check of giftcards
    
        //  For Coupon Validate
        public function knowbalance(Request $request){
            $data_arr = $request->except('_token');
            $data = json_encode($data_arr);
            $result =$this->postAPI('giftcard-balance-check',$data);
     
            if(isset($result['status']) && $result['status']==200) {
                echo json_encode(["success" => '<h5 style="color: green;">' . $result['result'] . '</h5>']);
            } else {
                echo json_encode(["error" => '<h5 style="color: red;">' . $result['error'] . '</h5>']);
            }
        }

    //  for giftcard redeem
    public function giftcardredeemView(Request $request)
{
    $token = Auth::user()->user_token;
    $data_arr = ['name' => '', 'email' => '', 'giftcardnumber' => '', 'user_token' => $token];
    $data = json_encode($data_arr);
    $result = $this->postAPI('gift-card-search', $data);

    if (isset($result['status']) && $result['status'] == 200) {
        $getdata = $result['result'];
        return view('admin.redeem.redeem_view', compact('getdata'));
    } else {
        $error = isset($result['error']) ? $result['error'] : 'Unknown error occurred.';
        return view('admin.redeem.redeem_view')->with('error', $error);
    }
}

    //  giftcard redeem from patient list
    public function giftcardredeemPatientList(Request $request, $id)
{
    $token = Auth::user()->user_token;

    // Get patient info
    $patient = Patient::findOrFail($id);
    $patient_email = $patient->email;
    $patient_username = $patient->patient_login_id;
    $patient_full_name = $patient->fname ." ".$patient->lname;

    // Find related giftcard transactions
    $giftcard_transaction = Giftsend::where(function ($query) use ($patient_username, $patient_email) {
        $query->where('gift_send_to', $patient_username)
              ->orWhere('gift_send_to', $patient_email);
    })->get();
    // Extract IDs from giftcard_transaction collection
    $giftsendIds = $giftcard_transaction->pluck('id')->toArray();

    // Query giftcard details
    $getdata = DB::table('giftsends')
        ->join('giftcards_numbers', 'giftcards_numbers.user_id', '=', 'giftsends.id')
        ->select(
            'giftsends.recipient_name',
            'giftsends.your_name',
            'giftsends.gift_send_to',
            'giftsends.user_token',
            'giftcards_numbers.giftnumber',
            'giftcards_numbers.user_id',
            'giftcards_numbers.status',
            DB::raw('SUM(giftcards_numbers.amount) as total_amount')
        )
        ->whereIn('giftcards_numbers.user_id', $giftsendIds)
        ->where('giftcards_numbers.user_token', $token)
        ->groupBy(
            'giftsends.recipient_name',
            'giftsends.your_name',
            'giftsends.gift_send_to',
            'giftsends.user_token',
            'giftcards_numbers.giftnumber',
            'giftcards_numbers.user_id',
            'giftcards_numbers.status'
        )
        ->get();
        $getdata = json_decode(json_encode($getdata), true); // array of arrays

    // Return view with data
    return view('admin.patient.patientlist-redeem_view', compact('getdata','patient'));
}



    public function GiftCardSearch(Request $request)
    {
        $data_arr = $request->except('_token');
        $data = json_encode($data_arr);
        $result = $this->postAPI('gift-card-search', $data);

        if (isset($result['status']) && $result['status'] == 200) {
            $getdata = $result['result'];
           
            // Convert the data array into a Collection
            $collection = collect($getdata);

            // Get the current page from the request, default to 1
            $currentPage = LengthAwarePaginator::resolveCurrentPage();

            // Define how many items you want per page
            $perPage = 10; // Example: 10 items per page

            // Slice the collection to get the items to display in the current page
            $currentPageItems = $collection->slice(($currentPage - 1) * $perPage, $perPage)->all();

            // Create our paginator
            $paginatedItems = new LengthAwarePaginator($currentPageItems, $collection->count(), $perPage);

            // Set the pagination path
            $paginatedItems->setPath($request->url());

            return view('admin.redeem.redeem_view', compact('paginatedItems'));
        } else {
            $error = isset($result['error']) ? $result['error'] : 'Unknown error occurred.';
            return view('admin.redeem.redeem_view')->with('error', $error);
        }
    }

    function giftcardredeem(Request $request){
        $data_arr = $request->except('_token');
        $data = json_encode($data_arr);
        $result = $this->postAPI('gift-card-redeem', $data);
     
        if($result['status']==200){

            $data_arr = $request->except('_token','amount','comments','user_id');
            $data = json_encode($data_arr);
            
            $statement = $this->postAPI('gift-card-statment', $data);
            $statement['giftCardHolderDetails'] = $result['giftCardHolderDetails'];

            $patient_data = Patient::where('patient_login_id', $result['giftCardHolderDetails']['gift_send_to'])->first();
            if($patient_data)
            {
                //  For Getting Email form Patient Table as Per Recever Username
                $statement['giftCardHolderDetails']['gift_send_to'] = $patient_data->email;

                $fullname = $patient_data->fname." ".$patient_data->lname;
                // Assign recipient name if it's empty, otherwise keep existing value
                if($statement['giftCardHolderDetails']['recipient_name'] = !null)
                {
                    $statement['giftCardHolderDetails']['recipient_name'] = $fullname ;
                }
                else{
                    $statement['giftCardHolderDetails']['your_name'] = $fullname ;
                }
            }
            
           
            Mail::to($statement['giftCardHolderDetails']['gift_send_to'])->send(new GiftCardStatement($statement));
        }

        return $result;

    }

    function giftcardstatment(Request $request){
        $data_arr = $request->except('_token');
        $data = json_encode($data_arr);
        $result = $this->postAPI('gift-card-statment', $data);
        return $result;
    }

   public function giftsale(Request $request, $id = null)
{
    $patient = null;

    if ($id) {
        $patient = Patient::findOrFail($id);
    }

    return view('gift.gift_sale', compact('patient'));
}

     // For Other Giftcards

     public function GiftPurchase(Request $request)
     {
         // Validate incoming request
         $validated = $request->validate([
             'your_name' => 'required|string|max:255',
             'gift_send_to' => 'required|email|max:255',
         ], [
             'your_name.required' => 'The Your Name field is required.',
             'gift_send_to.required' => 'The Email field is required.',
             'gift_send_to.email' => 'The Email must be a valid email address.',
         ]);
     
         // Prepare the data for API
         $data_arr = $request->except('_token');
         $data_arr['transaction_id'] = 'FEMS-' . time();
         $data_arr['payment_mode'] = 'From Forever Medspa Center';
     
         // Convert data to JSON for API
         $data = json_encode($data_arr);
     
         try {
             // Call the API
             $resultData = $this->postAPI('gift-purchase-from-store', $data);
     
             if (isset($resultData['result'])) {
                 $result = (object) $resultData['result'];
     
                 // Fire event
                 event(new GiftcardsBuyFromCenter(['data' => $result]));
     
                 // Redirect with transaction details
                 return redirect()->route('giftcard-purchases-success')
                     ->with('transaction_details', $result);
             } else {
                 return redirect()->back()
                     ->withErrors('Unexpected API response. Please try again.');
             }
         } catch (\Exception $e) {
             \Log::error('GiftPurchase API call failed: ' . $e->getMessage());
             return redirect()->back()
                 ->withErrors('There was an error processing your request. Please try again later.');
         }
     }
     



public function GiftPurchaseSuccess()
{
    // Retrieve the 'result' data from the session
    $transactionDetails = session('transaction_details');
    // dd($transactionDetails);
    if($transactionDetails)
    {
        // Pass the 'result' data to the view if needed
        return view('gift.gift_purchase_payment_history', ['result' => $transactionDetails]);
    }
    else{

        return redirect()->route('giftcards-sale');
    }
}

public function payment_confirmation(Request $request){
    $data_arr = $request->except('_token');
    $data_arr['transaction_amount']=Session::get('amount_medspa_center_purchase');
    // dd($data_arr);//transaction_amount
    $data = json_encode($data_arr);
    //  First API
    $resultData =$this->postAPI('payment_confirmation',$data);

    if($resultData['status']==200)
    {
        return redirect('admin/cardgenerated-list');
    }
    else
    {
        return redirect('admin/cardgenerated-list');
    }
 
}

// for giftcards list

public function cardgeneratedList(Request $request, User $user, GiftcardsNumbers $number, Giftsend $giftsend)
{
    $token = Auth::user()->user_token;
    $data_arr = ['user_token' => $token];
    $data = json_encode($data_arr);

    $result = $this->postAPI('gift-list', $data);

    // if (isset($result['status']) && $result['status'] == 200) {
    //     $data = $result['result'];

    //     // Convert the data array into a Collection
    //     $collection = collect($data);

    //     // Get the current page from the request, default to 1 if not set
    //     $currentPage = LengthAwarePaginator::resolveCurrentPage();

    //     // Define how many items you want per page
    //     $perPage = 50; // for example, 10 items per page

    //     // Slice the collection to get the items to display in the current page
    //     $currentPageItems = $collection->slice(($currentPage - 1) * $perPage, $perPage)->all();

    //     // Create our paginator
    //     $paginatedItems = new LengthAwarePaginator($currentPageItems, $collection->count(), $perPage);

    //     // Set the pagination path
    //     $paginatedItems->setPath($request->url());

    //     return view('admin.cardnumber.index', compact('paginatedItems'));
    // } else {
    //     return view('admin.cardnumber.index')->with('error', 'Something Went Wrong');
    // }
    
    //  Above Code is Manual Pagination 

    if (isset($result['status']) && $result['status'] == 200) {
        $data = $result['result'];
        return view('admin.cardnumber.index', compact('data'));
    } else {
        return view('admin.cardnumber.index')->with('error', 'Something Went Wrong');
    }
    
}
//  for payment status update
public function updatePaymentStatus(Request $request){
    $data_arr = $request->except('_token');
    $data = json_encode($data_arr);
    $result = $this->postAPI('payment_status_update', $data);
return $result;
}



public function giftcancel(Request $request,){

    $data_arr = $request->except('_token');
    $data = json_encode($data_arr);
    $result =$this->postAPI('giftcard-cancel',$data);
    if(isset($result['status']) && $result['status']==200) {
        
        $data_arr_status = ['gift_card_number' => $request->gift_card_number, 'user_token' => $request->user_token];
        $data = json_encode($data_arr_status);
        $statement = $this->postAPI('gift-card-statment', $data);
        $statement['receiverAndSenderDetails'] = $result['receiverAndSenderDetails'][0];

        if ($statement['receiverAndSenderDetails']['receipt_email'] != '') {
            $tomail = $statement['receiverAndSenderDetails']['receipt_email'];
            $senderdata = Patient::where('patient_login_id',$tomail)->first();
            if($senderdata)
            {
                $tomail = $senderdata->email;
                $statement['receiverAndSenderDetails']['your_name'] = $senderdata->fname." ".$senderdata->lname;
            }
           
        } else {
            $tomail = $statement['receiverAndSenderDetails']['gift_send_to'];
            $receiverdata = Patient::where('patient_login_id',$tomail)->first();
            if($receiverdata)
            {
                $tomail = $receiverdata->email;
                $statement['receiverAndSenderDetails']['your_name'] = $receiverdata->fname." ".$receiverdata->lname;
            }
           
        }
        
        // Convert $tomail to string if it's an array
        $tomail = is_array($tomail) ? $tomail[0] : $tomail;
        
        Mail::to($tomail)->send(new GiftcardCancelMail($statement));
     } 

    return $result;
 
}

public function Resendmail_view(Request $request){
    $mail_data = Giftsend::findOrFail($request->id);

     $receiver= Patient::where('patient_login_id',$mail_data->gift_send_to)->first();
     $sender= Patient::where('patient_login_id',$mail_data->receipt_email)->first();
     if($receiver)
     {
        $mail_data['gift_send_to'] = $receiver->email;
     }
     if($sender)
     {
        $mail_data['receipt_email'] = $sender->email;
     }
    return view('email.email_template_view',compact('mail_data'));

}

public function Resendmail(Request $request)
{
    try {
        $statement = $request->all();
        $statement['send_mail']='yes';
        Mail::to($statement['gift_send_to'])->cc($request->cc)->bcc($request->bcc)->send(new ResendGiftcard($statement));

        return back()->with('message', 'Email sent successfully.');
    } 
    catch (Exception $e) {
        return back()->with('error','Failed to send email.');
    }
}

public function giftcardValidate(Request $request){
    $data_arr = $request->except('_token');
    $data = json_encode($data_arr);
    $result = $this->postAPI('gift-card-amount-calculation', $data);
    // dd($result);
    return $result;

}

public function GifttransactionSearch(Request $request, Giftsend $giftTransactions)
{
    // Start with a base query
    $query = $giftTransactions->query();

    // Check if 'recipient_name' is provided in the request
    if ($request->filled('recipient_name')) {
        $recipient_name = strtolower($request->recipient_name);  // Get the search term
        // Apply the filter on 'recipient_name'
        $query->whereRaw('LOWER(recipient_name) LIKE ?', ['%' . $recipient_name . '%']);
    }

    // Check if 'receipt_email' is provided in the request
    if ($request->filled('receipt_email')) {
        $receipt_email = strtolower($request->receipt_email);  // Get the search term
        // Apply the filter on 'receipt_email'
        $query->whereRaw('LOWER(receipt_email) LIKE ?', ['%' . $receipt_email . '%']);
    }

    // Order and paginate results
    $data = $query->orderBy('id', 'DESC')->paginate(10);

    // Return response as JSON
    return response()->json([
        'status' => 'success',
        'message' => 'Search results retrieved successfully.',
        'data' => $data,
    ], 200);
}



}
