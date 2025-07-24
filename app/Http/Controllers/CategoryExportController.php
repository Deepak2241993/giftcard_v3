<?php

namespace App\Http\Controllers;
use App\Models\ProductCategory;
use App\Models\Product;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;

class CategoryExportController extends Controller
{
    public function exportCategories(Request $request)
    {
        // Fetch data from product_categories table
        $categories = ProductCategory::select(
            'id', 'cat_name','status'
        )->get();

        // Prepare CSV headers
        $csvHeader = [
            'ID', 'Deals Name','Active Status'
        ];

        // Open a file pointer for output
        $fileName = "deals.csv";
        $output = fopen('php://output', 'w');

        // Write CSV header
        fputcsv($output, $csvHeader);

        // Write the data rows to the CSV
        foreach ($categories as $category) {
            $status = $category->status == 1 ? 'Yes' : 'No';
            fputcsv($output, [
                $category->id,
                $category->cat_name,
                $status,
            ]);
        }

        fclose($output);

        // Create a response with CSV headers
        return Response::make('', 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$fileName}",
        ]);
    }

    // Full Field of Category  Export
    public function exportCategoriesWithAllFields(Request $request)
    {
        // Fetch data from product_categories table
        $categories = ProductCategory::select(
            'id', 'cat_name','cat_description','cat_image','deal_start_date','deal_end_date'
        )->get();

        // Prepare CSV headers
        $csvHeader = [
            'ID', 'Deal Name','Deal Description','Deal Image','Deal Start Date (mm-dd-yyyy)','Deal End Date (mm-dd-yyyy)'
        ];

        // Open a file pointer for output
        $fileName = "deals.csv";
        $output = fopen('php://output', 'w');

        // Write CSV header
        fputcsv($output, $csvHeader);

        // Write the data rows to the CSV
        foreach ($categories as $category) {
            // $status = $category->status == 1 ? 'Yes' : 'No';
            fputcsv($output, [
                $category->id,
                $category->cat_name,
                $category->cat_description,
                $category->cat_image,
                date('m-d-Y',strtotime($category->deal_start_date)),
                date('m-d-Y',strtotime($category->deal_end_date)),
                // $status,
            ]);
        }

        fclose($output);

        // Create a response with CSV headers
        return Response::make('', 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$fileName}",
        ]);
    }

    //  Product Table Export 
    public function exportServices(Request $request)
    {
        // Fetch data from product_categories table
        $products = Product::select(
            'id', 'product_name','short_description','product_description','prerequisites','product_image','amount','discounted_amount','session_number','cat_id','search_keywords','popular_service','giftcard_redemption'
        )->get();

        // Prepare CSV headers
        $csvHeader = [
            'ID', 'Service Name','Short Description','Service Description','Prerequisites','Service Image','Service Original Price','Service Price','Number of session','Enter Deals ID','Search Keywords','Popular Services (Yes-No)','Giftcard Redeem (Yes-No)'
        ];

        // Open a file pointer for output
        $fileName = "services.csv";
        $output = fopen('php://output', 'w');

        // Write CSV header
        fputcsv($output, $csvHeader);

        // Write the data rows to the CSV
        foreach ($products as $product) {
            $popular_service = $product->status == 1 ? 'Yes' : 'No';
            $giftcard_redemption = $product->status == 1 ? 'Yes' : 'No';
            fputcsv($output, [
                $product->id,
                $product->product_name,
                $product->short_description,
                $product->product_description,
                $product->prerequisites,
                $product->product_image,
                $product->amount,
                $product->discounted_amount,
                $product->session_number,
                $product->cat_id,
                $product->search_keywords,
                $popular_service,
                $giftcard_redemption,
                // $status,
            ]);
        }

        fclose($output);

        // Create a response with CSV headers
        return Response::make('', 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$fileName}",
        ]);
    }
    //  Product Table Export End
}
