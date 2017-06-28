<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'first_name' => 'Administrator',
            'email' => 'admin@trymyguitar.be',
            'password' => bcrypt('admin'),
            'exp' => 100000,
        ]);

        DB::table('role_user')->insert([
            'user_id' => 1,
            'role_id' => 1,
        ]);

        DB::table('role_user')->insert([
            'user_id' => 1,
            'role_id' => 2,
        ]);

        DB::table('role_user')->insert([
            'user_id' => 1,
            'role_id' => 3,
        ]);

        DB::table('users')->insert([
            'first_name' => 'Matt',
            'last_name' => 'Heafy',
            'email' => 'matt@gmail.com',
            'image_uri' => 'images/matt-heafy.jpg',
            'password' => bcrypt('123456'),
            'verified' => true,
            'header_image_uri' => 'images/electric-guitars.jpg',
            'description' => 'Guitar player and vocalist for a metal band called \'Trivium\'',
            'exp' => 11650,
        ]);

        DB::table('role_user')->insert([
            'user_id' => 2,
            'role_id' => 3,
        ]);

        DB::table('users')->insert([
            'first_name' => 'James',
            'last_name' => 'Hetfield',
            'email' => 'james@gmail.com',
            'image_uri' => 'images/james.jpg',
            'password' => bcrypt('123456'),
            'exp' => 24650,
        ]);

        DB::table('role_user')->insert([
            'user_id' => 3,
            'role_id' => 3,
        ]);

        DB::table('users')->insert([
            'first_name' => 'Jangus',
            'last_name' => 'Roundstone',
            'email' => 'editor@trymyguitar.be',
            'password' => bcrypt('editor'),
            'exp' => 150,
        ]);

        DB::table('role_user')->insert([
            'user_id' => 4,
            'role_id' => 2,
        ]);

        factory(App\User::class, 1500)->create()->each(function ($u) {
            // Assign 'user' role to every user.
            $u->roles()->attach(3);

            for ($i = 1; $i < 3; $i++) {
                // Assign remaining roles randomly to each user.
                if (rand(1, 10) < 2) {
                    $u->roles()->attach($i);
                }
            }
        });
    }
}
