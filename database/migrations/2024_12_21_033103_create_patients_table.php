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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('fname', 255)->nullable();
            $table->string('lname', 255)->nullable();
            $table->string('city', 255)->nullable();
            $table->string('country', 255)->nullable();
            $table->string('zip_code', 5)->nullable();
            $table->string('phone', 20)->nullable();
            $table->text('address')->nullable();
            $table->string('email')->unique()->nullable(); // Add the email column
            $table->boolean('status')->default(1);
            $table->string('user_token', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patients');
    }
};
