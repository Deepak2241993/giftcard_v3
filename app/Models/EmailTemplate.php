<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    use HasFactory;
    public $timestamps = true;

    protected $table = 'email_templates';

    protected $fillable = [
        'title',
        'secondtitle',
        'message_email',

        'logo',
        'header_image',

        'button_text',
        'button_link',

        'footer_message',
        'footer_contact',

        'social_message',

        'social_media_1',
        'social_media_1_url',
        'social_media_2',
        'social_media_2_url',
        'social_media_3',
        'social_media_3_url',
        'social_media_4',
        'social_media_4_url',
        'template_name',
        'template_type',
        'status',
        'subject',
    ];
}
