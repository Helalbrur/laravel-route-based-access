<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inv_transaction', function (Blueprint $table) {
            $table->id();
            $table->integer('transaction_type');
            $table->unsignedBigInteger('mst_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('store_id')->nullable();
            $table->unsignedBigInteger('room_rack_id')->nullable();
            $table->int('cons_uom')->nullable();
            $table->double('cons_qnty',15,6)->default(0);
            $table->double('cons_rate',15,6)->default(0);
            $table->double('cons_amount',15,6)->default(0);
            $table->double('quantity')->default(0);
            $table->date('date')->default(Carbon::now());
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inv_transaction');
    }
};
