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
        Schema::create('transaction_histories', function (Blueprint $table) {
            $table->bigIncrements('id'); // Primary Key
            $table->string('order_id', 255)->nullable();
            $table->string('fname', 255)->nullable();
            $table->string('lname', 255)->nullable();
            $table->string('city', 255)->nullable();
            $table->string('country', 255)->nullable();
            $table->integer('zip_code')->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('address', 255)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('transaction_id', 191)->nullable();
            $table->string('sub_amount', 191)->nullable();
            $table->string('tax_amount', 255)->nullable();
            $table->string('final_amount', 255)->nullable();
            $table->string('transaction_amount', 255)->nullable();
            $table->string('payment_session_id', 255)->nullable();
            $table->string('status', 255)->nullable();
            $table->string('payment_status', 255)->nullable();
            $table->string('transaction_status', 255)->nullable();
            $table->string('gift_card_applyed', 255)->nullable();
            $table->string('gift_card_amount', 255)->nullable();
            $table->string('user_token', 255)->nullable();
            $table->string('payment_mode', 255)->nullable();
            $table->string('payment_intent', 255)->nullable();
            $table->timestamps(); // includes created_at and updated_at
            $table->string('last_for_digit', 255)->nullable();
            $table->string('card_type', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaction_histories');
    }
};
