<?php
class UserSeeder extends Seeder{
    public function run() {

        DB::table('users')->delete();
        User::create(array(
                'email'    => 'alexeev@idangero.us',
                'full_name'     => 'Антон Алексеев',
                'password' => Hash::make('password'),
                'role'=>'admin',
                'phone'=>'79094342294'
            ));
    }
}