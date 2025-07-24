<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use App\Models\Banner;
use App\Models\Product;
use Illuminate\Http\Request;
use Auth;
use Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


     public function index(Request $request)
{
    $token = Auth::user()->user_token;

    // Prepare data for API request, including search filters and pagination parameters
    $data_arr = ['user_token' => $token] + $request->except('_token');
    $data_arr['page'] = $request->input('page', 1); // Current page
    $data_arr['per_page'] = 10; // Items per page
    $data = json_encode($data_arr);

    // Call the external API to get categories
    $response = $this->postAPI('category-list', $data);

    // Check if the response is valid and contains the expected structure
    if ($response && isset($response['status']) && $response['status'] == 200) {
        // Convert the API result to a collection
        $categories = collect($response['result'] ?? []);

        // Pagination parameters
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = $data_arr['per_page'];
        $total = $response['total'] ?? 0;

        // Creating a paginator instance
        $paginator = new LengthAwarePaginator(
            $categories,       // Items for the current page (can be empty)
            $total,            // Total items
            $perPage,          // Items per page
            $currentPage,      // Current page
            ['path' => $request->url(), 'query' => $request->query()] // Maintain URL and query parameters
        );

        // Image Show
        $images = Storage::files('public/images');
        // Pass the paginator to the view
        return view('admin.product.category_index', ['paginator' => $paginator],compact('images'));

    } else {
        // If no categories are found or an error occurs, create an empty paginator
        $categories = collect(); // Empty collection

        // Pagination parameters for an empty result
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = $data_arr['per_page'];
        $total = 0; // No total items in this case

        // Create an empty paginator
        $paginator = new LengthAwarePaginator(
            $categories,   // Empty collection
            $total,        // Zero total items
            $perPage,      // Items per page
            $currentPage,  // Current page
            ['path' => $request->url(), 'query' => $request->query()] // Maintain URL and query parameters
        );

        // Handle error if response is not valid or no categories found
        $errorMsg = $response['error'] ?? 'No categories found.';
        
        //  For Media Code
        $images = Storage::files('public/images');
        // Pass empty paginator and error message to the view
        return view('admin.product.category_index', ['paginator' => $paginator, 'error' => $errorMsg],compact('images'));
    }
}




    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('admin.product.category_create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


     public function store(Request $request, ProductCategory $category)
    {
    // Ensure the user is authenticated and retrieve the user's token
    $token = Auth::user()->user_token;

    // Retrieve all request data except '_token'
    $data = $request->except('_token');

    // Add the user's token to the data
    $data['user_token'] = $token;

    if ($request->hasFile('cat_image')) {
        $folder = str_replace(" ", "_", $token);
        $image = $request->file('cat_image');
    
        // Define the upload path
        $destinationPath = '/uploads/' . $folder . "/";
        $filename = $image->getClientOriginalName();
    
        // Move the image to the destination path
        $image->move(public_path($destinationPath), $filename);
    
        // Store the image URL
        $data['cat_image'] = url('/') . $destinationPath . $filename;
    }
    
    
    // Send data to API endpoint using cURL
    $curl = curl_init();
  
    // Set cURL options
    curl_setopt_array($curl, array(
        CURLOPT_URL => env('API_URL') . 'category-created', // API URL
        CURLOPT_RETURNTRANSFER => true, // Return the response as a string
        CURLOPT_ENCODING => '', // Enable compression
        CURLOPT_MAXREDIRS => 10, // Follow up to 10 redirects
        CURLOPT_TIMEOUT => 0, // No timeout
        CURLOPT_FOLLOWLOCATION => true, // Follow redirects
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1, // HTTP version
        CURLOPT_CUSTOMREQUEST => 'POST', // Request method
        CURLOPT_POSTFIELDS => $data, // POST data
        CURLOPT_HTTPHEADER => array(
            'Authorization: Basic Og==' // Example authorization header
        ),
    ));
    
    // Execute cURL request
    $result = curl_exec($curl);
    // Check for errors
    if(curl_errno($curl)) {
        // Handle cURL error
        $error_message = curl_error($curl);
        // You may want to log or handle the error appropriately
        return "cURL Error: " . $error_message;
    }

    // Close cURL session
    curl_close($curl);

    // Decode the JSON response
    $result = json_decode($result, true);

    // Check the result of the API call
    if ($result && isset($result['status']) && $result['status'] == 200) {
        // Redirect with success message if the API call was successful
        return redirect(route('category.index'))->with('success', $result['msg']);
    } else {
        // Redirect back with error message if the API call failed
        return redirect()->back()->with('error', $result['msg']);
    }
}
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function show(ProductCategory $productCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductCategory $productCategory,$id)
    {
        $token= Auth::user()->user_token;
        $data_arr = ['user_token'=>$token];
        $data = json_encode($data_arr);
        $data = $this->getAPI('category/'.$id.'?user_token='.$token);
        $data=$data['result'];
        return view('admin.product.category_create',compact('data')); }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */


public function update(Request $request,$id)
{
    $token= Auth::user()->user_token;
    $data = $request->except('_token','_method');
    $data['user_token'] = $token;

    if ($request->hasFile('cat_image')) {
        $folder = str_replace(" ", "_", $token);
        $image = $request->file('cat_image');
    
        // Define the upload path
        $destinationPath = '/uploads/' . $folder . "/";
        $filename = $image->getClientOriginalName();
    
        // Move the image to the destination path
        $image->move(public_path($destinationPath), $filename);
    
        // Store the image URL
        $data['cat_image'] = url('/') . $destinationPath . $filename;
    }
    
    
    
    $data = json_encode($data);
    $data = $this->postAPI('category-update/'.$id,$data);

    return redirect(route('category.index'))->with('success', $data['msg']);
}


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */

 
     public function destroy(Request $request,$id)
     {
           
            // Get user token
            $token = Auth::user()->user_token;
            
            // Prepare data for API call
            $data_arr = ['user_token'=>$token, 'id'=>$id];
            $data = json_encode($data_arr);
            
            // Make API call to delete category
            $response = $this->postAPI('categoryDelete/' . $id, $data);
         // Check if API call was successful
         if ($response && isset($response['status']) && $response['status']==200) {
             return redirect(route('category.index'))->with('success', $response['msg']);
         }
          else {
             // If deletion fails, handle the error appropriately
             return redirect()->back()->with('error', $response['msg']);
         }
     }

     public function categorytpage(Request $request,$slug){
       $ProductCategory = ProductCategory::where('slug', $slug)
        ->where('cat_is_deleted', 0)
        ->where('status', 1)
        ->where('user_token', 'FOREVER-MEDSPA')
        ->firstOrFail();

    $categoryId = $ProductCategory->id;

    $services = Product::where('product_is_deleted', 0)
        ->where('status', 1)
        ->where('user_token', 'FOREVER-MEDSPA')
        ->where('cat_id', $categoryId)
        // ->where(function ($query) use ($categoryId) {
        //     $query->where('unit_id', 'like', $categoryId . '|%')
        //         ->orWhere('unit_id', 'like', '%|' . $categoryId . '|%')
        //         ->orWhere('unit_id', 'like', '%|' . $categoryId)
        //         ->orWhere('unit_id', $categoryId);
        // })
        ->paginate(10); // Paginate with 15 per page


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
        // dd($category);
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


     function slugCreate(Request $request){
        $slug= Str::slug($request->product_name);
        return response()->json(['success' => 'Slug Created!','slug'=>$slug]);
     }

     public function FindDeals(Request $request)
{
    $token = Auth::user()->user_token;

    // Validate request data
    $validatedData = $request->validate([
        'cat_name' => 'required|string',
    ]);
    // Prepare data for API request
    $data = $request->except('_token');
    $data['user_token'] = $token;

    // Get pagination parameters
    $currentPage = $request->input('page', 1); // Default to page 1 if not provided
    $perPage = 10; // Define how many items you want per page
    $data['page'] = $currentPage;
    $data['limit'] = $perPage;

    // Call the external API
    $response = $this->postAPI('deals-search', $data);

    // Check the response and handle success or error
    if ($response && isset($response['status']) && $response['status'] == 200) {
        // Assuming response contains 'data' array and 'total' for pagination
        $deals = collect($response['data'] ?? []);
        $total = $response['total'] ?? 0; // Use the total from the API response

        // Create a paginator instance
        $paginator = new LengthAwarePaginator(
            $deals->forPage($currentPage, $perPage), // Items for the current page
            $total, // Total number of items
            $perPage, // Items per page
            $currentPage, // Current page
            ['path' => $request->url(), 'query' => $request->query()] // Maintain URL and query parameters
        );
       

        // Pass the paginator to the view
        return view('admin.product.category_index', ['deals' => $paginator])
            ->with('success', $response['success'] ?? 'Deals found successfully.');
    } else {
        // Provide a default error message if 'success' is not set in the response
        $errorMsg = $response['success'] ?? 'An error occurred while searching for deals. Please try again.';
        return redirect()->back()->with('error', $errorMsg);
    }
}


}




