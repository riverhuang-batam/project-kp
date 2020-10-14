<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->string('code', 100);
            $table->date('order_date')->nullable();
            $table->double('product_total', 8, 2)->nullable();
            $table->double('grand_total', 8, 2)->nullable();
            $table->double('grand_total_rp', 8, 2)->nullable();
            $table->tinyInteger('status');
            $table->foreignId('supplier_id')->references('id')->on('suppliers');
            $table->double('transfer_fee', 8, 2)->nullable();
            $table->double('currency_rate', 8, 2)->nullable();
            $table->string('transport_company', 100)->nullable();
            $table->double('transport_cost', 8, 2)->nullable();
            $table->string('tracking_number', 100)->nullable();
            $table->integer('total_piece_ctn')->nullable();
            $table->string('container_number', 100)->nullable();
            $table->date('load_date')->nullable();
            $table->date('estimated_unload_date')->nullable();
            $table->double('cubication', 8, 2)->nullable();
            $table->double('shipping_cost', 8, 2)->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchases');
    }
}
