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
        Schema::table('inv_transaction', function (Blueprint $table) {
            $table->unsignedBigInteger('ref_dtls_id')->nullable()->after('id'); // for recv this column stored value of work order dtls & for issue this column stored value of requisition dtls
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inv_transaction', function (Blueprint $table) {
            $table->dropColumn('ref_dtls_id');
        });
    }
};
