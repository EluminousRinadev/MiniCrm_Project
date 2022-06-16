<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employee;
class EmployeeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        for ($i=0; $i < 100; $i++) { 
	    	Employee::create([
	            'first_name' => str_random(8),
                'last_name' => str_random(8),
                'company_id' => '1',
	            'email' => str_random(12).'@mail.com',
                'phone' => str_random(12)
	            
              
	        ]);
    	}
    }
}
