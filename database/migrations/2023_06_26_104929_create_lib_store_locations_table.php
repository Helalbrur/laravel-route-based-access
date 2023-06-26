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
        Schema::create('lib_store_location', function (Blueprint $table) {
            $table->id();
            $table->string('store_name');
            $table->string('store_location')->nullable();
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('location_id');
            $table->string('item_category_id');
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
        Schema::dropIfExists('lib_store_locations');
    }
};
