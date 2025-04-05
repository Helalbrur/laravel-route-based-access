<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Carbon\Carbon;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('work_order_mst', function (Blueprint $table) {
            $table->id();
            $table->string('wo_no_prefix', 50);
            $table->integer('wo_no_prefix_num');
            $table->string('wo_no', 50);
            $table->date('wo_date')->default(Carbon::now()->format('Y-m-d'));
            $table->date('delivery_date')->default(Carbon::now()->addMonth()->format('Y-m-d'));
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('supplier_id');
            $table->integer('pay_mode');
            $table->string('source', 191)->nullable();
            $table->string('remarks', 191)->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Adding foreign key constraints
            //$table->foreign('company_id')->references('id')->on('lib_company')->onDelete('cascade');
            //$table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
            //$table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            //$table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_order_mst');
    }
};
