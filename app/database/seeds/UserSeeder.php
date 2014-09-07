<?php
class UserSeeder extends Seeder{
    public function run() {

        DB::table('users')->delete();
        User::create(array(
                'email'    => 'alexeev.sker@gmail.com',
                'full_name'     => 'Антон Алексеев',
                'password' => Hash::make('password'),
                'role'=>'admin',
                'phone'=>'79094342294'
            ));
        User::create(array(
            'email'    => 'alexeev@idangero.us',
            'full_name'     => 'Антон Алексеев 2',
            'password' => Hash::make('123123'),
            'role'=>'user',
            'phone'=>'79094342294'
        ));

        User::create(array(
            'email'    => 'van_helsyng@rambler.ru',
            'full_name'     => 'Антон Алексеев 3',
            'password' => Hash::make('123QWE'),
            'role'=>'user',
            'phone'=>'79094342294'
        ));
    }
}