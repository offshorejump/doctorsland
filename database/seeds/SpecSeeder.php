<?php

use Illuminate\Database\Seeder;
use App\Specialization;

class SpecSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$special1 = new Specialization();
			$special1->title		= 'Addiction psychiatrist';
			$special1->created_by	= 1;
		$special1->save();
		
		$special2 = new Specialization();
			$special2->title		= 'Adolescent medicine specialist';
			$special2->created_by	= 1;
		$special2->save();
		
		$special3 = new Specialization();
			$special3->title		= 'Allergist (immunologist)';
			$special3->created_by	= 1;
		$special3->save();
    }
}
