<?php

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
        Schema::create('inv_stores', function (Blueprint $table) {
            $table->id();
            $table->string('barcode_no')->nullable();
            $table->unsignedBigInteger('mst_id');
            $table->unsignedBigInteger('trans_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('store_id')->nullable();
            $table->unsignedBigInteger('room_rack_id')->nullable();
            $table->double('quantity',15,6)->default(0);
            $table->double('rate',15,6)->default(0);
            $table->double('amount',15,6)->default(0);
            $table->date('date')->default(DB::raw('CURRENT_DATE'));
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inv_stores');
    }
};
