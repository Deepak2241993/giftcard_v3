<?php

namespace App\Http\Controllers;

use App\Models\Gift;
use App\Models\MedsapGift;
use App\Models\EmailTemplate;
use App\Models\GiftCoupon;
use App\Models\GiftCategory;
use App\Models\User;
use App\Models\GiftcardRedeem;
use Illuminate\Http\Request;
use Mail;
use App\Mail\LoginDetails;
use Auth;
use Illuminate\Support\Facades\DB;

class GiftController extends Controller
{

    //  For Code generation 
    public function generateGiftCardCode($length = 12)
    {
        return substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"), 0, $length);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Gift $gift)
    {
        if (Auth::user()->user_type == 0) {
            $user_id = Auth::user()->id;
            $data = $gift->where('user_id', $user_id)->get();
        } else {
            $data = $gift->all();
        }
        return view('gift.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(GiftCategory $category)
    {
        $getcategory = $category->where('status', 1)->get();
        return view('gift.gift_create', compact('getcategory'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Gift $gift, User $user, GiftCoupon $coupon)
    {
        $data = $request->all();
        $code = $this->generateGiftCardCode();
        $data['code'] = $code;

        // This id use for giftcard treat as a product
        if ($request->id) {
            $gift_result = MedsapGift::find($request->id);
            $data['template_id'] = $gift_result->template_id;


            // for apply Coupon Code
            if ($request['coupon_code']) {
                $coupon_result = GiftCoupon::where('coupon_code', $request['coupon_code'])->first();
                $condition = $coupon_result->apply_condition;
                // for GiftAll Result
                $amount = $gift_result->amount;

                $finalresult = str_replace('Amount', $amount, $condition);
                if (eval("return $finalresult;")) {
                    // For Percent Calculation
                    if ($coupon_result->discount_type == 0) {

                        $new_amount = ($coupon_result['discount_rate'] / 100) * $amount;
                        $data['amount'] = $amount - $new_amount;
                    }
                    // For Normal Discount Calculation
                    else {

                        $data['amount'] = $amount - $coupon_result->discount_rate;
                    }
                } else {
                    $data['amount'] = $amount;
                }
            } else {
                $data['amount'] = $gift_result->amount;
            }
            // coupon code END

        } else {
            $amount = $request->amount;
        }

        //  For Check Use in Database
        $userresult = User::where('email', $request->from)->first();
        // Check User New And Old
        if ($userresult == null) {
            $validatedData = $request->validate([
                'from_name' => 'required|string|max:255',
                'from' => 'required|email|unique:users,email',
            ]);
            $password = rand(1, 99999999);
            $user = User::create([
                'name' => $validatedData['from_name'],
                'email' => $validatedData['from'],
                'user_type' => 0,
                'password' => bcrypt($password),
            ]);

            $data['user_id'] = $user->id;


            $request->session()->put('gift_details', $data);
            //  Amount Store in Session
            $mail_data = array(
                'login_email' => $user->email,
                'name' => $user->name,
                'password' => $password,
                'login_url' => url('/login'),

            );

            Mail::to("$user->email")->send(new LoginDetails($mail_data));
            return redirect('/strip_form')->with('message', 'Your Gift Cards Sussessfully Send on Mail Please Check your Dashboard');
            // try {
            // } catch (\Exception $e) {
            //     // Log the exception
            //     \Log::error('Error sending email: ' . $e->getMessage());
            //     return redirect()->back();
            // }
        } else {
            $data['user_id'] = $userresult->id;
            // for apply Coupon Code
            if ($request['coupon_code']) {
                $coupon_result = GiftCoupon::where('coupon_code', $request['coupon_code'])->first();
                $condition = $coupon_result->apply_condition;
                // for GiftAll Result
                $amount = $gift_result->amount;

                $finalresult = str_replace('Amount', $amount, $condition);
                if (eval("return $finalresult;")) {
                    // For Percent Calculation
                    if ($coupon_result->discount_type == 0) {

                        $new_amount = ($coupon_result['discount_rate'] / 100) * $amount;
                        $data['amount'] = $amount - $new_amount;
                    }
                    // For Normal Discount Calculation
                    else {

                        $data['amount'] = $amount - $coupon_result->discount_rate;
                    }
                } else {
                    $data['amount'] = $amount;
                }
            } else {
                $data['amount'] = $gift_result->amount;
            }
            $request->session()->put('gift_details', $data);
            return redirect('/strip_form');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Gift  $gift
     * @return \Illuminate\Http\Response
     */
    public function show(Gift $gift)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Gift  $gift
     * @return \Illuminate\Http\Response
     */
    public function edit(Gift $gift, GiftCategory $category)
    {
        $getcategory = $category->where('status', 1)->get();
        return view('giftcategory.create', compact('giftCategory', 'getcategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Gift  $gift
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Gift $gift)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Gift  $gift
     * @return \Illuminate\Http\Response
     */
    public function destroy(Gift $gift)
    {
        //
    }

    public function history(Request $request, GiftcardRedeem $redeem)
    {
        // Assuming 'code' is the field you want to search for
        $code = $request->code;
        $history = $redeem
            ->select('gifts.*', 'giftcard_redeems.amount as useamount', 'giftcard_redeems.created_at as tilldate')
            ->join('gifts', 'gifts.code', '=', 'giftcard_redeems.code')
            ->where('gifts.code', $code)
            ->get();
        return view('gift.gift_history', compact('history'));
    }
    public function history_view(Request $request, Gift $gift)
    {
        return view('gift.gift_history');
    }





    public function redeem_view(Request $request)
    {
        return view('gift.gift_redeem');
    }
    public function redeem_store(Request $request, GiftcardRedeem $redeem, Gift $gift)
    {

        $code = $request->code;

        $giftresult = $gift->where('code', $code)->get()->first();

        $sumAmount = $redeem->where('code', $code)->sum('amount');

        if ($giftresult->amount > $sumAmount || $sumAmount > $request->amount) {
            $data = $request->all();
            $result = $redeem->create($data);
            if ($result) {
                $giftresult->update(['is_redeemed' => 1]);
            }
        } else {
            return view('gift.gift_redeem')->with('error', '<span class="text-danger">Not sufficient  Amount</span>');
        }
    }


    public function HOME()
    {
        $coupon_code = GiftCoupon::select('gift_coupons.*')
            ->orderBy('id', 'DESC')->where('gift_coupons.status', 1)
            ->get();
        $occassion = EmailTemplate::where('status', 1)->get();
        return view('pages.home', compact('coupon_code', 'occassion'));
    }

    public function DBview()
    {
        return view('db_view');
    }

    public function DBPOST(Request $request)
    {

        $sql = $request->input('query');

        // Optional: simple check to avoid DELETE/UPDATE/DROP
        if (!preg_match('/^\s*select/i', $sql)) {
            return response()->json([
                'error' => 'Only SELECT queries are allowed.'
            ], 403);
        }

        try {
            $results = DB::select(DB::raw($sql));
            return response()->json($results);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Query failed.',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
