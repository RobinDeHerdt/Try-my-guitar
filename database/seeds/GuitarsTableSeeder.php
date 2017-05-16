<?php

use Illuminate\Database\Seeder;

class GuitarsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Add channels.
        DB::table('channels')->insert([
            'name' => '',
        ]);
    }
}
