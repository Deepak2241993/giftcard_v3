<?php

namespace App\Http\Controllers;

use App\Models\GiftCoupon;
use Illuminate\Http\Request;


class GiftCouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(GiftCoupon $coupon)
    {
        $data = GiftCoupon::select('gift_coupons.*')
        ->orderBy('id', 'DESC') // Use 'orderBy' instead of 'OrderBy'
        ->get();
        return view('coupon.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('coupon.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,GiftCoupon $coupon)
    {
        $data=$request->all();
        $coupon->create($data);
        return redirect()->route('coupon.index')->with('message','Gift Coupon Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\GiftCoupon  $giftCoupon
     * @return \Illuminate\Http\Response
     */
    public function show(GiftCoupon $giftCoupon)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\GiftCoupon  $giftCoupon
     * @return \Illuminate\Http\Response
     */
    public function edit(GiftCoupon $giftCoupon,$coupon)
    {
        $giftCoupon=$giftCoupon->find($coupon);
        return view('coupon.create',compact('giftCoupon'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\GiftCoupon  $giftCoupon
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GiftCoupon $giftCoupon,$coupen_id)
    {
       $result = $giftCoupon->findOrFail($coupen_id);
        $data=$request->all();
        $result->update($data);
        return redirect()->route('coupon.index')->with('message','Coupon Update Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\GiftCoupon  $giftCoupon
     * @return \Illuminate\Http\Response
     */
    public function destroy(GiftCoupon $giftCoupon,$coupen_id)
    {
        $data=$giftCoupon->findOrFail($coupen_id);
        $data->delete();
        return back()->with('message', 'Coupon Deleted Successfully');
    }

}
