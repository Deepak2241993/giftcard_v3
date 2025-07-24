<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_categories', function (Blueprint $table) {
            $table->bigIncrements('id'); // Primary Key
            $table->string('cat_name', 191)->nullable();
            $table->mediumText('cat_description')->nullable();
            $table->string('cat_image', 255)->nullable();
            $table->string('cat_order_by', 255)->nullable();
            $table->string('meta_title', 255)->nullable();
            $table->string('meta_description', 255)->nullable();
            $table->string('meta_keywords', 255)->nullable();
            $table->tinyInteger('cat_is_deleted')->default(0);
            $table->string('user_token', 191)->nullable();
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('parent_id')->default(0);
            $table->string('slug', 255)->nullable();
            $table->date('deal_start_date')->nullable();
            $table->date('deal_end_date')->nullable();
            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_categories');
    }
};
