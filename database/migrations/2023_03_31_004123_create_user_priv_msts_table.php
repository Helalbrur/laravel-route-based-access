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
        Schema::create('user_priv_mst', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->default(0);
            $table->unsignedBigInteger('main_menu_id')->default(0);
            $table->unsignedBigInteger('show_priv')->default(2);
            $table->unsignedBigInteger('delete_priv')->default(2);
            $table->unsignedBigInteger('save_priv')->default(2);
            $table->unsignedBigInteger('edit_priv')->default(2);
            $table->unsignedBigInteger('approve_priv')->default(2);
            $table->integer('entry_date')->default(0);
            $table->string('user_only', 100)->charset('utf8')->collation('utf8_bin')->nullable();
            $table->string('last_updated_by', 50)->charset('utf8')->collation('utf8_bin')->nullable();
            $table->string('inserted_by', 50)->charset('utf8')->collation('utf8_bin')->nullable();
            $table->integer('valid')->default(0);
            $table->integer('last_update_date')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_priv_msts');
    }
};
