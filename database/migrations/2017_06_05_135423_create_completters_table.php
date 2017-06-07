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
        $table->text('property');
        $table->text('volume');
        $table->text('reason');
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
