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
         * Because of reasons, there should be no '-' in the name of a guitar type.
         * @todo It would be great if this would be possible, someday...
         */
        DB::table('guitar_types')->insert([
            'name_en' => 'Electric',
            'name_nl' => 'Elektrisch',
            'image_uri' => 'images/electric-guitar.jpg',
        ]);

        DB::table('guitar_types')->insert([
            'name_en' => 'Acoustic',
            'name_nl' => 'Akoestisch',
            'image_uri' => 'images/acoustic-guitar.jpg',
        ]);

        DB::table('guitar_types')->insert([
            'name_en' => 'Classical',
            'name_nl' => 'Klassiek',
            'image_uri' => 'images/classical-guitar.jpg',
        ]);

        DB::table('guitar_types')->insert([
            'name_en' => 'Single cut',
            'name_nl' => 'Single cut',
            'image_uri' => 'images/single-cut-guitar.jpg',
        ]);

        DB::table('guitar_types')->insert([
            'name_en' => 'Double cut',
            'name_nl' => 'Double cut',
            'image_uri' => 'images/double-cut-guitar.jpg',
        ]);

        DB::table('guitar_types')->insert([
            'name_en' => 'Hollow body',
            'name_nl' => 'Hollow body',
            'image_uri' => 'images/hollow-body-guitar.jpg',
        ]);

        DB::table('guitar_types')->insert([
            'name_en' => 'Single coil',
            'name_nl' => 'Single coil',
            'image_uri' => 'images/single-coil-guitar.jpg',
        ]);

        DB::table('guitar_types')->insert([
            'name_en' => 'Humbucker',
            'name_nl' => 'Humbucker',
            'image_uri' => 'images/humbucker-guitar.jpg',
        ]);

        DB::table('guitar_types')->insert([
            'name_en' => '6 string',
            'name_nl' => '6 string',
            'image_uri' => 'images/6-string-guitar.jpg',
        ]);

        DB::table('guitar_types')->insert([
            'name_en' => '7 string',
            'name_nl' => '7 string',
            'image_uri' => 'images/7-string-guitar.jpg',
        ]);

        DB::table('guitar_types')->insert([
            'name_en' => '8 string',
            'name_nl' => '8 string',
            'image_uri' => 'images/8-string-guitar.jpg',
        ]);

        DB::table('guitar_types')->insert([
            'name_en' => 'Signature',
            'name_nl' => 'Signature',
            'image_uri' => 'images/signature-guitar.jpg',
        ]);


        /**
         * Pivot table seeders.
         */
        DB::table('guitar_type')->insert([
            'type_id' => 4,
            'guitar_id' => 1,
        ]);

        DB::table('guitar_type')->insert([
            'type_id' => 9,
            'guitar_id' => 1,
        ]);

        DB::table('guitar_type')->insert([
            'type_id' => 9,
            'guitar_id' => 2,
        ]);

        DB::table('guitar_type')->insert([
            'type_id' => 9,
            'guitar_id' => 3,
        ]);

        DB::table('guitar_type')->insert([
            'type_id' => 9,
            'guitar_id' => 4,
        ]);

        DB::table('guitar_type')->insert([
            'type_id' => 9,
            'guitar_id' => 5,
        ]);

        DB::table('guitar_type')->insert([
            'type_id' => 9,
            'guitar_id' => 6,
        ]);

        DB::table('guitar_type')->insert([
            'type_id' => 9,
            'guitar_id' => 7,
        ]);

        DB::table('guitar_type')->insert([
            'type_id' => 9,
            'guitar_id' => 8,
        ]);

        DB::table('guitar_type')->insert([
            'type_id' => 1,
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
            'type_id' => 1,
            'guitar_id' => 4,
        ]);

        DB::table('guitar_type')->insert([
            'type_id' => 1,
            'guitar_id' => 5,
        ]);

        DB::table('guitar_type')->insert([
            'type_id' => 1,
            'guitar_id' => 6,
        ]);

        DB::table('guitar_type')->insert([
            'type_id' => 1,
            'guitar_id' => 7,
        ]);

        DB::table('guitar_type')->insert([
            'type_id' => 1,
            'guitar_id' => 8,
        ]);

        DB::table('guitar_type')->insert([
            'type_id' => 12,
            'guitar_id' => 7,
        ]);
    }
}
