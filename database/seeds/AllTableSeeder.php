<?php

    use App\Completter;
    use App\Http\Controllers\IndexController;
    use App\User;
    use Illuminate\Database\Seeder;
    use Faker\Factory;

    class AllTableSeeder extends Seeder {

        /**
         * Run the database seeds.
         *
         * @return void
         */

        public function run () {
            //$faker = Factory::create();
            //$this->createcomletters($faker);
            $this->createuser();
            $this->attachrole();
            $this->createroles();
            $this->createcompanies();

        }

        private function createcomletters ($faker) {

            $posttable    = $this->getTable('completters');
            $propertylist = \App\Property::pluck('id');

            for ( $i = 0; $i < 30; $i++ ) {

                $table = Completter::create([
                  'number'  => $faker->unique->numberBetween(0, 100),
                  'date'    => $faker->date(),
                  'doc'     => $faker->ImageUrl(),
                  'company' => IndexController::getcompanies(array_rand(IndexController::getcompanies())),
                  'reason'  => '294',
                  'owner'   => 'ОАО "ФФФ"',
                  'user_id' => factory(App\User::class)->create()->id,
                ]);

                $table->propertys()->attach(
                  $propertylist->random()
                );
            }
        }


        public function attachrole () {
            $this->getTable('role_user');
            User::all()->first()->roles()->attach('5');
        }

        private function createuser () {
            $usertable = $this->getTable('users');
            \App\User::create([
              'name'         => 'shultz',
              'password'     => '$2y$10$HSHyDBCksHgATNrvX1KIL.F3b3QASdu9HMzTZN0IxoKkYTwlm3cQi',
              'email'        => 'skorohods@mail.ru',
              'organization' => 'admin',
            ]);
        }
        private function createcompanies () {
            $this->getTable('companies');
            \App\Companies::create([
              'name'         => 'Админ',
              'slug' =>'admin'
            ]);
        }

        private function getTable ($name) {

            $table = DB::table($name);
            $table->truncate();

            return $table;
        }

        private function createroles () {
            $roles = [ 'guest', 'rup', 'spa', 'min', 'admin' ];
            $this->getTable('roles');
            foreach ( $roles as $role ) {
                \App\Role::create([
                  'role' => $role,
                ]);
            }
        }
    }
