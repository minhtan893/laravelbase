<?php

use Illuminate\Database\Seeder;

class CatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

         $faker = Faker\Factory::create();
        for ($i=0; $i < 10; $i++) { 
            DB::table('cates')->insert([
                'title'=>$faker->realText(10),
                'parent_id'=>0
            ]);
        }
    }
}
