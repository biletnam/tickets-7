<?php
class PrioritiesSeeder extends Seeder{
    public function run(){
        DB::table('priorities')->delete();
        Priority::create(array(
                'title'=>'Обычная задача',
                'description'=>'Время реализациии до 3 дней',
                'order'=>1
            ));
        Priority::create(array(
                'title'=>'Приоритетная задача',
                'description'=>'Время реализации до 1 дня',
                'order'=>2
            ));
        Priority::create(array(
                'title'=>'Срочная задача / 2000 руб/час',
                'description'=>'Время реализации в течение 1 часа',
                'order'=>3
            ));
    }
}