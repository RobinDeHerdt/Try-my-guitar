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
            'experience' => 'Real good guitar',
        ]);

        DB::table('experiences')->insert([
            'guitar_id' => 1,
            'user_id' => 2,
            'experience' => 'Real good guitar!!',
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
