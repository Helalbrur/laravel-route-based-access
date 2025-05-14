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
            $table->boolean('is_system_generated_item_code')->default(false)->after('item_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_details_master', function (Blueprint $table) {
            $table->dropColumn('is_system_generated_item_code');
        });
    }
};
