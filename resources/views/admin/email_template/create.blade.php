@extends('layouts.admin_layout')

@section('body')

@php
    $isEdit = isset($emailTemplate);
@endphp

<form method="POST"
      action="{{ $isEdit ? route('email-template.update', $emailTemplate->id) : route('email-template.store') }}"
      enctype="multipart/form-data">
@csrf
@if($isEdit)
    @method('PUT')
@endif

<table id="u_body"
style="border-collapse:collapse;table-layout:fixed;min-width:320px;margin:0 auto;background-color:#e7e7e7;width:100%;"
cellpadding="0" cellspacing="0">
<tbody>
<tr>
<td>

<!-- ================= HEADER ================= -->
<div class="u-row-container">
<div class="u-row" style="max-width:600px;margin:0 auto;">
<div class="u-col u-col-100">

<div style="background:#000000;">
<div style="padding:20px;background:#fca52a;">
<strong>Header Logo</strong>

@if($isEdit && !empty($emailTemplate->logo))
    <div style="margin:10px 0;">
        <img src="{{ $emailTemplate->logo }}" height="50">
    </div>
@endif

<input type="file" name="logo" style="width:100%;margin-top:5px;">
</div>

<table width="100%">
<tr>
<td style="padding:40px 10px;">
<input type="text"
       name="title"
       value="{{ old('title', $emailTemplate->title ?? '') }}"
       placeholder="Enter Title"
       style="width:100%;padding:10px;font-size:24px;text-align:center;">
</td>
</tr>

<tr>
<td>
<input type="text"
       name="secondtitle"
       value="{{ old('secondtitle', $emailTemplate->secondtitle ?? '') }}"
       placeholder="Enter Subtitle"
       style="width:100%;padding:10px;font-size:20px;text-align:center;">
</td>
</tr>
</table>

<div style="padding:20px;text-align:center;color:#ffffff;background:#000000">
<strong>Header Image</strong><br>

@if($isEdit && !empty($emailTemplate->header_image))
    <img src="{{ $emailTemplate->header_image }}" style="max-width:100%;margin:10px 0;">
@endif

<input type="file" name="header_image">
</div>

</div>
</div>
</div>
</div>

<!-- ================= BODY ================= -->
<div class="u-row-container">
<div class="u-row" style="max-width:600px;margin:0 auto;">
<div class="u-col u-col-100">
<div style="background:#ffffff;padding:20px;">

<textarea name="message_email"
class="summernote"
placeholder="Enter email message">
{{ old('message_email', $emailTemplate->message_email ?? '') }}
</textarea>

<hr>

<input type="text"
       name="footer_message"
       value="{{ old('footer_message', $emailTemplate->footer_message ?? '') }}"
       placeholder="Footer Message"
       style="width:100%;padding:10px;text-align:center;">

</div>
</div>
</div>
</div>

<!-- ================= CTA BUTTON ================= -->
<div class="u-row-container">
<div class="u-row" style="max-width:600px;margin:0 auto;">
<div class="u-col u-col-100">
<div style="background:#ffffff;padding:20px;text-align:center;">

<input type="text"
       name="button_text"
       value="{{ old('button_text', $emailTemplate->button_text ?? '') }}"
       placeholder="Button Text"
       style="width:100%;padding:12px;margin-bottom:10px;">

<input type="url"
       name="button_link"
       value="{{ old('button_link', $emailTemplate->button_link ?? '') }}"
       placeholder="Button Link (https://...)"
       style="width:100%;padding:12px;">

</div>
</div>
</div>
</div>

<!-- ================= SOCIAL MEDIA ================= -->
<div class="u-row-container">
<div class="u-row" style="max-width:600px;margin:0 auto;">
<div class="u-col u-col-100">
<div style="background:#ffffff;padding:20px;">

<p style="text-align:center;font-weight:bold;">Follow us on Social Media</p>

<input type="text"
       name="social_message"
       value="{{ old('social_message', $emailTemplate->social_message ?? '') }}"
       placeholder="Social media message"
       style="width:100%;padding:10px;text-align:center;margin-bottom:15px;">

@foreach([1,2,3,4] as $i)
<div style="margin-bottom:10px;">

@if($isEdit && !empty($emailTemplate->{'social_media_'.$i}))
    <img src="{{ $emailTemplate->{'social_media_'.$i} }}" width="32">
@endif

<input type="file" name="social_media_{{ $i }}">

<input type="url"
       name="social_media_{{ $i }}_url"
       value="{{ old('social_media_'.$i.'_url', $emailTemplate->{'social_media_'.$i.'_url'} ?? '') }}"
       placeholder="https://"
       style="width:100%;padding:6px;margin-top:5px;">
</div>
@endforeach

</div>
</div>
</div>
</div>

<!-- ================= FOOTER ================= -->
<div class="u-row-container">
<div class="u-row" style="max-width:600px;margin:0 auto;">
<div class="u-col u-col-100">
<div style="background:#fca52a;padding:30px;text-align:center;">

<input type="text"
       name="footer_contact"
       value="{{ old('footer_contact', $emailTemplate->footer_contact ?? '') }}"
       placeholder="Copyright / Footer text"
       style="width:100%;padding:10px;text-align:center;">

</div>
</div>
</div>
</div>

</td>
</tr>
</tbody>
</table>



<div style="text-align:center; margin:30px;">
    <!-- Template Subject -->
    <div style="margin-bottom:10px;">
        <input type="text"
               name="subject"
               value="{{ old('subject', $emailTemplate->subject ?? '') }}"
               placeholder="Template Name"
               style="padding:10px; width:300px;">
    </div>
@if(!isset($emailTemplate) || $emailTemplate->template_type !== 'internal')

    <!-- Template Name -->
    <div style="margin-bottom:10px;">
        <input type="text"
               name="template_name"
               value="{{ old('template_name', $emailTemplate->template_name ?? '') }}"
               placeholder="Template Name"
               style="padding:10px; width:300px;">
    </div>

    <!-- Template Type -->
    <div style="margin-bottom:10px;">
        <select name="template_type" required style="padding:10px; width:300px;">
            <option value="" disabled
                {{ old('template_type', $emailTemplate->template_type ?? '') == '' ? 'selected' : '' }}>
                Select Template Type
            </option>
            <option value="internal"
                {{ old('template_type', $emailTemplate->template_type ?? '') == 'internal' ? 'selected' : '' }}>
                Internal
            </option>
            <option value="external"
                {{ old('template_type', $emailTemplate->template_type ?? '') == 'external' ? 'selected' : '' }}>
                External
            </option>
        </select>
    </div>

    <!-- Status -->
    <div style="margin-bottom:20px;">
        <select name="status" required style="padding:10px; width:300px;">
            <option value="1"
                {{ old('status', $emailTemplate->status ?? 1) == 1 ? 'selected' : '' }}>
                Active
            </option>
            <option value="0"
                {{ old('status', $emailTemplate->status ?? 1) == 0 ? 'selected' : '' }}>
                Inactive
            </option>
        </select>
    </div>

@endif

    <!-- Submit -->
    <button type="submit"
        style="padding:12px 40px; font-size:16px; font-weight:bold;
               background:#0d6efd; color:#fff; border:none; border-radius:6px;">
        {{ $isEdit ? 'Update Email Template' : 'Save Email Template' }}
    </button>

</div>


</form>
@endsection
