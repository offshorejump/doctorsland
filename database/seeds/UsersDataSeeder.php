<?php

use Illuminate\Database\Seeder;

use App\Role;
use App\User;

use Faker\Factory as Faker;
use Carbon\Carbon;

class UsersDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        /**
         *	Role ID  = 1
         *	Administrator
         */
       $admin = new Role();
            $admin->name         = 'admin';
            $admin->display_name = 'Administrator';
            $admin->description  = 'User with Semi full privileges';
       $admin->save();
       

        /**
         *	Role ID  = 2
         *	Customer
         */
        $doctor = new Role();
            $doctor->name         = 'doctor';
            $doctor->display_name = 'Doctor';
            $doctor->description  = 'Doctors Login';
        $doctor->save();
        

        /*
        *	Seeder for Admins
        */
        $adminUser1 = new User();
            $adminUser1->first_name  = 'Admin';
            $adminUser1->last_name   = 'User';
            $adminUser1->name        = 'Admin User';
			$adminUser1->company_name = "Admin LLC";
            $adminUser1->address     = '96 Bowman Street, Glasgow, England';
            $adminUser1->email       = 'super@softsourcepk.com';
            $adminUser1->password    = bcrypt('123456');
			$adminUser1->phone    	 = '555 111 1111';
            $adminUser1->role_id     = '1';
            $adminUser1->save();
        $adminUser1->roles()->attach($admin->id);

      
        $adminUser2 = new User();
            $adminUser2->first_name  = 'John';
            $adminUser2->last_name   = 'Diggle Admin';
            $adminUser2->name        = 'John Diggle Admin';
			$adminUser2->company_name = 'John Corp.';
            $adminUser2->address     = 'Victoria Road, England';
            $adminUser2->email       = 'john@softsourcepk.com';
            $adminUser2->password    = bcrypt('123456');
            $adminUser2->role_id     = '1';
            $adminUser2->save();
        $adminUser2->roles()->attach($admin->id);


        /*
        *	Seeder for Doctor
        */
        $doctorUser1 = new User();
            $doctorUser1->first_name  = 'Mr.';
            $doctorUser1->last_name   = 'Doctor';
            $doctorUser1->name        = 'Mr. Doctor';
            $doctorUser1->email       = 'doctor@softsourcepk.com';
            $doctorUser1->password    = bcrypt('123456');
			$doctorUser1->qualifications    = "MBBS, FSP";
			$doctorUser1->type    = "1";
            $doctorUser1->role_id     = '2';
            $doctorUser1->save();
        $doctorUser1->roles()->attach($doctor->id);
		
		
		/*
        *	Seeder for Doctor
        */
        $doctorUser2 = new User();
            $doctorUser2->first_name  = 'New';
            $doctorUser2->last_name   = 'Doctor';
            $doctorUser2->name        = 'New Doctor';
			$doctorUser2->company_name = 'General Hospital';
            $doctorUser2->email       = 'doctornew@softsourcepk.com';
            $doctorUser2->password    = bcrypt('123456');
			$doctorUser2->qualifications = "M.B.B.S";
			$doctorUser2->type    = "2";
            $doctorUser2->role_id     = '2';
            $doctorUser2->save();
        $doctorUser2->roles()->attach($doctor->id);
		
		
		$faker = Faker::create();
        //	Seeder Dummy Doctors
        foreach (range(1,9) as $index) {
            $first_name = $faker->firstname;
            $last_name  = $faker->lastname;
            $name = $first_name. " " . $last_name;

            DB::table('users')->insert([
                'first_name' => $first_name,
                'last_name'  => $last_name,
                'name'       => $name,
				'company_name' => $faker->word(3)." LLC.", 
                'email'      => $faker->email,
				'password'   => bcrypt('123456'),
                'address'    => $faker->address,
				'phone'    	 => $faker->phoneNumber,
				'qualifications' => 'M.B.B.S',
				'type' => rand(1,3),
                'role_id'    => "2",
                'created_by' => rand(1,4),
                'created_at' => Carbon::now(),
            ]);
        }
		
		
		
    }
	
	
}
