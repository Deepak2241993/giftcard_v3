<?php

namespace App\Http\Controllers;
use App\Imports\CategoryImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;

use Illuminate\Http\Request;

class ProductCategoryImportController extends Controller
{
    public function import(Request $request)
    {
        // Validate the incoming file
        $request->validate([
            'file' => 'required|mimes:xlsx,csv',
        ]);
    
        // Try to import the file and handle potential errors
        try {
            $result = Excel::import(new CategoryImport, $request->file('file'));
            
            // If everything is successful
            return redirect()->back()->with('success', 'Deals are imported successfully!');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            // Catch validation exceptions and return errors
            $errors = $e->getErrors();
            
            return redirect()->back()->with('error', 'There were issues with the file. Please check the file and try again.')
                ->withErrors($errors);
        } catch (\Exception $e) {
            // Catch any other exceptions
            return redirect()->back()->with('error', 'An unexpected error occurred during the import.')
                ->with('details', $e->getMessage());
        }
    }

    public function clearErrors()
    {
        // Forget the 'import_errors' session
        Session::forget('import_errors');
        
        // Redirect back to the previous page (or you can redirect to a specific page)
        return redirect()->back()->with('success', 'Errors cleared successfully!');
    }
    
}
