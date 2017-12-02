<?php

    use App\Completter;
    use App\Http\Controllers\IndexController;
    use Illuminate\Database\Seeder;
    use Faker\Factory;

    class AllTableSeeder extends Seeder {

        /**
         * Run the database seeds.
         *
         * @return void
         */

        public function run () {
            $faker = Factory::create();
            $this->createcomletters($faker);
            $this->createuser($faker);

        }

        private function createcomletters ($faker) {

            $posttable    = $this->getTable('completters');
            $propertylist = \App\Property::pluck('id');

            for ( $i = 0; $i < 100; $i++ ) {

                $table = Completter::create([
                  'number'  => $faker->unique->numberBetween(0, 1000),
                  'date'    => $faker->date(),
                  'doc'     => $faker->ImageUrl(),
                  'company' => IndexController::$companylist[ array_rand(IndexController::$companylist) ],
                  'reason'  => '294',
                  'owner' => 'ОАО "ФФФ"',
                  'user_id' => factory(App\User::class)->create()->id,
                ]);

                $table->propertys()->attach(
                  $propertylist->random()
                );
            }
        }

        private function createuser () {
            $usertable = $this->getTable('users');
            \App\User::create([
              'name'     => 'shultz',
              'password' => '$2y$10$HSHyDBCksHgATNrvX1KIL.F3b3QASdu9HMzTZN0IxoKkYTwlm3cQi',
              'email'    => 'skorohods@mail.ru',
            ]);
        }

        private function getTable ($name) {

            $table = DB::table($name);
            $table->truncate();

            return $table;
        }
    }
