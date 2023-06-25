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
        Schema::create('main_menu', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('m_menu_id');
            $table->unsignedBigInteger('m_module_id')->default(0);
            $table->unsignedBigInteger('root_menu')->default(0);
            $table->unsignedBigInteger('sub_root_menu')->default(0);
            $table->string('menu_name', 100)->charset('utf8')->collation('utf8_bin');
            $table->string('f_location', 200)->charset('utf8')->collation('utf8_bin')->nullable();
            $table->string('route_name', 200)->charset('utf8')->collation('utf8_bin')->nullable();
            $table->integer('fabric_nature')->default(0);
            $table->integer('position')->default(0);
            $table->integer('status')->default(0);
            $table->integer('slno')->default(0);
            $table->integer('report_menu')->default(0);
            $table->integer('is_mobile_menu')->default(0);
            // $table->decimal('is_mobile_menu', 10, 2)->nullable();
            $table->string('m_page_name', 300)->charset('utf8')->collation('utf8_bin')->nullable();
            $table->string('m_page_short_name', 200)->charset('utf8')->collation('utf8_bin')->nullable();
            $table->unsignedBigInteger('inserted_by')->nullable();
            $table->timestamp('insert_date')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamp('update_date')->nullable();
            $table->boolean('status_active')->default(1);
            $table->boolean('is_deleted')->default(0);
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('main_menu');
    }
};
