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

        factory(User::class, 50)->create();
    }
}
