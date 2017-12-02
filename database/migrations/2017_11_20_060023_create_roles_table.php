<?php

    use Illuminate\Support\Facades\Schema;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Database\Migrations\Migration;

    class CreateRolesTable extends Migration {

        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up () {
            Schema::create('roles', function (Blueprint $table) {
                $table->increments('id');
                $table->text('role');
            });
            Schema::create('role_user', function (Blueprint $table) {
                $table->integer('user_id')->index();
                $table->integer('role_id')->index();
            });
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down () {
            Schema::dropIfExists('roles');
            Schema::dropIfExists('user_role');
        }
    }
