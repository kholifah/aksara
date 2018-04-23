<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('document_number', 30);
            $table->integer('supplier_id')->unsigned();
            $table->foreign('supplier_id')
                ->references('id')
                ->on('suppliers');
            $table->date('order_date');
            $table->date('estimated_delivery_date');
            $table->boolean('is_applied');
            $table->boolean('is_void');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase_orders');
    }
}
