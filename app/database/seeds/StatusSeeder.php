<?php
class StatusSeeder extends Seeder{
    public function run() {

        DB::table('statuses')->delete();
        Status::create(array(
            'title'=>'Новый',
            'order'=>1,
        ));
        Status::create(array(
            'title'=>'В работе',
            'order'=>2,
        ));
        Status::create(array(
            'title'=>'Отложено',
            'order'=>3,
        ));
        Status::create(array(
            'title'=>'Отменено',
            'order'=>4,
        ));
        Status::create(array(
            'title'=>'Завершено',
            'order'=>5,
        ));
    }
}