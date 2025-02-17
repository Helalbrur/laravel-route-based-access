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
            $table->integer('generic_id')->nullable();
            $table->integer('item_sub_category_id')->nullable();
            $table->string('item_type')->nullable(); 
            $table->string('item_origin')->nullable(); 
            $table->integer('brand_id')->nullable(); 
            $table->string('dosage_form')->nullable();
            $table->string('color_id')->nullable(); 
            $table->integer('order_uom')->nullable(); 
            $table->integer('order_uom_qty')->nullable();
            $table->integer('consuption_uom')->nullable();
            $table->integer('consuption_uom_qty')->nullable();
            $table->string('conversion_fac')->nullable();  
            $table->integer('size_id')->default(true);
            $table->string('power')->nullable();  
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_details_master', function (Blueprint $table) {
            $table->dropColumn(['generic_id', 'item_sub_category_id', 'item_type','item_origin', 'brand_id', 'dosage_form','color_id', 'order_uom', 'order_uom_qty','consuption_uom', 'consuption_uom_qty', 'conversion_fac','size_id', 'power']);
        });
    }
};
