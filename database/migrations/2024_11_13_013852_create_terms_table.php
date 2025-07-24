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
        Schema::create('terms', function (Blueprint $table) {
            $table->increments('id'); // Primary Key
            $table->string('service_id', 255)->nullable()->index(); // Indexed column
            $table->mediumText('description')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->tinyInteger('status')->default(1); // Default value is 1
            $table->integer('is_deleted')->default(0); // Default value is 0
            $table->string('unit_id', 55)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('terms');
    }
};
