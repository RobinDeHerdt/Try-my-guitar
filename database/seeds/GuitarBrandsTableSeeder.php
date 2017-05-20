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
            'name' => 'ESP',
            'logo_uri' => 'images/esp-logo.gif',
        ]);

        DB::table('guitar_brands')->insert([
            'name' => 'Ibanez',
            'logo_uri' => 'images/ibanez-logo.png',
        ]);

        DB::table('guitar_brands')->insert([
            'name' => 'Fender',
            'logo_uri' => 'images/fender-logo.jpeg',
        ]);

    }
}
