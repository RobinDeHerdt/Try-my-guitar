<?php

use Illuminate\Database\Seeder;

class ReportsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('reports')->insert([
            'reason' => 'Bad language',
            'reported_id' => 3,
            'reporter_id' => 1,
        ]);

        DB::table('reports')->insert([
            'reason' => 'Very bad language',
            'reported_id' => 5,
            'reporter_id' => 3,
        ]);
    }
}
