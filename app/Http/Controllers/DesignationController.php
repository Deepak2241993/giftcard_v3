<?php

namespace App\Http\Controllers;

use App\Models\Designation;
use Illuminate\Http\Request;

class DesignationController extends Controller
{
    public function index()
    {
        $designations = Designation::orderBy('level')->get();
        return view('admin.designations.index', compact('designations'));
    }

    public function create()
    {
        return view('admin.designations.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'designation_name' => 'required|string|max:255',
            'level'            => 'required|integer|min:1',
        ]);

        Designation::create($request->only('designation_name', 'level'));

        return redirect()
            ->route('designations.index')
            ->with('success', 'Designation created successfully.');
    }

    public function edit(Designation $designation)
    {
        return view('admin.designations.create', compact('designation'));
    }

    public function update(Request $request, Designation $designation)
    {
        $request->validate([
            'designation_name' => 'required|string|max:255',
            'level'            => 'required|integer|min:1',
        ]);

        $designation->update($request->only('designation_name', 'level'));

        return redirect()
            ->route('designations.index')
            ->with('success', 'Designation updated successfully.');
    }

    public function destroy(Designation $designation)
    {
        $designation->delete();

        return redirect()
            ->route('designations.index')
            ->with('success', 'Designation deleted successfully.');
    }
}
