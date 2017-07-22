<?php

use Illuminate\Database\Seeder;

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
            'location_lat' => 40.712784,
            'location_lng' => -74.005941,
            'location' => 'New York, USA',
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

        DB::table('users')->insert([
            'first_name' => 'Emma',
            'last_name' => 'Janssens',
            'location_lat' => 51.219448,
            'location_lng' => 4.402464,
            'location' => 'Antwerp, Belgium',
            'email' => 'emma.janssens@example.com',
            'password' => bcrypt('123456'),
            'exp' => 250,
        ]);

        DB::table('users')->insert([
            'first_name' => 'Bart',
            'last_name' => 'Hoefkens',
            'location_lat' => 50.879844,
            'location_lng' => 4.700518,
            'location' => 'Leuven, Belgium',
            'email' => 'bart.hoefkens@example.com',
            'password' => bcrypt('123456'),
            'verified' => true,
            'exp' => 250,
        ]);

        DB::table('users')->insert([
            'first_name' => 'Elien',
            'last_name' => 'Bergmans',
            'location_lat' => 51.096279,
            'location_lng' => 2.590563,
            'location' => 'De Panne, Belgium',
            'email' => 'elien.bergmans@example.com',
            'password' => bcrypt('123456'),
            'verified' => true,
            'exp' => 250,
        ]);

        DB::table('users')->insert([
            'first_name' => 'Michael',
            'last_name' => 'Scott',
            'location_lat' => 50.850346,
            'location_lng' => 4.351721,
            'location' => 'Brussel, Belgium',
            'email' => 'michael.scott@example.com',
            'password' => bcrypt('123456'),
            'verified' => true,
            'exp' => 250,
        ]);

        DB::table('users')->insert([
            'first_name' => 'Pam',
            'last_name' => 'Beesly',
            'location_lat' => 51.054342,
            'location_lng' => 3.717424,
            'location' => 'Gent, Belgium',
            'email' => 'pam.beesly@example.com',
            'password' => bcrypt('123456'),
            'verified' => true,
            'exp' => 250,
        ]);

        DB::table('users')->insert([
            'first_name' => 'Michael',
            'last_name' => 'Bluth',
            'location_lat' => 50.846955,
            'location_lng' => 3.601368,
            'location' => 'Gent, Belgium',
            'email' => 'michael.bluth@example.com',
            'password' => bcrypt('123456'),
            'verified' => true,
            'exp' => 250,
        ]);

        DB::table('users')->insert([
            'first_name' => 'Conan',
            'last_name' => 'O\'brien',
            'location_lat' => 51.054760,
            'location_lng' => 4.628670,
            'location' => 'Putte, Belgium',
            'email' => 'conan.obrien@example.com',
            'password' => bcrypt('123456'),
            'verified' => true,
            'exp' => 250,
        ]);

        DB::table('users')->insert([
            'first_name' => 'Kim',
            'location_lat' => 50.985996,
            'location_lng' => 4.836522,
            'location' => 'Aarschot, Belgium',
            'email' => 'kim@example.com',
            'password' => bcrypt('123456'),
            'verified' => true,
            'exp' => 250,
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
