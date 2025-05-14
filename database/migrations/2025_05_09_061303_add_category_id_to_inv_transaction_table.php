<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCategoryIdToInvTransactionTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('inv_transaction', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id')->after('mst_id');  // Add the category_id column after mst_id
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inv_transaction', function (Blueprint $table) {
            $table->dropColumn('category_id');
        });
    }
}
