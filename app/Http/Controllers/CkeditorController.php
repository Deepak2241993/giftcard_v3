<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CkeditorController extends Controller
{
    public function uploadImage(Request $request) {
        $response = [];
    
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');
            $extension = $file->getClientOriginalExtension();
    
            // Validate the file extension
            $allowedExtensions = ['jpg', 'gif', 'png'];
            if (in_array(strtolower($extension), $allowedExtensions)) {
                // Generate a unique name for the file
                $newImageName = uniqid() . '.' . $extension;
    
                // Store the file in the 'public/ckeditor' directory
                $path = $file->storeAs('public/ckeditor', $newImageName);
    
                // Get the URL of the uploaded file
                $url = Storage::url($path);
    
                // Prepare the CKEditor response
                $function_number = $request->input('CKEditorFuncNum');
                $message = '';
                echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($function_number, '$url', '$message');</script>";
            } else {
                $response['error'] = 'Invalid file extension. Allowed extensions: jpg, gif, png';
            }
        } else {
            $response['error'] = 'No file uploaded';
        }
    
        // Return the response
        return response()->json($response);
    }
}
