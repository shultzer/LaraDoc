<?php

    use Illuminate\Database\Seeder;

    class DatabaseSeeder extends Seeder {

        /**
         * Run the database seeds.
         *
         * @return void
         */

        public function run () {
            $this->call(PropertyTableSeeder::class);
            $this->call(RolesTableSeeder::class);
            $this->call(AllTableSeeder::class);

        }
    }
