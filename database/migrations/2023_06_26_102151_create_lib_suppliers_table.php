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
        Schema::create('lib_supplier', function (Blueprint $table) {
            $table->id();
            $table->string('supplier_name');
            $table->string('short_name');
            $table->string('party_type');
            $table->string('tag_company');
            $table->string('contact_person')->nullable();
            $table->string('contact_no')->nullable();
            $table->string('web_site')->nullable();
            $table->string('email')->nullable();
            $table->longText('address')->nullable();
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
        Schema::dropIfExists('lib_suppliers');
    }
};
