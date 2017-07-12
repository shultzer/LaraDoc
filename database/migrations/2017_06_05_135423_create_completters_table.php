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
