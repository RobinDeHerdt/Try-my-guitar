<?php

use Illuminate\Database\Seeder;

class ExperiencesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('experiences')->insert([
            'guitar_id' => 1,
            'user_id' => 1,
            'experience' => 'The neck scale is 24.75", 24 frets, pretty thick neck, but not unconftorable it feels solid and awesome. Like a Les Paul neck but nicer, also it has a sharper cutaway than a Gibson LP to get to those 2 extra frets easier.',
        ]);

        DB::table('experiences')->insert([
            'guitar_id' => 1,
            'user_id' => 2,
            'experience' => 'This guitar cranks out heavy sounds, but can still clean up nicely when necessary.',
        ]);

        DB::table('votes')->insert([
            'value' => 1,
            'experience_id' => 1,
            'user_id' => 3,
        ]);

        DB::table('votes')->insert([
            'value' => 0,
            'experience_id' => 1,
            'user_id' => 2,
        ]);

        DB::table('votes')->insert([
            'value' => 0,
            'experience_id' => 2,
            'user_id' => 3,
        ]);
    }
}
