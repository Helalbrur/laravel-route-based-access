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
        Schema::table('inv_receive_master', function (Blueprint $table) {
             $table->string('receive_basis')->nullable()->after('store_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inv_receive_master', function (Blueprint $table) {
             $table->dropColumn('receive_basis');
        });
    }
};
