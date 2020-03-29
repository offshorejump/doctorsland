<?php

use Illuminate\Database\Seeder;

use Faker\Factory as Faker;
use Carbon\Carbon;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $faker = Faker::create();
        //	Seeder Users
        foreach (range(1,15) as $index) {
            $first_name = $faker->firstname;
            $last_name  = $faker->lastname;
            $name = $first_name. " " . $last_name;

            DB::table('patients')->insert([
                'first_name' => $first_name,
                'last_name'  => $last_name,
                'name'       => $name,
				'dob'        => Carbon::now(),
                'email'      => $faker->email,
                'address'    => $faker->address,
                'phone'      => $faker->phoneNumber,
				'insurance_name'	=> $name,
				'insurance_type'	=> $faker->sentence(1),
				'insurance_number'	=> rand(12020, 99999),
                'created_by' => rand(3,4),
                'created_at' => Carbon::now(),
            ]);
        }
    }
}
