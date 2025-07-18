<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class CreateTransferMstTable extends Migration
{
    public function up()
    {
        Schema::create('transfer_mst', function (Blueprint $table) {
            $table->id();
            $table->string('transfer_no_prefix', 50);
            $table->integer('transfer_no_prefix_num');
            $table->string('transfer_no', 50)->unique();
            $table->unsignedBigInteger('company_id');
            $table->date('transfer_date')->default(Carbon::now()->format('Y-m-d'));
            $table->unsignedBigInteger('requisition_id')->nullable();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transfer_mst');
    }
}
