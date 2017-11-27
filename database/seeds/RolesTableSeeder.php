<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    private static $roles = [
        'guest',
        'rup',
        'spa',
        'min',
        'admin'

    ];
    public function run()
    {
        $roles = DB::table('roles');
        $roles->truncate();
       foreach (static::$roles as $role ){
           DB::table('roles')->insert([
             'role' => $role,
           ]);
       }
    }
}
