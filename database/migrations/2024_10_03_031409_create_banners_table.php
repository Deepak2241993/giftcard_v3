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
        Schema::create('banners', function (Blueprint $table) {
            $table->increments('id'); // Primary Key
            $table->string('title', 255)->nullable();
            $table->string('image', 255)->nullable();
            $table->string('url', 255)->nullable();
            $table->integer('status')->default(1); // Default value is 1
            $table->integer('sort_order')->nullable();
            $table->integer('is_deleted')->default(0); // Default value is 0
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->integer('type')->nullable()->default(1); // Default value is 1, for deals and services
            $table->string('deals_and_service', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('banners');
    }
};
