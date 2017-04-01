<?php

use Illuminate\Database\Seeder;

class pagesTableSeeder extends Seeder
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

        $limit = 100;
        for ($i = 0; $i < $limit; $i++) {
            DB::table('pages')->insert([ //,
                'title' => $faker->realtext($maxNbChars = 200),
                'content'=>$faker->realtext($maxNbChars =20000 ),
                'thumb' => null,
                'created_at'=>$faker->dateTimeThisYear($max = 'now', $timezone = date_default_timezone_get())  
            ]);
        }
    }
}
