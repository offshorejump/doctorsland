<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersDataSeeder::class);
		$this->call(PatientSeeder::class);
		$this->call(ReferToSeeder::class);
		$this->call(SpecSeeder::class);
		$this->command->info('All Data Seeded Successfully!');		
    }
}
