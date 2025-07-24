<?php

namespace App\Http\Controllers;
use App\Models\EmailTemplate;
use Illuminate\Http\Request;

class EmailTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,EmailTemplate $template)
    {
        $data = $template->orderBy('id', 'DESC')->get();
        return view('email_template.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('email_template.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,EmailTemplate $template)
    {
        $data=$request->all();
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $destinationPath = '/email_template/';
            $filename = $image->getClientOriginalName();
            $image->move(public_path($destinationPath), $filename);
            $data['image'] = url('/').$destinationPath.$filename;
        }
        $result=$template->create($data);
        if($result)
        {
            return redirect(route('email-template.index'));
        }
        else{
            return back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EmailTemplate  $emailTemplate
     * @return \Illuminate\Http\Response
     */
    public function show(EmailTemplate $emailTemplate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EmailTemplate  $emailTemplate
     * @return \Illuminate\Http\Response
     */
    public function edit(EmailTemplate $emailTemplate)
    {
        $page_title="Edit Template";
        return view('email_template.create',compact('page_title','emailTemplate'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EmailTemplate  $emailTemplate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EmailTemplate $emailTemplate)
    {
        $data=$request->all();
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $destinationPath = '/email_template/';
            $filename = $image->getClientOriginalName();
            $image->move(public_path($destinationPath), $filename);
            $data['image'] = url('/').$destinationPath.$filename;
        }
        $emailTemplate->update($data);
        return redirect(route('email-template.index'))->with('message','Template Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EmailTemplate  $emailTemplate
     * @return \Illuminate\Http\Response
     */
    public function destroy(EmailTemplate $emailTemplate)
    {
        $emailTemplate->delete();
        return redirect(route('email-template.index'))->with('message','Template Deleted Successfully');
    }
}
