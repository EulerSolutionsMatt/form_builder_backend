<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        App\User::truncate();

        $faker = \Faker\Factory::create();

        $generic_password = Hash::make('admin');

        // create a admin user manually
        App\User::create([
          'name' => 'admin',
          'email' => 'admin@gmail.com',
          'password' => $generic_password
        ]);

        for ($i = 0; $i < 10; $i++) {
            App\User::create([
              'name' => $faker->name,
              'email' => $faker->email,
              'password' => $generic_password
            ]);
        }
    }

}
