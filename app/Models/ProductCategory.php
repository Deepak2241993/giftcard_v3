<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;
    protected $fillable=['id','cat_name', 'cat_description', 'cat_image', 'cat_order_by', 'meta_title', 'meta_description', 'meta_keywords', 'cat_is_deleted', 'user_token', 'status', 'parent_id', 'created_at', 'updated_at','slug','deal_start_date','deal_end_date'];
}
