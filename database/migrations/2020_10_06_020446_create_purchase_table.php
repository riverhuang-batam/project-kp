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
            $table->string('purchase_code', 100);
            $table->date('date')->nullable();
            $table->string('marking', 255);
            $table->string('item', 255);
            $table->integer('quantity')->nullable();
            $table->integer('ctns')->nullable();
            $table->decimal('volume', 10, 2)->nullable();
            $table->string('pl', 100)->nullable();
            $table->string('resi', 100)->nullable();
            $table->date('expected_date')->nullable();
            $table->tinyInteger('status');
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
