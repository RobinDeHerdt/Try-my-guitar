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
            'logo_uri' => 'images/ltd-logo.png',
        ]);

        DB::table('guitars')->insert([
            'name' => 'EC-1000',
            'description' => 'Black and gold colors',
            'brand_id' => 1,
        ]);

        DB::table('guitar_types')->insert([
            'name' => 'Electric guitar',
        ]);

        DB::table('guitar_types')->insert([
            'name' => '6-string',
        ]);

        DB::table('guitar_type')->insert([
            'type_id' => 1,
            'guitar_id' => 1,
        ]);

        DB::table('guitar_type')->insert([
            'type_id' => 2,
            'guitar_id' => 1,
        ]);

        DB::table('guitar_images')->insert([
            'image_uri' => 'images/ec-1000.jpg',
            'guitar_id' => 1,
            'user_id'   => 42,
        ]);

        DB::table('guitar_images')->insert([
            'image_uri' => 'images/ec-1000-2.jpg',
            'guitar_id' => 1,
            'user_id'   => 21,
        ]);

        DB::table('guitar_images')->insert([
            'image_uri' => 'images/ec-1000-3.jpg',
            'guitar_id' => 1,
            'user_id'   => 2,
        ]);
    }
}
