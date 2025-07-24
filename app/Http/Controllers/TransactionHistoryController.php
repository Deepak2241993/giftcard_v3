<?php

namespace App\Http\Controllers;

use App\Models\TransactionHistory;
use Illuminate\Http\Request;
use Auth;
class TransactionHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(TransactionHistory $transaction)
    {
        if (Auth::user()->user_type == 1) {
            $data = $transaction->orderBy('id', 'DESC')->get();
        } else {
            $id = Auth::user()->id;
            $data = $transaction->where('user_id', $id)->orderBy('id', 'DESC')->get();
        }
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
