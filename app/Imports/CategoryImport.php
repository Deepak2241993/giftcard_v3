<?php

namespace App\Imports;

use App\Models\ProductCategory;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
class CategoryImport implements ToModel, WithHeadingRow, SkipsEmptyRows
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

public function model(array $row)
{
    // Normalize the keys for case-insensitivity
    $row = array_change_key_case($row, CASE_LOWER);

    // Initialize an array to hold errors for this row
    $errors = [];

    // Check for missing required fields and log errors
    if (empty($row['deal_name'])) {
        $errors[] = 'Deal Name is required.';
    }
    if (empty($row['deal_start_date_mm_dd_yyyy']) || empty($row['deal_end_date_mm_dd_yyyy'])) {
        $errors[] = 'Deal start and end dates are required.';
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

    // Validate the date formats using Carbon
    try {
        $dealStartDate = Carbon::createFromFormat('m-d-Y', $row['deal_start_date_mm_dd_yyyy'])->format('Y-m-d');
        $dealEndDate = Carbon::createFromFormat('m-d-Y', $row['deal_end_date_mm_dd_yyyy'])->format('Y-m-d');
    } catch (\Exception $e) {
        // Log and skip the row if there is a date format error
        Log::channel('import')->warning('Row skipped: Invalid date format', ['row' => $row, 'error' => $e->getMessage()]);

        // Store the date format error
        $importErrors = Session::get('import_errors', []);  // Retrieve previous errors
        $importErrors[] = ['row' => $row, 'errors' => ['Invalid date format']];
        Session::put('import_errors', $importErrors);  // Flash errors to the session

        return null;
    }

    // Add other field validations if needed (e.g., checking for valid values)

    // Proceed to update or create the ProductCategory
    try {
        $createdAt = now()->format('Y-m-d H:i:s');
        $updatedAt = now()->format('Y-m-d H:i:s');

        return ProductCategory::updateOrCreate(
            ['id' => $row['id'] ?? null],
            [
                'cat_name' => $row['deal_name'] ?? null,
                'cat_description' => $row['deal_description'] ?? null,
                // 'cat_image' => isset($row['deal_image']) ? url('/storage/images')."/".$row['deal_image'] : null,
                'cat_image' => $row['deal_image'],
                'cat_is_deleted' => (int) ($row['cat_is_deleted'] ?? 0),
                'user_token' => 'FOREVER-MEDSPA',
                'status' => (int) ($row['status'] ?? 1),
                'slug' => Str::slug($row['deal_name'], '-'),
                'deal_start_date' => $dealStartDate,
                'deal_end_date' => $dealEndDate,
                'created_at' => $createdAt,
                'updated_at' => $updatedAt,
            ]
        );
    } catch (\Exception $e) {
        // If there's an error during the update or create, log it
        Log::channel('import')->error('Error while importing row', ['row' => $row, 'error' => $e->getMessage()]);

        // Store the row error
        $importErrors = Session::get('import_errors', []);  // Retrieve previous errors
        $importErrors[] = ['row' => $row, 'errors' => ['Error while importing']];
        Session::put('import_errors', $importErrors);  // Flash errors to the session

        return null; // Skip this row
    }
}



    private function parseDate($date)
    {
        if (empty($date)) {
            return null;
        }

        try {
            // Attempt multiple date formats
            return Carbon::createFromFormat('d-m-Y', $date)->format('Y-m-d');
        } catch (\Exception $e) {
            return null; // Skip if the format doesn't match
        }
    }

    // Function to parse date and time
    private function parseDateTime($dateTime, $format)
    {
        if (empty($dateTime)) {
            return null;
        }

        try {
            return Carbon::createFromFormat('d-m-Y H:i', $dateTime)->format($format);
        } catch (\Exception $e) {
            return null; // Skip if the format doesn't match
        }
    }
}
