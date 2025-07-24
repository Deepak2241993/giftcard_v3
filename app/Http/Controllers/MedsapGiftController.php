<?php

namespace App\Http\Controllers;

use App\Models\MedsapGift;
use App\Models\EmailTemplate;
use Illuminate\Http\Request;

class MedsapGiftController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $data=MedsapGift::OrderBy('id','DESC')->get();
       $data = MedsapGift::select('medsap_gifts.*', 'email_templates.title as template_title')
        ->leftJoin('email_templates', 'medsap_gifts.template_id', '=', 'email_templates.id')
        ->orderBy('id', 'DESC') // Use 'orderBy' instead of 'OrderBy'
        ->get();
        return view('medsapgift.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(EmailTemplate $email_template)
    {

        $template=$email_template->where('status',1)->get();
        return view('medsapgift.create',compact('template'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,MedsapGift $giftcard)
    {
        $data=$request->all();
        if ($request->hasFile('image')){
            $file = $request->file('image');
            $image = $this->upload_single_image($file,$folder='gifts');
            $data['image'] = $image;
        }
        if($request->coupon_code!='ON')
        {
            $data['coupon_code']=0;
        }
        else{
            $data['coupon_code']=1;
        }
        $giftcard->create($data);
        return redirect()->route('medspa-gift.index')->with('message','medsGiftcard Gift Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MedsapGift  $medsapGift
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MedsapGift  $medsapGift
     * @return \Illuminate\Http\Response
     */
    public function edit(MedsapGift $medsapGift,EmailTemplate $email_template,$medspa_gift)
    {
       $medsapGift= $medsapGift->find($medspa_gift);
        $template=$email_template->where('status',1)->get();
        return view('medsapgift.create',compact('medsapGift','template'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MedsapGift  $medsapGift
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MedsapGift $medsapGift, $gift_id)
{
    // Find the MedsapGift record by ID
    $medsapGiftRecord = $medsapGift->findOrFail($gift_id);

    // Get the data from the request
    $data = $request->all();
    if ($request->hasFile('image')){
        $file = $request->file('image');
        $image = $this->upload_single_image($file,$folder='gifts');
        $data['image'] = $image;
        if(!empty($medsapGift->image) && $medsapGift->image!="NULL" ){
        $delete_prev_image = $this->delete_image($medsapGift->image,$folder='gifts'); 
        }
    }
    $code=$request->coupon_code;
    if($code=='on')
    {
        $data['coupon_code']=1;
    }
    else{
        $data['coupon_code']=0;
    }

    // Update the MedsapGift record with the new data
    $medsapGiftRecord->update($data);

    // Redirect to the index page with a success message
    return redirect()->route('medspa-gift.index')->with('message', 'MedsGiftcard Gift Updated Successfully');
}


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MedsapGift  $medsapGift
     * @return \Illuminate\Http\Response
     */
    public function destroy(MedsapGift $medsapGift,$medspa_gift)
    {
        $result=$medsapGift->findOrFail($medspa_gift);
        $result->delete();
        return back()->with('message', 'Giftcard Deleted Successfully');
    }
}
