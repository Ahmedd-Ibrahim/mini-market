<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = \App\User::create([
            'name' => 'Super Admin',
            'email' => 'admin@admin',
            'password' => bcrypt('1230012300')
        ]);
        $user->attachRole('super_admin');
    }//End of Run
}
