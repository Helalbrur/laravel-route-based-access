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
        // 'mst_id','company_id','user_id','field_id','page_id','field_name','is_disable','defalt_value','created_by','updated_by'
   
        Schema::create('field_level_access', function (Blueprint $table) {
            $table->id();
            $table->string('field_name');
            $table->string('default_value')->nullable();
            $table->unsignedBigInteger('mst_id');
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('page_id');
            $table->unsignedBigInteger('field_id');
            $table->unsignedBigInteger('is_disable');
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
        Schema::dropIfExists('field_level_accesses');
    }
};
