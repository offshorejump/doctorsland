<?php

use Illuminate\Database\Seeder;

use Faker\Factory as Faker;
use Carbon\Carbon;

class ReferToSeeder extends Seeder
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
        foreach (range(1,5) as $index) {
            $first_name = $faker->firstname;
            $last_name  = $faker->lastname;
            $name = $first_name. " " . $last_name;

            DB::table('refers')->insert([
                'patient_id' 	=> rand(1,5),
                'refer_by'  	=> 3,
                'refer_to'     	=> rand(3,5),
                'findings'    	=> $faker->sentence(5),
                'reason'      	=> $faker->sentence(6),
				'refer_date'  	=> Carbon::now(),
                'created_by' 	=> rand(1,4),
                'created_at' 	=> Carbon::now(),
            ]);
        }
		
		
		
		$faker = Faker::create();
        //	Seeder Users
        foreach (range(1,5) as $index) {
            $first_name = $faker->firstname;
            $last_name  = $faker->lastname;
            $name = $first_name. " " . $last_name;

            DB::table('refers')->insert([
                'patient_id' 	=> rand(1,5),
                'refer_by'  	=> rand(3,5),
                'refer_to'     	=> 3,
                'findings'    	=> $faker->sentence(5),
                'reason'      	=> $faker->sentence(6),
				'refer_date'  	=> Carbon::now(),
                'created_by' 	=> rand(1,4),
                'created_at' 	=> Carbon::now(),
            ]);
        }
		
		
		
		
    }
}
