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
        Schema::table('inv_transaction', function (Blueprint $table) {
            $table->unsignedBigInteger('required_qty')->after('room_rack_id');
            $table->unsignedBigInteger('work_order_qty')->after('room_rack_id');
            $table->string('lot')->after('date')->nullable();;
            $table->date('expire_date')->after('date')->nullable();
            $table->unsignedBigInteger('room_self_id')->after('room_rack_id')->nullable();
            $table->unsignedBigInteger('room_bin_id')->after('room_rack_id')->nullable();
            $table->unsignedBigInteger('created_by')->after('date');
            $table->unsignedBigInteger('updated_by')->after('date');
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inv_transaction', function (Blueprint $table) {
            $table->dropColumn(['required_qty', 'work_order_qty', 'lot', 'expire_date', 'room_self_id', 'room_bin_id', 'created_by', 'updated_by']);
        });
    }
};
