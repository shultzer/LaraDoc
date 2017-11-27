<?php

  use Illuminate\Support\Facades\Schema;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Database\Migrations\Migration;

  class CreateComplettersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
      Schema::create('completters', function (Blueprint $table) {
        $table->increments('id');
        $table->text('number');
        $table->text('date');
        $table->text('doc');
        $table->text('company');
        $table->text('volume')->nullable();
        $table->text('reason');
        $table->integer('user_id')->foreign()->references('id')->on('users')->onDelete('cascade');
        $table->integer('spaletters_id')->default(0)->foreign()->references('id')->on('spaletters')->onDelete('cascade');
        $table->integer('order_id')->default(0)->foreign();
        $table->integer('report_id')->default(0)->foreign();
        $table->timestamps();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
      Schema::dropIfExists('completters');
    }
  }
