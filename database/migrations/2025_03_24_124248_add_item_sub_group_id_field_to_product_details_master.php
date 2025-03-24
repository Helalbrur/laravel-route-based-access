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
        Schema::table('product_details_master', function (Blueprint $table) {
            $table->unsignedBigInteger('item_sub_group_id')->nullable()->after('item_group_id');
        });
    }

    /** 
     * Reverse the migrations.

     */
    public function down(): void
    {
        Schema::table('product_details_master', function (Blueprint $table) {
            $table->dropColumn('item_sub_group_id');
        });
    }
};
