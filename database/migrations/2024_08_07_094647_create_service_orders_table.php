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
        Schema::create('service_orders', function (Blueprint $table) {
            $table->increments('id'); // Primary Key
            $table->string('order_id', 255)->nullable();
            $table->string('service_id', 255)->nullable();
            $table->string('service_type', 255)->nullable();
            $table->integer('qty')->nullable();
            $table->string('number_of_session', 255)->nullable();
            $table->tinyInteger('status')->nullable();
            $table->string('user_token', 255)->nullable();
            $table->string('actual_amount', 255)->nullable();
            $table->string('discounted_amount', 255)->nullable();
            $table->string('payment_mode', 255)->nullable();
            $table->tinyInteger('is_deleted')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_orders');
    }
};
