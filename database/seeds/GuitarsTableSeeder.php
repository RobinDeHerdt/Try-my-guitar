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


        DB::table('guitars')->insert([
            'name' => 'Guitar 1',
            'description' => 'Guitars in the LTD EC-1000 Series are designed to offer the tone, feel, looks, and quality that working professional musicians need in an instrument, along with the pricing that typical musicians can still afford. The EC-1000 VB is consistently one of the most popular guitars due to its combination of incredible looks and great performance. It offers a vintage looking body/neck/headstock binding and gold hardware, and includes premier components like LTD locking tuners, a Tonepros locking TOM bridge and tailpiece, and the aggressive punch of active EMG 81/60 pickups. It also offers set-thru construction with a mahogany body, 3 pc. mahogany neck, and 24-fret ebony fingerboard. Available in Vintage Black finish.',
            'brand_id' => 1,
        ]);

        DB::table('guitars')->insert([
            'name' => 'Guitar 2',
            'description' => 'Guitars in the LTD EC-1000 Series are designed to offer the tone, feel, looks, and quality that working professional musicians need in an instrument, along with the pricing that typical musicians can still afford. The EC-1000 VB is consistently one of the most popular guitars due to its combination of incredible looks and great performance. It offers a vintage looking body/neck/headstock binding and gold hardware, and includes premier components like LTD locking tuners, a Tonepros locking TOM bridge and tailpiece, and the aggressive punch of active EMG 81/60 pickups. It also offers set-thru construction with a mahogany body, 3 pc. mahogany neck, and 24-fret ebony fingerboard. Available in Vintage Black finish.',
            'brand_id' => 1,
        ]);

        DB::table('guitars')->insert([
            'name' => 'Guitar 3',
            'description' => 'Guitars in the LTD EC-1000 Series are designed to offer the tone, feel, looks, and quality that working professional musicians need in an instrument, along with the pricing that typical musicians can still afford. The EC-1000 VB is consistently one of the most popular guitars due to its combination of incredible looks and great performance. It offers a vintage looking body/neck/headstock binding and gold hardware, and includes premier components like LTD locking tuners, a Tonepros locking TOM bridge and tailpiece, and the aggressive punch of active EMG 81/60 pickups. It also offers set-thru construction with a mahogany body, 3 pc. mahogany neck, and 24-fret ebony fingerboard. Available in Vintage Black finish.',
            'brand_id' => 1,
        ]);

        DB::table('guitars')->insert([
            'name' => 'Guitar 4',
            'description' => 'Guitars in the LTD EC-1000 Series are designed to offer the tone, feel, looks, and quality that working professional musicians need in an instrument, along with the pricing that typical musicians can still afford. The EC-1000 VB is consistently one of the most popular guitars due to its combination of incredible looks and great performance. It offers a vintage looking body/neck/headstock binding and gold hardware, and includes premier components like LTD locking tuners, a Tonepros locking TOM bridge and tailpiece, and the aggressive punch of active EMG 81/60 pickups. It also offers set-thru construction with a mahogany body, 3 pc. mahogany neck, and 24-fret ebony fingerboard. Available in Vintage Black finish.',
            'brand_id' => 1,
        ]);

        DB::table('guitars')->insert([
            'name' => 'Guitar 5',
            'description' => 'Guitars in the LTD EC-1000 Series are designed to offer the tone, feel, looks, and quality that working professional musicians need in an instrument, along with the pricing that typical musicians can still afford. The EC-1000 VB is consistently one of the most popular guitars due to its combination of incredible looks and great performance. It offers a vintage looking body/neck/headstock binding and gold hardware, and includes premier components like LTD locking tuners, a Tonepros locking TOM bridge and tailpiece, and the aggressive punch of active EMG 81/60 pickups. It also offers set-thru construction with a mahogany body, 3 pc. mahogany neck, and 24-fret ebony fingerboard. Available in Vintage Black finish.',
            'brand_id' => 1,
        ]);

        DB::table('guitars')->insert([
            'name' => 'Guitar 6',
            'description' => 'Guitars in the LTD EC-1000 Series are designed to offer the tone, feel, looks, and quality that working professional musicians need in an instrument, along with the pricing that typical musicians can still afford. The EC-1000 VB is consistently one of the most popular guitars due to its combination of incredible looks and great performance. It offers a vintage looking body/neck/headstock binding and gold hardware, and includes premier components like LTD locking tuners, a Tonepros locking TOM bridge and tailpiece, and the aggressive punch of active EMG 81/60 pickups. It also offers set-thru construction with a mahogany body, 3 pc. mahogany neck, and 24-fret ebony fingerboard. Available in Vintage Black finish.',
            'brand_id' => 2,
        ]);

        DB::table('guitars')->insert([
            'name' => 'Guitar 7',
            'description' => 'Guitars in the LTD EC-1000 Series are designed to offer the tone, feel, looks, and quality that working professional musicians need in an instrument, along with the pricing that typical musicians can still afford. The EC-1000 VB is consistently one of the most popular guitars due to its combination of incredible looks and great performance. It offers a vintage looking body/neck/headstock binding and gold hardware, and includes premier components like LTD locking tuners, a Tonepros locking TOM bridge and tailpiece, and the aggressive punch of active EMG 81/60 pickups. It also offers set-thru construction with a mahogany body, 3 pc. mahogany neck, and 24-fret ebony fingerboard. Available in Vintage Black finish.',
            'brand_id' => 2,
        ]);

        DB::table('guitars')->insert([
            'name' => 'Guitar 8',
            'description' => 'Guitars in the LTD EC-1000 Series are designed to offer the tone, feel, looks, and quality that working professional musicians need in an instrument, along with the pricing that typical musicians can still afford. The EC-1000 VB is consistently one of the most popular guitars due to its combination of incredible looks and great performance. It offers a vintage looking body/neck/headstock binding and gold hardware, and includes premier components like LTD locking tuners, a Tonepros locking TOM bridge and tailpiece, and the aggressive punch of active EMG 81/60 pickups. It also offers set-thru construction with a mahogany body, 3 pc. mahogany neck, and 24-fret ebony fingerboard. Available in Vintage Black finish.',
            'brand_id' => 3,
        ]);

        DB::table('guitars')->insert([
            'name' => 'Guitar 9',
            'description' => 'Guitars in the LTD EC-1000 Series are designed to offer the tone, feel, looks, and quality that working professional musicians need in an instrument, along with the pricing that typical musicians can still afford. The EC-1000 VB is consistently one of the most popular guitars due to its combination of incredible looks and great performance. It offers a vintage looking body/neck/headstock binding and gold hardware, and includes premier components like LTD locking tuners, a Tonepros locking TOM bridge and tailpiece, and the aggressive punch of active EMG 81/60 pickups. It also offers set-thru construction with a mahogany body, 3 pc. mahogany neck, and 24-fret ebony fingerboard. Available in Vintage Black finish.',
            'brand_id' => 3,
        ]);

        DB::table('guitars')->insert([
            'name' => 'Squier Stratocaster',
            'description' => 'Squier is Fender-sharing its product platforms, trademarks, standards and iconic designs. Squier is the launching pad for beginners, pointing intermediate and advancing guitarists toward their ultimate goal-owning a Fender!',
            'brand_id' => 4,
        ]);

        DB::table('guitars')->insert([
            'name' => 'James Hetfield Iron Cross',
            'description' => 'Made by hand at the ESP Custom Shop in Japan, the ESP Iron Cross is a Signature Series model of James Hetfield, the frontman of Metallica and one of the world\'s most highly respected rhtyhm guitar players in any genre. The Iron Cross is based on James\' personal custom instrument design, and features set-neck construction of a mahogany body with maple cap, and a single-piece mahogany neck with ebony fingerboard and 22 extra-jumbo frets with an Iron Cross inlay at the 12th fret. The ESP Iron Cross is powered by James\' own EMG JH SET active pickups, and includes premier components such as Schaller straplocks, Sperzel locking tuners, and a TonePros locking TOM bridge and tailpiece. Available in Snow White finish with black stripe graphic and iron cross fixture. The ESP Iron Cross includes a hardshell case and comes with a Certificate of Authenticity from ESP.',
            'brand_id' => 2,
        ]);

        DB::table('guitar_types')->insert([
            'name' => 'Electric guitar',
        ]);

        DB::table('guitar_types')->insert([
            'name' => '6-string',
        ]);

        DB::table('guitar_types')->insert([
            'name' => '7-string',
        ]);

        DB::table('guitar_types')->insert([
            'name' => 'Signature',
        ]);

        DB::table('guitar_type')->insert([
            'type_id' => 1,
            'guitar_id' => 1,
        ]);

        DB::table('guitar_type')->insert([
            'type_id' => 4,
            'guitar_id' => 11,
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

        DB::table('guitar_type')->insert([
            'type_id' => 2,
            'guitar_id' => 4,
        ]);

        DB::table('guitar_type')->insert([
            'type_id' => 3,
            'guitar_id' => 5,
        ]);

        DB::table('guitar_type')->insert([
            'type_id' => 1,
            'guitar_id' => 5,
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

        DB::table('guitar_images')->insert([
            'image_uri' => 'images/ec-1000.jpg',
            'guitar_id' => 5,
            'user_id'   => 19,
        ]);

        DB::table('guitar_images')->insert([
            'image_uri' => 'images/ec-1000.jpg',
            'guitar_id' => 6,
            'user_id'   => 7,
        ]);

        DB::table('guitar_images')->insert([
            'image_uri' => 'images/ec-1000.jpg',
            'guitar_id' => 7,
            'user_id'   => 19,
        ]);

        DB::table('guitar_images')->insert([
            'image_uri' => 'images/ec-1000.jpg',
            'guitar_id' => 8,
            'user_id'   => 7,
        ]);

        DB::table('guitar_images')->insert([
            'image_uri' => 'images/ec-1000.jpg',
            'guitar_id' => 9,
            'user_id'   => 19,
        ]);

        DB::table('guitar_images')->insert([
            'image_uri' => 'images/fender-squier.jpg',
            'guitar_id' => 10,
            'user_id'   => 19,
        ]);

        DB::table('guitar_images')->insert([
            'image_uri' => 'images/iron-cross.jpg',
            'guitar_id' => 11,
            'user_id'   => 3,
        ]);

        DB::table('guitar_images')->insert([
            'image_uri' => 'images/iron-cross-neck.jpg',
            'guitar_id' => 11,
            'user_id'   => 3,
        ]);

        DB::table('user_guitar')->insert([
            'guitar_id' => 1,
            'user_id'   => 1,
        ]);

        DB::table('user_guitar')->insert([
            'guitar_id' => 11,
            'user_id'   => 3,
        ]);

        DB::table('user_guitar')->insert([
            'guitar_id' => 1,
            'user_id'   => 3,
        ]);

        DB::table('user_guitar')->insert([
            'guitar_id' => 2,
            'user_id'   => 2,
        ]);

        DB::table('user_guitar')->insert([
            'guitar_id' => 2,
            'user_id'   => 3,
        ]);

        DB::table('user_guitar')->insert([
            'guitar_id' => 3,
            'user_id'   => 3,
        ]);

        DB::table('user_guitar')->insert([
            'guitar_id' => 4,
            'user_id'   => 3,
        ]);

        DB::table('user_guitar')->insert([
            'guitar_id' => 4,
            'user_id'   => 30,
        ]);

        DB::table('user_guitar')->insert([
            'guitar_id' => 4,
            'user_id'   => 31,
        ]);

        DB::table('user_guitar')->insert([
            'guitar_id' => 4,
            'user_id'   => 40,
        ]);

        DB::table('user_guitar')->insert([
            'guitar_id' => 4,
            'user_id'   => 41,
        ]);

        DB::table('user_guitar')->insert([
            'guitar_id' => 4,
            'user_id'   => 45,
        ]);

        DB::table('user_guitar')->insert([
            'guitar_id' => 10,
            'user_id'   => 3,
        ]);
    }
}
