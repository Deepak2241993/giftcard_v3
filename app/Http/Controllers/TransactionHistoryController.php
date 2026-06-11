<?php

namespace App\Http\Controllers;

use App\Models\TransactionHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
class TransactionHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index(TransactionHistory $transaction)
    // {
    //     if (Auth::user()->role_id == 1) {
    //         $data = $transaction->orderBy('id', 'DESC')->get();
    //     } 
    //     else if (Auth::user()->role_id == 2) {
    //         $data = $transaction->orderBy('id', 'DESC')->get();
    //     } 
        
    //     else {
    //         $id = Auth::user()->id;
    //         $data = $transaction->where('user_id', $id)->orderBy('id', 'DESC')->get();
    //     }
    //     return view('gift.order_history', compact('data'));
    // }

public function index()
{
    $serviceOrders = DB::table('service_orders')
        ->select(
            'order_id',
            DB::raw('SUM(number_of_session) as total_sessions')
        )
        ->groupBy('order_id');

  $serviceRedeems = DB::table('service_orders as so')
    ->leftJoin('service_redeems as sr', function ($join) {
        $join->on('so.id', '=', 'sr.service_order_id')
             ->where('sr.is_deleted', '=', 0);
    })
    ->select(
        'so.order_id',
        DB::raw('COALESCE(SUM(sr.number_of_session_use),0) as redeemed_sessions')
    )
    ->groupBy('so.order_id');

    $data = DB::table('transaction_histories as th')
        ->leftJoinSub($serviceOrders, 'so', function ($join) {
            $join->on('th.order_id', '=', 'so.order_id');
        })
        ->leftJoinSub($serviceRedeems, 'sr', function ($join) {
            $join->on('th.order_id', '=', 'sr.order_id');
        })
        ->select(
            'th.*',
            DB::raw('COALESCE(so.total_sessions,0) as total_sessions'),
            DB::raw('COALESCE(sr.redeemed_sessions,0) as redeemed_sessions'),
            DB::raw("
                CASE
                    WHEN COALESCE(sr.redeemed_sessions,0) = 0
                        THEN 'Not Redeemed'
                    WHEN COALESCE(sr.redeemed_sessions,0) < COALESCE(so.total_sessions,0)
                        THEN 'Partial Redeemed'
                    ELSE 'Full Redeemed'
                END as redeem_status
            ")
        )
        ->orderBy('th.id', 'DESC')
        ->get();

    return view('gift.order_history', compact('data'));
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
        $data = $request->all();
        TransactionHistory::create($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TransactionHistory  $transactionHistory
     * @return \Illuminate\Http\Response
     */
    public function show(TransactionHistory $transactionHistory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TransactionHistory  $transactionHistory
     * @return \Illuminate\Http\Response
     */
    public function edit(TransactionHistory $transactionHistory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TransactionHistory  $transactionHistory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TransactionHistory $transactionHistory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TransactionHistory  $transactionHistory
     * @return \Illuminate\Http\Response
     */
    public function destroy(TransactionHistory $transactionHistory)
    {
        //
    }

    public function OrderUpdate(Request $request)
    {
        $data = $request->all();
        // dd($data['payment_status']);
        $transaction = TransactionHistory::where('order_id',$data['order_id'])->first();
        // dd($transaction);   
        $transaction->payment_status = $data['payment_status'];
        $transaction->comments = $data['comments'];
        $transaction->status = $data['payment_status']=='paid' ? 1 : 0;
        $transaction->transaction_status = $data['payment_status']=='paid' ? 'complete' : 'failed';
        $transaction->save();
        return redirect()->back()->with('success', 'Transaction updated successfully');
    }
}
