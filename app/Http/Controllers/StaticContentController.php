<?php

namespace App\Http\Controllers;

use App\Models\StaticContent;
use Illuminate\Http\Request;

class StaticContentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = StaticContent::all();
        return view('admin.static_content.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.static_content.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'page_name' => 'required',
            'title' => 'required',
            'content' => 'required',
        ]);

        $staticContent = new StaticContent();
        $staticContent->page_name = $request->page_name;
        $staticContent->title = $request->title;
        $staticContent->content = $request->content;
        $staticContent->save();

        return redirect()->route('static-content.index')
            ->with('success', 'Static content created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(StaticContent $staticContent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StaticContent $staticContent)
    {
        return view('admin.static_content.create', compact('staticContent'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StaticContent $staticContent)
    {
        $request->validate([
            'page_name' => 'required',
            'title' => 'required',
            'content' => 'required',
        ]);

        $staticContent->page_name = $request->page_name;
        $staticContent->title = $request->title;
        $staticContent->content = $request->content;
        $staticContent->save();

        return redirect()->route('static-content.index')
            ->with('success', 'Static content updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StaticContent $staticContent)
    {
        //
    }
}
