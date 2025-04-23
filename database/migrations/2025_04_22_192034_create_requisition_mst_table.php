<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class CreateRequisitionMstTable extends Migration
{
    public function up()
    {
        Schema::create('requisition_mst', function (Blueprint $table) {
            $table->id();
            $table->string('requisition_no_prefix', 50);
            $table->integer('requisition_no_prefix_num');
            $table->string('requisition_no', 50)->unique();
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('location_id');
            $table->unsignedTinyInteger('store_dept');
            $table->unsignedBigInteger('store_id')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->date('requisition_date')->default(Carbon::now()->format('Y-m-d'));
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('requisition_mst');
    }
}
