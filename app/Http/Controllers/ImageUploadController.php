<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ImageUploadController extends Controller
{
    public function uploadMultipleImages(Request $request)
{
    $images = $request->file('images');
    $errorMessages = [];
    $uploadedFiles = [];

    // Check if there are any files
    if (!$images) {
        return response()->json(['message' => 'No images uploaded'], 400);
    }

    // Process each image separately
    foreach ($images as $image) {
        $validator = Validator::make(
            ['image' => $image],
            ['image' => 'required|mimes:jpg,jpeg,png|max:1024'] // max size in kilobytes
        );

        if ($validator->fails()) {
            // Add error with original image name if size is greater than 1024KB
            $errorMessages[] = 'Error with file "' . $image->getClientOriginalName() . '": ' . implode(', ', $validator->errors()->all());
        } else {
            // If validation passes, store the file
            $fileName = $image->getClientOriginalName();
            $filePath = $image->storeAs('images', $fileName, 'public');
            $uploadedFiles[] = Storage::url($filePath);
        }
    }

    // Response with both errors and successful uploads
    return response()->json([
        'message' => !empty($errorMessages) ? 'Some images failed to upload due to validation errors.' : 'All images uploaded successfully!',
        'errors' => $errorMessages,
        'files' => $uploadedFiles
    ]);
}

//  for image delete 

        public function deleteImage(Request $request)
        {
            $imagePath = $request->input('image');
            
            // Check if the image exists in storage
            if (Storage::exists($imagePath)) {
                // Delete the image from storage
                Storage::delete($imagePath);

                return response()->json(['success' => true]);
            }

            return response()->json(['success' => false, 'message' => 'Image not found']);
        }

//  for image delete 

}
