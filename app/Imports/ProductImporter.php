<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;  // Add this for logging

class ProductImporter implements ToModel, WithHeadingRow, SkipsEmptyRows
{
    public function model(array $row)
    {
        $row = array_change_key_case($row, CASE_LOWER);

         // Initialize an array to hold errors for this row
        $errors = [];
        
            // Skip if required fields are missing
            if (empty($row['service_name'])) {
                $errors[] = 'Service Name is required.';
            }
            // If there are errors, log them, add to session, and skip the row
            if (!empty($errors)) {
                Log::channel('import')->warning('Row skipped: Missing required fields', ['row' => $row, 'errors' => $errors]);

                // Store the errors in the session
                $importErrors = Session::get('import_errors', []);  // Retrieve previous errors
                $importErrors[] = ['row' => $row, 'errors' => $errors];
                Session::put('import_errors', $importErrors);  // Flash errors to the session

                return null; // Skip this row if it has errors
            }
            try { 
            $createdAt = now()->format('Y-m-d H:i:s');
            $updatedAt = now()->format('Y-m-d H:i:s');

            return Product::updateOrCreate(
                ['id' => $row['id'] ?? null],
                [
                    'product_name' => $row['service_name'] ?? null,
                    'product_slug' => Str::slug($row['service_name'], '-'),
                    'short_description' => $row['short_description'] ?? null,
                    'product_description' => $row['service_description'] ?? null,
                    'prerequisites' => $row['prerequisites'] ?? null,
                    // 'product_image' => isset($row['service_image']) ? url('/storage/images')."/".$row['service_image'] : null,
                    'product_image' => $row['service_image'],
                    'product_is_deleted' => 0,
                    'user_token' => 'FOREVER-MEDSPA',
                    'status' => 1,
                    'amount' => $row['service_original_price'] ?? null,
                    'discounted_amount' => $row['service_price'] ?? null,
                    'session_number' => $row['number_of_session'] ?? 1,
                    'cat_id' => $row['enter_deals_id'] ?? 1,
                    'search_keywords' => $row['search_keywords'] ?? 1,
                    'popular_service' => Str::lower($row['popular_services_yes_no']) == 'yes' ? 1 : 0,
                    'giftcard_redemption' => Str::lower($row['giftcard_redeem_yes_no']) == 'yes' ? 1 : 0,
                    'created_at' => $createdAt ?? now(),
                    'updated_at' => $updatedAt ?? now(),
                ]
            );

        } catch (\Exception $e) {
            // Log the error details to the Laravel log
            Log::error('Error processing row: ' . json_encode($row) . ' | Error: ' . $e->getMessage());
            // Optionally, you can also store this in a database table for detailed tracking
            // Store the row error
            $importErrors = Session::get('import_errors', []);  // Retrieve previous errors
            $importErrors[] = ['row' => $row, 'errors' => ['Error while importing']];
            Session::put('import_errors', $importErrors);  // Flash errors to the session
            return null;
        }
    }

    // You can keep the existing methods for date parsing, etc.
}
