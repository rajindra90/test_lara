<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
class BranchTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        for ($i = 0; $i < 1000; $i++) {
            $branchData=[
                'name'=>$faker->company,
                'address1'=>$faker->address,
                'address2'=>$faker->address,
                'city'=>$faker->city,
                'phone'=>$faker->phoneNumber,
                'fax'=>$faker->phoneNumber,
                'status'=>1,
            ];
            DB::table('sys_branch')->insert($branchData);
            echo 'Branch Created'.PHP_EOL;
        }
    }
}
