<?php

use Illuminate\Database\Seeder;

class GuitarBrandsTableSeeder extends Seeder
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

        DB::table('guitar_brands')->insert([
            'name' => 'Epiphone',
            'logo_uri' => 'images/epiphone-logo.png',
        ]);

        DB::table('guitar_brands')->insert([
            'name' => 'ESP',
            'logo_uri' => 'images/esp-logo.png',
        ]);

        DB::table('guitar_brands')->insert([
            'name' => 'Ibanez',
            'logo_uri' => 'images/ibanez-logo.png',
        ]);

        DB::table('guitar_brands')->insert([
            'name' => 'Fender',
            'logo_uri' => 'images/fender-logo.jpg',
        ]);

        DB::table('guitar_brands')->insert([
            'name' => 'Gibson',
            'logo_uri' => 'images/gibson-logo.jpg',
        ]);

        DB::table('guitar_brands')->insert([
            'name' => 'Jackson',
            'logo_uri' => 'images/jackson-logo.png',
        ]);

        DB::table('guitar_brands')->insert([
            'name' => 'Squier',
            'logo_uri' => 'images/squier-logo.png',
        ]);

        DB::table('guitar_brands')->insert([
            'name' => 'Yamaha',
            'logo_uri' => 'images/yamaha-logo.jpg',
        ]);

        DB::table('guitar_brands')->insert([
            'name' => 'Gretsch',
            'logo_uri' => 'images/gretsch-logo.jpg',
        ]);
    }
}
