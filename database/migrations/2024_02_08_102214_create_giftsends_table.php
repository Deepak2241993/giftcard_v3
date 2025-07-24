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
        Schema::create('giftsends', function (Blueprint $table) {
            $table->bigIncrements('id'); // Primary Key
            $table->tinyInteger('future_mail_status')->default(0);
            $table->integer('qty')->nullable();
            $table->decimal('amount', 8, 2)->default(0.00);
            $table->string('your_name', 191)->nullable();
            $table->string('recipient_name', 191)->nullable();
            $table->string('message', 191)->nullable();
            $table->string('gift_card_send_type', 191)->nullable();
            $table->string('in_future', 191)->nullable();
            $table->tinyInteger('status')->default(0);
            $table->string('coupon_code', 191)->nullable();
            $table->string('gift_send_to', 191)->nullable();
            $table->string('user_token', 191)->nullable();
            $table->timestamps(); // created_at and updated_at
            $table->string('receipt_email', 255)->nullable();
            $table->float('discount', 8, 2)->nullable();
            $table->string('transaction_id', 255)->nullable();
            $table->string('payment_status', 255)->nullable();
            $table->string('payment_time', 255)->nullable();
            $table->float('transaction_amount', 8, 2)->nullable();
            $table->string('giftcards_number', 255)->nullable();
            $table->string('payment_mode', 191)->nullable();
            $table->unsignedBigInteger('event_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('giftsends');
    }
};
