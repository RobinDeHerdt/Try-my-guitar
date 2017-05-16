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
        DB::table('guitar_brands')->insert([
            'name' => 'LTD',
        ]);

        DB::table('guitars')->insert([
            'name' => 'EC-1000',
            'description' => 'Black and gold colors',
            'brand_id' => 1,
        ]);

        DB::table('guitar_types')->insert([
            'name' => 'Electric guitar',
        ]);

        DB::table('guitar_type')->insert([
            'type_id' => 1,
            'guitar_id' => 1,
        ]);

        DB::table('guitar_images')->insert([
            'image_uri' => 'images/matt-heafy.jpg',
            'guitar_id' => 1,
        ]);
    }
}
