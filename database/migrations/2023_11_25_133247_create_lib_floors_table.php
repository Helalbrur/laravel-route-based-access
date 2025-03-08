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
        Schema::create('lib_floor', function (Blueprint $table) {
            $table->id();
            $table->string('floor_name');
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('location_id');
            $table->string('store_id')->nullable();
            $table->integer('seq')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lib_floor');
    }
};
