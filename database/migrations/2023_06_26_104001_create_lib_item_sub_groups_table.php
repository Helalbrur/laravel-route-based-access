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
        Schema::create('lib_item_sub_group', function (Blueprint $table) {
            $table->id();
            $table->string('sub_group_name');
            $table->unsignedBigInteger('item_category_id');
            $table->unsignedBigInteger('item_group_id');
            $table->string('sub_group_code')->nullable();
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
        Schema::dropIfExists('lib_item_sub_groups');
    }
};
