<?php
class TicketSeeder extends Seeder{
    public function run() {

        $faker = Faker\Factory::create('en_GB');

        DB::table('tickets')->delete();
        for($x=0;$x<100;$x++){
            Ticket::create(array(
                'user_id'=>$faker->numberBetween(2,3),
                'title'=>$faker->word(3),
                'description'=>$faker->paragraph(3),
                'url'=>$faker->url,
                'status_id'=>$faker->numberBetween(1,5),
                'priority_id'=>$faker->numberBetween(1,2),
                'created_at'=>$faker->dateTimeThisMonth()
            ));
        }
    }
}