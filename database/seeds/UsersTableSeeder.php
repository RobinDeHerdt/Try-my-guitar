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
            'last_name' => 'TMG',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin'),
            'location_lat' => 35,
            'location_lng' => 40,
            'location' => 'Hest',
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
            'location_lat' => 39,
            'location_lng' => 41,
            'location' => 'Hest',
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
        ]);

        DB::table('role_user')->insert([
            'user_id' => 3,
            'role_id' => 3,
        ]);

        factory(App\User::class, 1500)->create()->each(function ($u) {
            // Assign 'user' role to every user.
            $u->roles()->attach(3);

            for ($i = 1; $i < 3; $i++) {
                // Assign remaining roles randomly to each user.
                if (rand(1, 3) > 2) {
                    $u->roles()->attach($i);

                    // Give every user with the editor role an article.
                    if ($i === 2) {
                        $u->articles()->save(factory(App\Article::class)->make());
                    }
                }
            }
        });
    }
}
