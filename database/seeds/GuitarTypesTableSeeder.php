<?php

use Illuminate\Database\Seeder;

class GuitarTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Guitar types seeders.
         */
        DB::table('guitar_types')->insert([
            'name' => 'Electric guitar',
            'image_uri' => 'images/ec-1000.jpg',
        ]);

        DB::table('guitar_types')->insert([
            'name' => 'Acoustic guitar',
            'image_uri' => 'images/acoustic-guitar.jpg',
        ]);

        DB::table('guitar_types')->insert([
            'name' => 'Classical guitar',
            'image_uri' => 'images/classical-guitar.jpg',
        ]);

        DB::table('guitar_types')->insert([
            'name' => 'Single cut',
            'image_uri' => 'images/single-cut-guitar.jpg',
        ]);

        DB::table('guitar_types')->insert([
            'name' => 'Double cut',
            'image_uri' => 'images/double-cut-guitar.jpg',
        ]);

        DB::table('guitar_types')->insert([
            'name' => 'Hollow body',
            'image_uri' => 'images/hollow-body-guitar.jpg',
        ]);

        DB::table('guitar_types')->insert([
            'name' => 'Single coil',
            'image_uri' => 'images/single-coil-guitar.png',
        ]);

        DB::table('guitar_types')->insert([
            'name' => 'Humbucker',
            'image_uri' => 'images/humbucker-guitar.jpg',
        ]);

        DB::table('guitar_types')->insert([
            'name' => '6-string',
            'image_uri' => 'images/6-string-guitar.jpg',
        ]);

        DB::table('guitar_types')->insert([
            'name' => '7-string',
            'image_uri' => 'images/7-string-guitar.jpg',
        ]);

        DB::table('guitar_types')->insert([
            'name' => '8-string',
            'image_uri' => 'images/8-string-guitar.jpg',
        ]);

        DB::table('guitar_types')->insert([
            'name' => 'Signature',
            'image_uri' => 'signature-guitar.png',
        ]);


        /**
         * Pivot table seeders.
         */
        DB::table('guitar_type')->insert([
            'type_id' => 1,
            'guitar_id' => 1,
        ]);

        DB::table('guitar_type')->insert([
            'type_id' => 2,
            'guitar_id' => 1,
        ]);

        DB::table('guitar_type')->insert([
            'type_id' => 1,
            'guitar_id' => 2,
        ]);

        DB::table('guitar_type')->insert([
            'type_id' => 1,
            'guitar_id' => 3,
        ]);

        DB::table('guitar_type')->insert([
            'type_id' => 2,
            'guitar_id' => 3,
        ]);
    }
}
