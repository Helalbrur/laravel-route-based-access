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
        //item_name,trim_type,order_uom,trim_uom,item_category,item_group_code,conversion_factor
        Schema::create('lib_item_group', function (Blueprint $table) {
            $table->id();
            $table->string('item_name');
            $table->unsignedBigInteger('item_category_id');
            $table->float('conversion_factor')->default(1);
            $table->integer('cons_uom')->nullable();
            $table->string('item_group_code')->nullable();
            $table->integer('order_uom')->nullable();
            $table->integer('item_type')->nullable();
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
        Schema::dropIfExists('lib_item_groups');
    }
};
