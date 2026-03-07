<?php

use App\Models\StaticContent;

if (!function_exists('getStaticContent')) {
    function getStaticContent($id)
    {
        return StaticContent::find($id);
    }
}