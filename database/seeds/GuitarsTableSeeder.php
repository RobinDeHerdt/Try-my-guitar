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
            'name' => 'EC-1000 Deluxe',
            'description' => 'Guitars in the LTD EC-1000 Series are designed to offer the tone, feel, looks, and quality that working professional musicians need in an instrument, along with the pricing that typical musicians can still afford. The EC-1000 VB is consistently one of the most popular guitars due to its combination of incredible looks and great performance. It offers a vintage looking body/neck/headstock binding and gold hardware, and includes premier components like LTD locking tuners, a Tonepros locking TOM bridge and tailpiece, and the aggressive punch of active EMG 81/60 pickups. It also offers set-thru construction with a mahogany body, 3 pc. mahogany neck, and 24-fret ebony fingerboard. Available in Vintage Black finish.',
            'brand_id' => 1,
        ]);

        DB::table('guitars')->insert([
            'name' => 'EC-1000 Deluxe 3',
            'description' => 'Guitars in the LTD EC-1000 Series are designed to offer the tone, feel, looks, and quality that working professional musicians need in an instrument, along with the pricing that typical musicians can still afford. The EC-1000 VB is consistently one of the most popular guitars due to its combination of incredible looks and great performance. It offers a vintage looking body/neck/headstock binding and gold hardware, and includes premier components like LTD locking tuners, a Tonepros locking TOM bridge and tailpiece, and the aggressive punch of active EMG 81/60 pickups. It also offers set-thru construction with a mahogany body, 3 pc. mahogany neck, and 24-fret ebony fingerboard. Available in Vintage Black finish.',
            'brand_id' => 1,
        ]);

        DB::table('guitars')->insert([
            'name' => 'EC-1000 Deluxe 2',
            'description' => 'Guitars in the LTD EC-1000 Series are designed to offer the tone, feel, looks, and quality that working professional musicians need in an instrument, along with the pricing that typical musicians can still afford. The EC-1000 VB is consistently one of the most popular guitars due to its combination of incredible looks and great performance. It offers a vintage looking body/neck/headstock binding and gold hardware, and includes premier components like LTD locking tuners, a Tonepros locking TOM bridge and tailpiece, and the aggressive punch of active EMG 81/60 pickups. It also offers set-thru construction with a mahogany body, 3 pc. mahogany neck, and 24-fret ebony fingerboard. Available in Vintage Black finish.',
            'brand_id' => 1,
        ]);

        DB::table('guitars')->insert([
            'name' => 'EC-1000',
            'description' => 'Guitars in the LTD EC-1000 Series are designed to offer the tone, feel, looks, and quality that working professional musicians need in an instrument, along with the pricing that typical musicians can still afford. The EC-1000 VB is consistently one of the most popular guitars due to its combination of incredible looks and great performance. It offers a vintage looking body/neck/headstock binding and gold hardware, and includes premier components like LTD locking tuners, a Tonepros locking TOM bridge and tailpiece, and the aggressive punch of active EMG 81/60 pickups. It also offers set-thru construction with a mahogany body, 3 pc. mahogany neck, and 24-fret ebony fingerboard. Available in Vintage Black finish.',
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

        DB::table('guitar_type')->insert([
            'type_id' => 1,
            'guitar_id' => 2,
        ]);

        DB::table('guitar_type')->insert([
            'type_id' => 2,
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

        DB::table('guitar_type')->insert([
            'type_id' => 2,
            'guitar_id' => 4,
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

        DB::table('guitar_images')->insert([
            'image_uri' => 'images/ec-1000.jpg',
            'guitar_id' => 2,
            'user_id'   => 7,
        ]);

        DB::table('guitar_images')->insert([
            'image_uri' => 'images/ec-1000.jpg',
            'guitar_id' => 3,
            'user_id'   => 42,
        ]);

        DB::table('guitar_images')->insert([
            'image_uri' => 'images/ec-1000-2.jpg',
            'guitar_id' => 3,
            'user_id'   => 21,
        ]);

        DB::table('guitar_images')->insert([
            'image_uri' => 'images/ec-1000-3.jpg',
            'guitar_id' => 4,
            'user_id'   => 2,
        ]);

        DB::table('guitar_images')->insert([
            'image_uri' => 'images/ec-1000.jpg',
            'guitar_id' => 4,
            'user_id'   => 7,
        ]);
    }
}
