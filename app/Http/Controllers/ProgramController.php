<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Program;
use App\Models\ServiceUnit;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Program::where('is_deleted', 0)
        ->get();
    
        return view('admin.program.index', compact('data'));

    }

     public function PatientProgramBuy(Request $request, $id)
    {
        $data = Program::
        where('status', 1)
        ->where('is_deleted', 0)
        ->get();
        return view('admin.program.index', compact('data','id'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $units = ServiceUnit::where('status',1)->where('product_is_deleted',0)->get();
        return view('admin.program.create',compact('units'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,Program $program)
    {
        
        $data = $request->all();
        if (isset($data['unit_id']) && is_array($data['unit_id'])) {
            $data['unit_id'] = implode('|', $data['unit_id']);
        }
        $program->create($data);
        return redirect(route('program.index'))->with('message', 'Program Created Successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Program  $program
     * @return \Illuminate\Http\Response
     */
    public function show(Program $program)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Program  $program
     * @return \Illuminate\Http\Response
     */
    public function edit(Program $program)
    {
        $units = ServiceUnit::where('status',1)->where('product_is_deleted',0)->get();
        $selectedUnits = explode('|',$program->unit_id);
        return view('admin.program.create',compact('units','program','selectedUnits'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Program  $program
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Program $program)
    {
        $data = $request->all();
        if (isset($data['unit_id']) && is_array($data['unit_id'])) {
            $data['unit_id'] = implode('|', $data['unit_id']);
        }
        $program->update($data);
        return redirect(route('program.index'))->with('message', 'Program Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Program  $program
     * @return \Illuminate\Http\Response
     */
    public function destroy(Program $program)
    {
        $program->update(['is_deleted'=>1]);
        return redirect(route('program.index'))->with('message', 'Program Deleted Successfully');

    }

    // Single Duplicate
    public function duplicate($id)
    {
        $program = Program::findOrFail($id);

        $new = $program->replicate();
        $new->program_name = $program->program_name . ' (Copy)';
        $new->created_at = now();
        $new->updated_at = now();
        $new->save();

        return back()->with('success', 'Program duplicated successfully');
    }

    public function bulkAction(Request $request)
    {
        $ids = $request->ids;
        $action = $request->action_type;

        if ($action == "delete") {
            Program::whereIn('id', $ids)->delete();
            return response()->json(['message' => 'Programs deleted successfully']);
        }

        if ($action == "active") {
            Program::whereIn('id', $ids)->update(['status' => 1]);
            return response()->json(['message' => 'Programs marked Active']);
        }

        if ($action == "inactive") {
            Program::whereIn('id', $ids)->update(['status' => 0]);
            return response()->json(['message' => 'Programs marked Inactive']);
        }

        if ($action == "duplicate") {
            foreach ($ids as $id) {
                $program = Program::find($id);
                if ($program) {
                    $new = $program->replicate();
                    $new->program_name = $program->program_name . ' (Copy)';
                    $new->save();
                }
            }
            return response()->json(['message' => 'Programs duplicated successfully']);
        }

        return response()->json(['message' => 'Invalid Action'], 400);
    }


}
