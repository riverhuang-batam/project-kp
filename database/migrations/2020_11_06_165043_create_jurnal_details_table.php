<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJurnalDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jurnal_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('akun_id');
            $table->unsignedBigInteger('jurnal_id');
            $table->date('transaction_date');
            $table->double('debit', 10, 2)->nullable();
            $table->double('credit', 10, 2)->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('akun_id')->references('id')->on('akuns');
            $table->foreign('jurnal_id')->references('id')->on('jurnals');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jurnal_details');
    }
}
