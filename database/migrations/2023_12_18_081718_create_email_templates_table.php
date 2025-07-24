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
        Schema::create('email_templates', function (Blueprint $table) {
            $table->id();

            $table->string('title')->nullable();
            $table->mediumInteger('message_email')->nullable();
            $table->longText('html_code')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->string('image')->nullable();
            $table->string('footer_message')->nullable();
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
        Schema::dropIfExists('email_templates');
    }
};
