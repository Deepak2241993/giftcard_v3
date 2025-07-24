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
        Schema::create('service_units', function (Blueprint $table) {
            $table->bigIncrements('id'); // Primary key
            $table->string('product_name', 191)->nullable();
            $table->string('product_slug', 255)->nullable();
            $table->mediumText('short_description')->nullable();
            $table->mediumText('product_description')->nullable();
            $table->mediumText('product_image')->nullable();
            $table->string('user_token', 191)->nullable();
            $table->integer('min_qty')->nullable();
            $table->integer('max_qty')->nullable();
            $table->decimal('amount', 8, 2)->default(0.00);
            $table->tinyInteger('giftcard_redemption')->nullable();
            $table->decimal('discounted_amount', 8, 2)->default(0.00);
            $table->tinyInteger('status')->default(1); // Default to active
            $table->tinyInteger('product_is_deleted')->default(0); // Default to not deleted
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->string('meta_title', 191)->nullable();
            $table->string('meta_description', 191)->nullable();
            $table->string('meta_keywords', 191)->nullable();
            $table->string('cat_id', 255)->default('0');
            $table->integer('coupon_id')->nullable();
            $table->string('search_keywords', 255)->nullable();
            $table->mediumText('prerequisites')->nullable();
            $table->tinyInteger('popular_service')->default(0); // Default to not popular
            $table->integer('session_number')->nullable();
            $table->float('discount_rate')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_units');
    }
};
