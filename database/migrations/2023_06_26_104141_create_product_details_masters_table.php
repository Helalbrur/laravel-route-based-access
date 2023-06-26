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
        Schema::create('product_details_master', function (Blueprint $table) {
            $table->id();
            $table->string('item_description');
            $table->string('product_name_details');
            $table->string('uom');
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('item_category_id');
            $table->unsignedBigInteger('item_group_id');
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->unsignedBigInteger('store_id')->nullable();
            $table->unsignedBigInteger('detarmination_id')->nullable();
            $table->double('avg_rate_per_unit',15,6)->default(0);
            $table->double('current_stock',15,6)->default(0);
            $table->double('stock_value',15,6)->default(0);
            $table->string('item_code')->nullable();
            $table->string('item_account')->nullable();
            $table->string('packing_type')->nullable();
            $table->string('lot')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_details_masters');
    }
};
