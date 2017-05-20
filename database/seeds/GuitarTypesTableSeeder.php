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
        ]);

        DB::table('guitar_types')->insert([
            'name' => 'Acoustic guitar',
        ]);

        DB::table('guitar_types')->insert([
            'name' => 'Classical guitar',
        ]);

        DB::table('guitar_types')->insert([
            'name' => 'Single cut',
        ]);

        DB::table('guitar_types')->insert([
            'name' => 'Double cut',
        ]);

        DB::table('guitar_types')->insert([
            'name' => 'Hollow body',
        ]);

        DB::table('guitar_types')->insert([
            'name' => 'Single coil',
        ]);

        DB::table('guitar_types')->insert([
            'name' => 'Humbucker',
        ]);

        DB::table('guitar_types')->insert([
            'name' => 'Single Coil',
        ]);

        DB::table('guitar_types')->insert([
            'name' => '6-string',
        ]);

        DB::table('guitar_types')->insert([
            'name' => '7-string',
        ]);

        DB::table('guitar_types')->insert([
            'name' => '8-string',
        ]);

        DB::table('guitar_types')->insert([
            'name' => 'Signature',
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
