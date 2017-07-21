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
            'image_uri' => 'images/ec-1000-side.png',
            'guitar_id' => 1,
            'user_id'   => 503,
        ]);

        DB::table('guitar_images')->insert([
            'image_uri' => 'images/ec-1000-3.jpg',
            'guitar_id' => 1,
            'user_id'   => 755,
        ]);

        DB::table('guitar_images')->insert([
            'image_uri' => 'images/ec-1000-2.jpg',
            'guitar_id' => 1,
            'user_id'   => 755,
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
            'user_id'   => 49,
        ]);

        DB::table('guitar_images')->insert([
            'image_uri' => 'images/stratocaster.jpg',
            'guitar_id' => 4,
            'user_id'   => 19,
        ]);

        DB::table('guitar_images')->insert([
            'image_uri' => 'images/ex-1000.png',
            'guitar_id' => 5,
            'user_id'   => 37,
        ]);

        DB::table('guitar_images')->insert([
            'image_uri' => 'images/ax-1000.png',
            'guitar_id' => 6,
            'user_id'   => 14,
        ]);

        DB::table('guitar_images')->insert([
            'image_uri' => 'images/alex-skolnick-signature.png',
            'guitar_id' => 7,
            'user_id'   => 21,
        ]);

        DB::table('guitar_images')->insert([
            'image_uri' => 'images/esp-arrow.png',
            'guitar_id' => 8,
            'user_id'   => 14,
        ]);

        DB::table('guitar_images')->insert([
            'image_uri' => 'images/esp-arrow-back.png',
            'guitar_id' => 8,
            'user_id'   => 14,
        ]);
    }
}
