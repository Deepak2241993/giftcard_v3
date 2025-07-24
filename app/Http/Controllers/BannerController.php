<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\ProductCategory;
use App\Models\ServiceUnit;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; // Import Log facade
class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Banner $b)
    {
        $result =Banner::all();
        return view('admin.banners.index',compact('result'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $unit = ServiceUnit::where('product_is_deleted', 0)
        ->where('status', 1)
        ->get();

        $services = Product::where('product_is_deleted', 0)
        ->where('status', 1)
        ->get();

        return view('admin.banners.create',compact('unit','services'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Banner $banner)
{
    // Log request data for debugging
    Log::info('Banner store request received', ['request_data' => $request->all()]);

    // Validate the image input
    $request->validate([
        'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:1024', // Max size in KB (1024 KB = 1 MB)
    ]);

    $data = $request->all();

    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $destinationPath = '/sliders/';
        $filename = time() . '_' . $image->getClientOriginalName(); // Adding timestamp to avoid filename conflicts

        // Log before uploading the image
        Log::info('Uploading image', [
            'filename' => $filename,
            'destination' => public_path($destinationPath)
        ]);

        $image->move(public_path($destinationPath), $filename);
        $data['image'] = url('/') . $destinationPath . $filename;

        // Log successful upload
        Log::info('Image successfully uploaded', ['image_url' => $data['image']]);
    } else {
        return redirect()->back()->withErrors([
            'image' => 'No image file was uploaded.'
        ])->withInput();
    }

    $result = $banner->create($data);

    if ($result) {
        Log::info('Banner successfully created', ['banner_data' => $data]);
        return redirect(route('banner.index'))->with(['success' => 'Slider is created successfully']);
    } else {
        Log::error('Failed to create banner', ['banner_data' => $data]);
        return back()->with(['error' => 'Failed to create banner.']);
    }
}



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function show(Banner $banner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function edit(Banner $banner)
    {
        $unit = ServiceUnit::where('product_is_deleted', 0)
        ->where('status', 1)
        ->get();


        $services = Product::where('product_is_deleted', 0)
        ->where('status', 1)
        ->get();
        return view('admin.banners.create',compact('banner','unit','services'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Banner $banner)
    {
        // Validate the input
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:1024', // Max size in KB (1024 KB = 1 MB)
        ]);
    
        $data = $request->all();
    
        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageSize = getimagesize($image); // Get image dimensions
    
            // Check image dimensions
            if ($imageSize[0] <= 1349 && $imageSize[1] <= 550) {
                $destinationPath = '/sliders/';
                $filename = time() . '_' . $image->getClientOriginalName(); // Add timestamp for uniqueness
                $image->move(public_path($destinationPath), $filename);
                $data['image'] = url('/') . $destinationPath . $filename;
    
                // Optionally delete the old image
                if (!empty($banner->image)) {
                    $oldImagePath = str_replace(url('/'), public_path(), $banner->image);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }
            } else {
                return back()->withErrors(['image' => 'Image dimensions should not exceed 1349x550 pixels.'])->withInput();
            }
        } else {
            // Retain the current image if no new image is uploaded
            $data['image'] = $banner->image;
        }
    
        // Update the banner
        $banner->update($data);
    
        return redirect(route('banner.index'))->with('message', 'Slider updated successfully');
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function destroy(Banner $banner)
    {
        $banner->delete();
        return redirect(route('banner.index'))->with('message','Slider deleted successfully');
    }
}
