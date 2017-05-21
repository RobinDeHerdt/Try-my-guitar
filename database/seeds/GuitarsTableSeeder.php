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
        /**
         * Guitar seeders.
         */
        DB::table('guitars')->insert([
            'name' => 'EC-1000',
            'description' => 'Guitars in the LTD EC-1000 Series are designed to offer the tone, feel, looks, and quality that working professional musicians need in an instrument, along with the pricing that typical musicians can still afford. The EC-1000 VB is consistently one of the most popular guitars due to its combination of incredible looks and great performance. It offers a vintage looking body/neck/headstock binding and gold hardware, and includes premier components like LTD locking tuners, a Tonepros locking TOM bridge and tailpiece, and the aggressive punch of active EMG 81/60 pickups. It also offers set-thru construction with a mahogany body, 3 pc. mahogany neck, and 24-fret ebony fingerboard. Available in Vintage Black finish.',
            'brand_id' => 1,
        ]);

        DB::table('guitars')->insert([
            'name' => 'James Hetfield Iron Cross',
            'description' => 'Made by hand at the ESP Custom Shop in Japan, the ESP Iron Cross is a Signature Series model of James Hetfield, the frontman of Metallica and one of the world\'s most highly respected rhtyhm guitar players in any genre. The Iron Cross is based on James\' personal custom instrument design, and features set-neck construction of a mahogany body with maple cap, and a single-piece mahogany neck with ebony fingerboard and 22 extra-jumbo frets with an Iron Cross inlay at the 12th fret. The ESP Iron Cross is powered by James\' own EMG JH SET active pickups, and includes premier components such as Schaller straplocks, Sperzel locking tuners, and a TonePros locking TOM bridge and tailpiece. Available in Snow White finish with black stripe graphic and iron cross fixture. The ESP Iron Cross includes a hardshell case and comes with a Certificate of Authenticity from ESP.',
            'brand_id' => 2,
        ]);

        DB::table('guitars')->insert([
            'name' => 'Squier Stratocaster',
            'description' => 'Squier is Fender-sharing its product platforms, trademarks, standards and iconic designs. Squier is the launching pad for beginners, pointing intermediate and advancing guitarists toward their ultimate goal-owning a Fender!',
            'brand_id' => 4,
        ]);

        /**
         * Pivot table seeders.
         */
        DB::table('user_guitar')->insert([
            'guitar_id' => 1,
            'user_id' => 1,
            'owned' => true,
            'experience' => 'This was my first guitar. I bought it 30 years ago and it\'s still my favorite.',
        ]);

        DB::table('user_guitar')->insert([
            'guitar_id' => 1,
            'user_id' => 2,
            'owned' => true,
            'experience' => 'This was my second guitar. I bought it 31 years ago and it\'s still my favorite.',
        ]);

        DB::table('user_guitar')->insert([
            'guitar_id' => 1,
            'user_id' => 3,
            'owned' => false,
            'experience' => 'A friend of mine owns this guitar. Plays very smooth blabla.',
        ]);

        DB::table('user_guitar')->insert([
            'guitar_id' => 2,
            'user_id' => 2,
            'owned' => true,
            'experience' => 'This is a guitar I own.',
        ]);

        DB::table('user_guitar')->insert([
            'guitar_id' => 2,
            'user_id' => 3,
            'owned' => false,
            'experience' => 'This is a guitar I don\'t own.',
        ]);

        DB::table('user_guitar')->insert([
            'guitar_id' => 3,
            'user_id' => 3,
            'owned' => false,
            'experience' => 'This is a guitar I don\'t own.',
        ]);
    }
}
