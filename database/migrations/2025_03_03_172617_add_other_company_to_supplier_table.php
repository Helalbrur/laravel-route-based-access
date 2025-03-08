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
        Schema::table('lib_supplier', function (Blueprint $table) {
            $table->unsignedBigInteger('other_company_id')->nullable();
            $table->foreign('other_company_id')->references('id')->on('other_companies');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lib_supplier', function (Blueprint $table) {
            $table->dropForeign(['other_company_id']);
            $table->dropColumn('other_company_id');
        });
    }
};
