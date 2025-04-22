<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequisitionDtlsTable extends Migration
{
    public function up()
    {
        Schema::create('requisition_dtls', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mst_id');
            $table->unsignedBigInteger('product_id');
            $table->string('item_code');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('uom');
            $table->double('requisition_qty', 15, 6)->default(0);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('requisition_dtls');
    }
}
