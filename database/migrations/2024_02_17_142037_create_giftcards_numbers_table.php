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
        Schema::create('giftcards_numbers', function (Blueprint $table) {
            $table->bigIncrements('id'); // Primary Key
            $table->string('user_id', 191)->nullable();
            $table->string('transaction_id', 191)->nullable()->index(); // Indexed field
            $table->string('user_token', 191)->nullable();
            $table->string('giftnumber', 191)->nullable();
            $table->double('amount', 8, 2)->default(0.00);
            $table->tinyInteger('status')->default(1);
            $table->string('comments', 255)->nullable();
            $table->double('actual_paid_amount', 8, 2)->nullable();
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
        Schema::dropIfExists('giftcards_numbers');
    }
};
