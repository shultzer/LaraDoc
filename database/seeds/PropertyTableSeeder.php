<?php

    use Illuminate\Database\Seeder;

    class PropertyTableSeeder extends Seeder {

        /**
         * Run the database seeds.
         *
         * @return void
         */
        private static $prop = [
          'vl110'     => 'ВЛ110кВ',
          'vl35'      => 'ВЛ35кВ',
          'vl10'      => 'ВЛ10кВ',
          'vl6'       => 'ВЛ6кВ',
          'v04'       => 'ВЛ0,4кВ',
          'teploset'  => 'Тепловые сети',
          'building'  => 'Здание',
          'equipment' => 'Оборудование',
        ];

        public function run () {
            $propertys = DB::table('propertys');
            $propertys->truncate();
            foreach ( static::$prop as $key => $item ) {
                DB::table('propertys')->insert([
                  'name' => $item,
                  'slug' => $key,
                ]);
            }
        }

    }
