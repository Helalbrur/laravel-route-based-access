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
        Schema::create('mandatory_field', function (Blueprint $table) {
            $table->id();
            $table->string('field_name');
            $table->string('field_message')->nullable();
            $table->unsignedBigInteger('page_id');
            $table->unsignedBigInteger('field_id');
            $table->unsignedBigInteger('is_mandatory');
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
        Schema::dropIfExists('mandatories');
    }
};
