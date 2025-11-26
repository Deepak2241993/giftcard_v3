<?php

namespace App\Http\Controllers;

use App\Models\Term;
use App\Models\ServiceUnit;
use App\Models\Product;
use Auth;
use Illuminate\Http\Request;

class TermController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = Term::where('is_deleted',0)->orderBy('id','DESC')->get();
        // dd($result);
        return view('admin.terms.terms_index',compact('result'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $services = Product::where('status', 1)
    ->where('user_token', 'FOREVER-MEDSPA')
    ->where('product_is_deleted', 0)
    ->whereNotNull('unit_id')
    ->get();
        $units = ServiceUnit:: where('status',1)->where('user_token','FOREVER-MEDSPA')->where('product_is_deleted',0)->get();
        return view('admin.terms.terms_create',compact('services','units'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,Term $terms)
    {
        $data =$request->all();
        if($request->service_id!='')
        {
            $data['service_id'] = implode('|', $request->service_id);
        }
        else{
            $data['service_id'] = null;
        }
       
        if($request->unit_id!='')
        {
            $data['unit_id']=implode('|',$request->unit_id);
        }
        else
        {
            $data['unit_id'] = null;
        }
        $terms->create($data);
        return redirect('/admin/terms')->with('message', 'Terms & Condition Added Successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Term  $term
     * @return \Illuminate\Http\Response
     */
    public function show(Term $term)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Term  $term
     * @return \Illuminate\Http\Response
     */
 public function edit(Term $term)
{
    // Same query as create()
    $services = Product::where('status', 1)
        ->where('user_token', 'FOREVER-MEDSPA')
        ->where('product_is_deleted', 0)
        ->whereNotNull('unit_id')  // FIXED
        ->get();

    $units = ServiceUnit::where('status', 1)
        ->where('user_token', 'FOREVER-MEDSPA')
        ->where('product_is_deleted', 0)
        ->get();

    // Convert stored string to array
    $term['service_id'] = explode('|', $term['service_id']);
    $term['unit_id'] = explode('|', $term['unit_id']);

    return view('admin.terms.terms_create', compact('services', 'term', 'units'));
}


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Term  $term
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Term $term)
    {
        $data =$request->all();
        if($request->service_id!='')
        {
            $data['service_id'] = implode('|', $request->service_id);
        }
        else{
            $data['service_id'] = null;
        }
       
        if($request->unit_id!='')
        {
            $data['unit_id']=implode('|',$request->unit_id);
        }
        else
        {
            $data['unit_id'] = null;
        }
      
        $term->update($data);
        return redirect('/admin/terms')->with('message', 'Terms & Condition updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Term  $term
     * @return \Illuminate\Http\Response
     */
    public function destroy(Term $term)
    {
        $term->update(['is_deleted'=>1]);
        return back()->with('message', 'Terms & Condition Deleted Successfully');
    }

// AJAX to get units based on selected services
    public function getUnitsByService(Request $request)
{
    $serviceIds = $request->service_ids;

    if (!is_array($serviceIds) || empty($serviceIds)) {
        return response()->json(['units' => []]);
    }

    // Fetch products for selected services
    $products = Product::whereIn('id', $serviceIds)
        ->where('product_is_deleted', 0)
        ->where('status', 1)
        ->get();

    $unitIds = [];

    // Collect all unit IDs from each product (explode "|" format)
    foreach ($products as $product) {
        if (!empty($product->unit_id)) {
            $units = explode('|', $product->unit_id);
            $unitIds = array_merge($unitIds, $units);
        }
    }

    // Remove duplicates
    $unitIds = array_unique($unitIds);

    if (empty($unitIds)) {
        return response()->json(['units' => []]);
    }

    // Fetch actual unit records
    $units = ServiceUnit::whereIn('id', $unitIds)
        ->where('product_is_deleted', 0)
        ->where('status', 1)
        ->get();

    return response()->json(['units' => $units]);
}


}
