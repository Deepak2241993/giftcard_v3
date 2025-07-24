<?php

namespace App\Http\Controllers;
use PDF;
use App\Models\Term;

use Illuminate\Http\Request;

class PDFController extends Controller
{
    public function generatePDF($id)
    {
        $result = Term::find($id);
        $data = [
            'company' => 'Forever Mdespa & Wellness Center',
            'date' => date('m/d/Y'),
            'email'=> 'info@forevermedspanj.com',
            'phone'=> '(201) 3404809',
            'address_1'=> '468 Paterson Ave,',
            'address_2'=> 'East Rutherford, New Jersey, 07073',
            'terms'=> $result->description
        ];
        
        // Load a view and pass the data
        // $pdf = PDF::loadView('myPDF', $data)->setPaper('a4', 'landscape');
      $pdf = PDF::loadView('terms_and_condition.terms', $data)->setPaper('a4', 'portrait');

      // Download the PDF with a given name
      $file_name = 'terms_&_conditions.pdf';
      return $pdf->download($file_name);
      // Or to display the PDF in the browser
    //    return $pdf->stream('terms_and_conditions.pdf');
    }
}
