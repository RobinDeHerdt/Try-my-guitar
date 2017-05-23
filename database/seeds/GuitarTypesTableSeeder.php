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
            'name' => 'Electric guitars',
            'image_uri' => 'images/ec-1000.jpg',
        ]);

        DB::table('guitar_types')->insert([
            'name' => 'Acoustic guitars',
            'image_uri' => 'images/acoustic-guitar.jpg',
        ]);

        DB::table('guitar_types')->insert([
            'name' => 'Classical guitars',
            'image_uri' => 'images/classical-guitar.jpg',
        ]);

        DB::table('guitar_types')->insert([
            'name' => 'Single cut guitars',
            'image_uri' => 'images/ec-1000.jpg',
        ]);

        DB::table('guitar_types')->insert([
            'name' => 'Double cut guitars',
            'image_uri' => 'images/double-cut-guitar.jpg',
        ]);

        DB::table('guitar_types')->insert([
            'name' => 'Hollow body guitars',
            'image_uri' => 'images/hollow-body-guitar.jpg',
        ]);

        DB::table('guitar_types')->insert([
            'name' => 'Single coil guitars',
            'image_uri' => 'images/single-coil-guitar.png',
        ]);

        DB::table('guitar_types')->insert([
            'name' => 'Humbucker guitars',
            'image_uri' => 'images/humbucker-guitar.jpg',
        ]);

        DB::table('guitar_types')->insert([
            'name' => '6-string guitars',
            'image_uri' => 'images/6-string-guitar.jpg',
        ]);

        DB::table('guitar_types')->insert([
            'name' => '7-string guitars',
            'image_uri' => 'images/7-string-guitar.jpg',
        ]);

        DB::table('guitar_types')->insert([
            'name' => '8-string guitars',
            'image_uri' => 'images/8-string-guitar.jpg',
        ]);

        DB::table('guitar_types')->insert([
            'name' => 'Signature guitars',
            'image_uri' => 'images/signature-guitar.png',
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
