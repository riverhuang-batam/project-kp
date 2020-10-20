<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditPriceColumnToDecimal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchases', function (Blueprint $table) {
            $table->unsignedDecimal('product_total', 14, 2)->nullable()->change();
            $table->unsignedDecimal('grand_total', 14, 2)->nullable()->change();
            $table->unsignedDecimal('grand_total_rp', 14, 2)->nullable()->change();
            $table->unsignedDecimal('transfer_fee', 14, 2)->nullable()->change();
            $table->unsignedDecimal('currency_rate', 8, 2)->nullable()->change();
            $table->unsignedDecimal('transport_cost', 14, 2)->nullable()->change();
            $table->unsignedDecimal('shipping_cost', 14, 2)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('purchases', function (Blueprint $table) {
            $table->double('product_total', 8, 2)->nullable()->change();
            $table->double('grand_total', 8, 2)->nullable()->change();
            $table->double('grand_total_rp', 8, 2)->nullable()->change();
            $table->double('transfer_fee', 8, 2)->nullable()->change();
            $table->double('currency_rate', 8, 2)->nullable()->change();
            $table->double('transport_cost', 8, 2)->nullable()->change();
            $table->double('shipping_cost', 8, 2)->nullable()->change();
        });
    }
}
