<?php

use Illuminate\Database\Seeder;

class GuitarImagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('guitar_images')->insert([
            'image_uri' => 'images/ec-1000.jpg',
            'guitar_id' => 1,
            'user_id'   => 42,
        ]);

        DB::table('guitar_images')->insert([
            'image_uri' => 'images/iron-cross.jpg',
            'guitar_id' => 2,
            'user_id'   => 3,
        ]);

        DB::table('guitar_images')->insert([
            'image_uri' => 'images/iron-cross-neck.jpg',
            'guitar_id' => 2,
            'user_id'   => 3,
        ]);

        DB::table('guitar_images')->insert([
            'image_uri' => 'images/fender-squier.jpg',
            'guitar_id' => 3,
            'user_id'   => 19,
        ]);
    }
}
