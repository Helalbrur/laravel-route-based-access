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
        Schema::create('field_managers', function (Blueprint $table) {
            $table->id();
            $table->string('field_name');
            $table->string('field_message')->nullable();
            $table->unsignedBigInteger('field_id');
            $table->enum('is_hide', ['Yes', 'No'])->default('No'); // Enum with Yes/No options
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('entry_form');
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
        Schema::dropIfExists('field_managers');
    }
};
