<?php

use Illuminate\Database\Seeder;

class PostTableSeeder extends Seeder
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

        $limit = 10;
        

        for($i = 0 ; $i<10 ; $i++){
        	for($j= 0 ; $j<10 ; $j++){
        	DB::table('posts')->insert([
        		'title'=>$faker->realText($maxNbChars = 100),
        		'content'=>$faker->realText($maxNbChars = 20000),	
        		'thumb'=>null,
        		'cate_id' => $i,
        		'user_id'=>$faker->randomNumber(2),
        		'created_at'=>$faker->dateTimeThisYear($max = 'now', $timezone = date_default_timezone_get())  
        	]);
        }
        }
    }
}
