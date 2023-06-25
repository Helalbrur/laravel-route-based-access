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
        Schema::create('lib_item_category_list', function (Blueprint $table) {
            $table->id();
            // 'category_id','actual_category_name','short_name','category_type','inserted_by','insert_date','updated_by','update_date','status_active','is_deleted','is_inventory','ac_period_dtls_id','period_ending_date'
            $table->unsignedBigInteger('category_id');
            $table->string('actual_category_name');
            $table->string('short_name');
            $table->integer('category_type')->default(0);
            $table->unsignedBigInteger('inserted_by')->nullable();
            $table->timestamp('insert_date')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamp('update_date')->nullable();
            $table->boolean('status_active')->default(1);
            $table->boolean('is_deleted')->default(0);
            $table->integer('is_inventory')->default(0);
            $table->integer('ac_period_dtls_id')->default(0);
            $table->date('period_ending_date')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lib_item_category_list');
    }
};
