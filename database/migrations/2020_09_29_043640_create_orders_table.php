<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('orders', function (Blueprint $table) {
      $table->id();
      $table->date('date')->nullable();
      $table->string('marking', 100);
      $table->string('items', 255);
      $table->integer('qty')->nullable();
      $table->integer('ctns')->nullable();
      $table->decimal('volume', 10, 2)->nullable();
      $table->string('PL', 100)->nullable();
      $table->string('resi', 100);
      $table->date('expected_date')->nullable();
      $table->tinyInteger('status');
      $table->string('invoice')->nullable();
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
    Schema::dropIfExists('orders');
  }
}
