<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InternalOrderController extends Controller
{
    public function CartCancel(Request $request)
    {
        // Clear the cart session
        $request->session()->forget('cart');
        $request->session()->forget('internal_patient_id');

        // Redirect to a specific page with a success message
        return redirect()->route('patient.index')->with('success', 'Cart has been canceled and cleared.');
    }

    public function ChangePatient(Request $request)
    {
        // dd(session()->all());
        // Clear the cart session
        $request->session()->forget('internal_patient_id');

        // Redirect to a specific page with a success message
        return back()->with('success', 'Please select a new patient.');
    }

}
