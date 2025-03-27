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
        Schema::table('work_order_msts', function (Blueprint $table) {
            $table->unsignedBigInteger('currency_id')->default(1)->nullable()->after('wo_date'); // Change 'some_column' to an existing column name
            $table->decimal('exchange_rate', 10, 4)->default(1)->nullable()->after('currency_id');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('work_order_msts', function (Blueprint $table) {
            $table->dropColumn(['currency_id', 'exchange_rate']);
        });
    }
};
