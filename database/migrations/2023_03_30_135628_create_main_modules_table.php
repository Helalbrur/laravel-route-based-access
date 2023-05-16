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
        Schema::create('main_module', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('m_mod_id');
            $table->string('main_module', 50)->charset('utf8')->collation('utf8_bin')->unique();
            $table->string('file_name', 333)->charset('utf8')->collation('utf8_bin')->nullable();
            $table->integer('status')->default(0);
            $table->integer('mod_slno')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('main_module');
    }
};
