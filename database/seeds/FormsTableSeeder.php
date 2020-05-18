<?php

use Illuminate\Database\Seeder;

class FormsTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        // truncate existing records to start from scratch
        \App\Form::truncate();

        $faker = \Faker\Factory::create();

        // create a few forms in out database
        for ($i = 0; $i < 50; $i++) {
            \App\Form::create([
              'form_name' => $faker->sentence
            ]);
        }
    }

}
