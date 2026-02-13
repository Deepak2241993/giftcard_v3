<?php

namespace App\Http\Controllers;

use App\Models\Clinic;
use Illuminate\Http\Request;

class ClinicController extends Controller
{
    public function index()
    {
        $clinics = Clinic::where('is_deleted', 0)
            ->orderBy('id', 'DESC')
            ->get();

        return view('admin.clinics.index', compact('clinics'));
    }

    public function create()
    {
        return view('admin.clinics.create');
    }

    public function store(Request $request)
    {

        $request->validate([
            'clinic_name' => 'required|string|max:255',
            'phone'       => 'required|string|max:20',
            'email'       => 'nullable|email',
            'status'      => 'required|boolean',
        ]);
        Clinic::create($request->all());
        // Clinic::create([
        //     'clinic_name' => $request->clinic_name,
        //     'address'     => $request->address,
        //     'city'        => $request->city,
        //     'state'       => $request->state,
        //     'pincode'     => $request->pincode,
        //     'phone'       => $request->phone,
        //     'email'       => $request->email,
        //     'status'      => $request->status,
        //     'is_deleted'  => 0,
        //     'created_by'  => auth()->id(),
        //     'updated_by'  => auth()->id(),
        // ]);

        return redirect()
            ->route('clinics.index')
            ->with('success', 'Clinic created successfully.');
    }

    public function edit(Clinic $clinic)
    {
        if ($clinic->is_deleted) {
            abort(404);
        }

        return view('admin.clinics.create', compact('clinic'));
    }

    public function update(Request $request, Clinic $clinic)
    {
        if ($clinic->is_deleted) {
            abort(404);
        }

        $request->validate([
            'clinic_name' => 'required|string|max:255',
            'phone'       => 'required|string|max:20',
            'email'       => 'nullable|email',
            'status'      => 'required|boolean',
        ]);
        $clinic->update($request->all());
        // $clinic->update([
        //     'clinic_name' => $request->clinic_name,
        //     'address'     => $request->address,
        //     'city'        => $request->city,
        //     'state'       => $request->state,
        //     'pincode'     => $request->pincode,
        //     'phone'       => $request->phone,
        //     'email'       => $request->email,
        //     'status'      => $request->status,
        //     'updated_by'  => auth()->id(),
        // ]);

        return redirect()
            ->route('clinics.index')
            ->with('success', 'Clinic updated successfully.');
    }

    public function destroy(Clinic $clinic)
    {
        $clinic->update([
            'is_deleted' => 1,
            'updated_by' => auth()->id(),
        ]);

        return redirect()
            ->route('clinics.index')
            ->with('success', 'Clinic deleted successfully.');
    }

    // BULK ACTION
    public function bulkAction(Request $request)
    {
        $ids = $request->ids;

        if ($request->action_type === 'delete') {
            Clinic::whereIn('id', $ids)->update(['is_deleted' => 1]);
        }

        if ($request->action_type === 'active') {
            Clinic::whereIn('id', $ids)->update(['status' => 1]);
        }

        if ($request->action_type === 'inactive') {
            Clinic::whereIn('id', $ids)->update(['status' => 0]);
        }

        return response()->json(['message' => 'Action completed successfully']);
    }
}
