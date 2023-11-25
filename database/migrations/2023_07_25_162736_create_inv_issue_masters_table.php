<?php

use Carbon\Carbon;
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
        Schema::create('inv_issue_master', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('compoany_id');
            $table->string('sys_number_prefix');
            $table->string('sys_number_prefix_num');
            $table->string('sys_number');
            $table->unsignedBigInteger('buyer_id')->nullable();
            $table->date('date')->default(Carbon::now());
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inv_issue_master');
    }
};
