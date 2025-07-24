<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         DB::statement("
            ALTER TABLE `giftsends` 
            CHANGE `giftcards_number` `usertype` VARCHAR(255) 
            CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci 
            NULL DEFAULT NULL
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("
            ALTER TABLE `giftsends` 
            CHANGE `usertype` `giftcards_number` VARCHAR(255) 
            CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci 
            NULL DEFAULT NULL
        ");
    }
};