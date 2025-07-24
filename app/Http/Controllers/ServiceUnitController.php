<?php

namespace App\Http\Controllers;

use App\Models\ServiceUnit;
use App\Models\Product;
use App\Models\Banner;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Auth;
use Session;
use Illuminate\Support\Facades\DB;
class ServiceUnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = ServiceUnit::where('product_is_deleted',0)->orderBy('id','DESC')->get();
        return view('admin.service_unit.service_unit_index', compact('result'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.service_unit.service_unit_create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,ServiceUnit $serviceUnit)
    {
        $token = Auth::user()->user_token;
        $data = $request->except('_token');
        $data['user_token'] = $token;
        $product_image = [];

    if ($request->hasFile('product_image')) {
        $folder = str_replace(" ", "_", $token);
        $destinationPath = '/uploads/' . $folder . "/";

        foreach ($request->file('product_image') as $image) {
            // Move the image to the destination path
            $filename = $image->getClientOriginalName();
            $image->move(public_path($destinationPath), $filename);

            // Store the image URL
            $product_image[] = url('/') . $destinationPath . $filename;
        }

        // Combine the image URLs into a single string
        $finalImageUrl = implode('|', $product_image);
        $data['product_image'] = $finalImageUrl;
    }

        $serviceUnit->create($data);

        return redirect('/admin/unit')->with('message', 'Unit Added Successfully');

    }

 
    public function edit(ServiceUnit $serviceUnit,$id)
    {
       $data = ServiceUnit::find($id);
        return view('admin.service_unit.service_unit_create',compact('data'));
    }

    public function update(Request $request)
        {
            $token = Auth::user()->user_token;
            $updateData = $request->except('_token', '_method');
            $updateData['user_token'] = $token;

            // Handle product images if any are uploaded
            $product_image = [];
            if ($request->hasFile('product_image')) {
                // Generate a folder name by replacing spaces with underscores
                $folder = str_replace(" ", "_", $token);
                $destinationPath = public_path('uploads' . DIRECTORY_SEPARATOR . $folder);
            
                // Ensure the folder exists
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }
            // dd($request->file('product_image'));
                foreach ($request->file('product_image') as $image) {
                    // Validate that the uploaded file is an image
                    if ($image->isValid() && in_array($image->extension(), ['jpg', 'jpeg', 'png', 'gif', 'bmp'])) {
                        // Generate a unique filename to avoid overwrites
                        $filename = time() . '_' . $image->getClientOriginalName();
                        $image->move($destinationPath, $filename);
            
                        // Append the image URL to the array
                        $product_image[] = url('uploads/' . $folder . '/' . $filename);
                    }
                }
            
                // Combine the image URLs into a single string
                $updateData['product_image'] = implode('|', $product_image);
            }
            
            
            // Update the service unit with the prepared data
            $data = ServiceUnit::find($request->id);
            $data->update($updateData);

            // Redirect back to the admin unit page with a success message
            return redirect('/admin/unit')->with('message', 'Unit is updated successfully');
        }

    

    
    public function destroy(Request $request)
    {
        $data = ServiceUnit::find($request->id);
        $data->update(['product_is_deleted'=>1]);
        return back()->with('message', 'Unit is Deleted Successfully');
    }

    // For Frontend Unit page Show

    public function UnitPageShow(Request $request, $slug){
       $product = Product::where('product_slug',$slug)->first();
       $result = explode('|',$product->unit_id);
        return view('product.unit_show',compact('result','product'));
    }

    public function UnitPageDetails(Request $request, $product_slug,$slug){
        $unit = ServiceUnit::where('product_slug',$slug)->first();
        $image = explode('|',$unit->product_image);
         // Fetch the term description if a unit was found
         if ($unit) {
            // Search for a term where `unit_id` includes the product's ID
            $term = DB::table('terms')
            ->where('status', 1)
            ->whereRaw("FIND_IN_SET(?, REPLACE(unit_id, '|', ','))", [$unit->id])
            ->first();

            // Display the description
            $description = $term->description ?? 'No description available';
            $terms_id = $term->id ?? 'No id';
            }
            $unit['terms_and_conditions'] = $description;
            $unit['terms_id'] = $terms_id;
     //    dd($result);
         return view('product.unit_details',compact('unit','image'));
     }

     //  For Showing All Service And Unit on Same Page
public function ServicePage(Request $request)
{

    $services = Product::where('product_is_deleted', 0)
        ->where('status', 1)
        ->where('user_token', 'FOREVER-MEDSPA')
        ->paginate(10); // Paginate with 10 per page

    $category = ProductCategory::where('cat_is_deleted', 0)
        ->where('status', 1)
        ->where('user_token', 'FOREVER-MEDSPA')
        ->orderBy('id', 'DESC')
        ->get();

    // Autocomplete array for frontend search
    $search_category = ProductCategory::where('cat_is_deleted', 0)
        ->where('status', 1)
        ->where('user_token', 'FOREVER-MEDSPA')
        ->pluck('cat_name')
        ->toArray();

    $search_product = Product::where('product_is_deleted', 0)
        ->where('status', 1)
        ->where('user_token', 'FOREVER-MEDSPA')
        ->pluck('product_name')
        ->toArray();

    $finalarray = array_merge($search_category, $search_product);
    $search = json_encode($finalarray);

    // Category slug => name map for frontend JS
    $categoryMap = [];
    foreach ($category as $cat) {
        if (!empty($cat->slug) && !empty($cat->cat_name)) {
            $categoryMap[$cat->slug] = $cat->cat_name;
        }
    }

    // Fetch all services for the frontend JS
    $serviceData = Product::where('product_is_deleted', 0)
        ->where('status', 1)
        ->where('user_token', 'FOREVER-MEDSPA')
        ->get()
        ->map(function ($service) {
            return [
                'id' => $service->slug ?? $service->id, // fallback if slug missing
                'product_name' => $service->product_name,
                'amount' => $service->amount,
                'discounted_amount' => $service->discounted_amount,
                'discounted_amount' => $service->discounted_amount,
                'product_description' => $service->product_description,
                'product_image' => $service->product_image,
                'product_fetured' => $service->product_fetured,
                'cat_id' => $service->cat_id,
                'short_description' => $service->short_description,
                'popular_service' => $service->popular_service
            ];
        });
    return view('product.services', compact(
        'services',
        'category',
        'search',
        'categoryMap',
        'serviceData'
    ));
}


// Create Unit Quickly
public function CreateUnitQuickly(Request $request,ServiceUnit $serviceUnit)
    {
        $token = Auth::user()->user_token;
        $data = $request->except('_token');
        $data['user_token'] = $token;
        $result = $serviceUnit->create($data);
        $cart = session()->get('cart', []);
        // Handle Unit Addition
        if ($result) {
            // Generate a unique key for each unit
            $unitKey = 'unit_' . $result->id . '_' . time();
    
            // Add the unit to the cart
            $cart[$unitKey] = [
                'type'      => 'unit',
                'id'        => $result->id,
                'quantity'  => $result->min_qty,
            ];
        }
        session()->put('cart', $cart);
        return back()->with('message', 'Unit Added Successfully');

    }

}
