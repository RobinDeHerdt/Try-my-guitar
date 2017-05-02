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
            'name' => 'admin',
            'email' => 'admin@trymyguitar.com',
            'password' => bcrypt('admin'),
        ]);

        factory(App\User::class, 50)->create()->each(function ($u) {
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
