<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //make column array for model fillable property
      
        Schema::create('work_order_dtls', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mst_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('uom');
            $table->unsignedBigInteger('category_id');
            $table->double('quantity',15,6)->default(0);
            $table->double('required_quantity', 15, 6)->default(0)->nullable();
            $table->double('rate',15,6)->default(0);
            $table->double('amount',15,6)->default(0);
            $table->double('discount',15,6)->default(0);
            $table->double('tax',15,6)->default(0);
            $table->double('vat',15,6)->default(0);
            $table->double('net_amount',15,6)->default(0);
            $table->double('net_rate',15,6)->default(0);
            $table->date('date')->default(Carbon::now()->format('Y-m-d'));
            $table->string('remarks', 191)->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_order_dtls');
    }
};
