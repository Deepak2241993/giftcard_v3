<?php

namespace App\Http\Controllers;

use App\Models\EmailTemplate;
use Illuminate\Http\Request;
use Purifier;
use Illuminate\Support\Facades\Storage;

class EmailTemplateController extends Controller
{
    /* ==============================
     * SHOW ALL TEMPLATES
     * ============================== */
    public function index()
    {
        $data = EmailTemplate::orderBy('id', 'DESC')->get();
        return view('admin.email_template.index', compact('data'));
    }

    /* ==============================
     * CREATE FORM
     * ============================== */
    public function create()
    {
        return view('admin.email_template.create');
    }

    /* ==============================
     * STORE TEMPLATE
     * ============================== */
    public function store(Request $request)
    {
        $data = $request->all();

        /* ---------- SANITIZE HTML ---------- */
        if (!empty($data['message_email'])) {
            $data['message_email'] = Purifier::clean($data['message_email'], 'email');
        }

        /* ---------- FILE UPLOADS ---------- */
        $data = $this->handleUploads($request, $data);

        EmailTemplate::create($data);

        return redirect()
            ->route('email-template.index')
            ->with('success', 'Email template created successfully');
    }

    /* ==============================
     * EDIT TEMPLATE
     * ============================== */
    public function edit(EmailTemplate $emailTemplate)
    {
        return view('admin.email_template.create', compact('emailTemplate'));
    }

    /* ==============================
     * UPDATE TEMPLATE
     * ============================== */
    public function update(Request $request, $id)
    {
        $template = EmailTemplate::findOrFail($id);
        $data = $request->all();

        /* ---------- SANITIZE HTML ---------- */
        if (!empty($data['message_email'])) {
            $data['message_email'] = Purifier::clean($data['message_email'], 'email');
        }

        /* ---------- FILE UPLOADS ---------- */
        $data = $this->handleUploads($request, $data, $template);

        $template->update($data);

        return back()->with('success', 'Email template updated successfully');
    }

    /* ==============================
     * DELETE TEMPLATE
     * ============================== */
    public function destroy(EmailTemplate $emailTemplate)
    {
        $emailTemplate->delete();

        return redirect()
            ->route('email-template.index')
            ->with('success', 'Template deleted successfully');
    }

    /* ==============================
     * PREVIEW TEMPLATE
     * ============================== */
    public function preview($id)
    {
        $template = EmailTemplate::findOrFail($id);

        // Dummy preview data
        $maildata = (object) [
            'fname'          => 'John',
            'lname'          => 'Doe',
            'order_id'       => 'PREVIEW-001',
            'sub_amount'     => '150.00',
            'taxrate'        => 8,
            'tax_amount'     => '12.00',
            'final_amount'   => '162.00',
        
        ];

        return view('admin.email_template.emailpreview', compact('template', 'maildata'));
    }

    /* ==============================
     * SUMMERNOTE IMAGE UPLOAD
     * ============================== */
    public function uploadImage(Request $request)
    {
        if (!$request->hasFile('file')) {
            return response()->json(['error' => 'No file uploaded'], 422);
        }

        $file = $request->file('file');
        $filename = time() . '_' . $file->getClientOriginalName();

        $path = $file->storeAs('email_images', $filename, 'public');

        return response()->json([
            'url' => asset('storage/' . $path)
        ]);
    }

    /* ==============================
     * FILE UPLOAD HANDLER (REUSABLE)
     * ============================== */
    private function handleUploads(Request $request, array $data, $template = null)
    {
        $fileFields = [
            'logo',
            'header_image',
            'social_media_1',
            'social_media_2',
            'social_media_3',
            'social_media_4',
        ];

        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('email_assets', $filename, 'public');

                $data[$field] = asset('storage/' . $path);
            } else {
                // keep old file during update
                if ($template && isset($template->$field)) {
                    $data[$field] = $template->$field;
                }
            }
        }

        return $data;
    }
}
