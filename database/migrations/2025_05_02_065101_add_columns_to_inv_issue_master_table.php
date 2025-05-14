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
        Schema::table('inv_issue_master', function (Blueprint $table) {
            $table->string('requisition_no')->nullable();
            $table->unsignedBigInteger('requisition_id')->nullable();
            $table->unsignedBigInteger('location_id')->nullable();
            $table->unsignedBigInteger('store_id')->nullable();
            $table->integer('issue_basis')->nullable();
            $table->text('remarks')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inv_issue_master', function (Blueprint $table) {
            $table->dropColumn('requisition_no');
            $table->dropColumn('requisition_id');
            $table->dropColumn('location_id');
            $table->dropColumn('store_id');
            $table->dropColumn('issue_basis');
            $table->dropColumn('remarks');
        });
    }
};
