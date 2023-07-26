<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inv_receive_master', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('compoany_id');
            $table->string('sys_number_prefix');
            $table->string('sys_number_prefix_num');
            $table->string('sys_number');
            $table->date('date')->default(DB::raw('CURRENT_DATE'));
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inv_receive_masters');
    }
};
