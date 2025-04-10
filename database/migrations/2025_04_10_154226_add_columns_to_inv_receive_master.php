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
            $table->unsignedBigInteger('location_id')->after('sys_number')->nullable();
            $table->unsignedBigInteger('store_id')->after('sys_number')->nullable();
            $table->string('work_order_no')->after('sys_number');
            $table->unsignedBigInteger('work_order_id')->after('sys_number');
            $table->unsignedBigInteger('created_by')->after('receive_date');
            $table->unsignedBigInteger('updated_by')->after('receive_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inv_receive_master', function (Blueprint $table) {
            $table->dropColumn(['location_id', 'store_id', 'work_order_no', 'work_order_id', 'created_by', 'updated_by']);
        });
    }
};
