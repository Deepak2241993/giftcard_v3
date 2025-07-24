<?php

namespace App\Http\Controllers;

use App\Imports\ProductImporter;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductImportController extends Controller
{
    public function import(Request $request)
    {
        // Validate the file type
        $request->validate([
            'file' => 'required|mimes:xlsx,csv',
        ]);

        try {
            // Import the file using the ProductImporter
            Excel::import(new ProductImporter, $request->file('file'));

            return redirect()->back()->with('success', 'Services imported successfully!');

        } catch (\Exception $e) {
            // If an error happens, log the error and provide a detailed error message
            Log::error('Product import failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'There was an issue importing the file. Please check the logs for details.');
        }
    }
}
