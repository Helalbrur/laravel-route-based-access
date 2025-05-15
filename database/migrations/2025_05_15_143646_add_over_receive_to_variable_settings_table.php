<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /** 
     * Run the migrations.

     */
    public function up(): void
    {
        Schema::table('variable_settings', function (Blueprint $table) {
            $table->double('over_receive',15,6)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('variable_settings', function (Blueprint $table) {
            $table->dropColumn('over_receive');
        });
    }
};
