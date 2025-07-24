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
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id'); // Primary Key
            $table->string('product_name', 191)->nullable();
            $table->mediumText('product_description')->nullable();
            $table->text('product_image')->nullable();
            $table->string('product_order_by', 191)->nullable();
            $table->string('product_fetured', 191)->nullable();
            $table->string('meta_title', 191)->nullable();
            $table->string('meta_description', 191)->nullable();
            $table->string('meta_keywords', 191)->nullable();
            $table->tinyInteger('product_is_deleted')->default(0);
            $table->string('user_token', 191)->nullable();
            $table->tinyInteger('status')->default(1);
            $table->string('cat_id', 255)->default(0);
            $table->decimal('amount', 8, 2)->default(0.00);
            $table->integer('coupon_id')->nullable();
            $table->decimal('discounted_amount', 8, 2)->default(0.00);
            $table->string('search_keywords', 255)->nullable();
            $table->mediumText('prerequisites')->nullable();
            $table->mediumText('short_description')->nullable();
            $table->tinyInteger('popular_service')->default(0);
            $table->string('product_slug', 255)->nullable();
            $table->integer('session_number')->default(0);
            $table->float('discount_rate')->nullable();
            $table->tinyInteger('giftcard_redemption')->default(0);
            $table->string('unit_id', 255)->nullable();
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
        Schema::dropIfExists('products');
    }
};
