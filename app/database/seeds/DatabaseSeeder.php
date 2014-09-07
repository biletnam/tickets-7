<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

        $this->call('UserSeeder');
        $this->command->info('User table seeded!');

        $this->call('PrioritiesSeeder');
        $this->command->info('Priorities table seeded!');

        $this->call('StatusSeeder');
        $this->command->info('Status table seeded!');

        $this->call('TicketSeeder');
        $this->command->info('Ticket table seeded!');
	}

}
