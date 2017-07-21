<?php

use Illuminate\Database\Seeder;
use App\Guitar;

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
            'contributor_id' => 123,
        ]);

        DB::table('guitars')->insert([
            'name' => 'James Hetfield Iron Cross',
            'description' => 'Made by hand at the ESP Custom Shop in Japan, the ESP Iron Cross is a Signature Series model of James Hetfield, the frontman of Metallica and one of the world\'s most highly respected rhtyhm guitar players in any genre. The Iron Cross is based on James\' personal custom instrument design, and features set-neck construction of a mahogany body with maple cap, and a single-piece mahogany neck with ebony fingerboard and 22 extra-jumbo frets with an Iron Cross inlay at the 12th fret. The ESP Iron Cross is powered by James\' own EMG JH SET active pickups, and includes premier components such as Schaller straplocks, Sperzel locking tuners, and a TonePros locking TOM bridge and tailpiece. Available in Snow White finish with black stripe graphic and iron cross fixture. The ESP Iron Cross includes a hardshell case and comes with a Certificate of Authenticity from ESP.',
            'brand_id' => 3,
            'contributor_id' => 444,
        ]);

        DB::table('guitars')->insert([
            'name' => 'Stratocaster',
            'description' => 'Squier is Fender-sharing its product platforms, trademarks, standards and iconic designs. Squier is the launching pad for beginners, pointing intermediate and advancing guitarists toward their ultimate goal-owning a Fender!',
            'brand_id' => 8,
            'contributor_id' => 333,
        ]);

        DB::table('guitars')->insert([
            'name' => 'Stratocaster',
            'description' => 'Fender product.',
            'brand_id' => 5,
            'contributor_id' => 222,
        ]);

        DB::table('guitars')->insert([
            'name' => 'EX-1000',
            'description' => 'LTD EX-1000 series guitar.',
            'brand_id' => 1,
            'contributor_id' => 111,
        ]);

        DB::table('guitars')->insert([
            'name' => 'AX-1000',
            'description' => 'LTD AX-1000 series guitar.',
            'brand_id' => 1,
            'contributor_id' => 50,
        ]);

        DB::table('guitars')->insert([
            'name' => 'Alex Skolnick signature AS-1',
            'description' => 'Signature guitar. Silverburst.',
            'brand_id' => 3,
            'contributor_id' => 78,
        ]);

        DB::table('guitars')->insert([
            'name' => 'Arrow',
            'description' => 'The ESP Original Series are guitars made by hand by our experienced master luthiers who work in the ESP Custom Shop in Tokyo, Japan. Each guitar is made one at a time, with a level of detail and craftsmanship that\'s unsurpassed in the musical instrument industry. With the ESP Arrow Rusty Iron, you get a guitar that will set you apart from the rest of the world. It has a textured finish that looks like oxidized metal, as if your guitar was an ancient relic sculpted in a different era. But the ESP Arrow is a completely modern machine, with neck-thru-body construction at 25.5" scale, a set of active Seymour Duncan Blackout pickups, and top-tier components like a Floyd Rose Original bridge and Gotoh locking tuners. It offers an alder body, a super-fast three-piece maple neck, and an ebony fingerboard with 24 extra-jumbo frets. Includes a hardshell case.',
            'brand_id' => 3,
            'contributor_id' => 99,
        ]);


        /**
         * Pivot table seeders.
         */
        DB::table('user_guitar')->insert([
            'guitar_id' => 1,
            'user_id' => 1,
        ]);

        DB::table('user_guitar')->insert([
            'guitar_id' => 1,
            'user_id' => 2,
            'profile_show' => true,
        ]);

        DB::table('user_guitar')->insert([
            'guitar_id' => 1,
            'user_id' => 3,
            'profile_show' => true,
        ]);

        DB::table('user_guitar')->insert([
            'guitar_id' => 2,
            'user_id' => 2,
        ]);

        DB::table('user_guitar')->insert([
            'guitar_id' => 2,
            'user_id' => 3,
            'profile_show' => true,
        ]);

        DB::table('user_guitar')->insert([
            'guitar_id' => 3,
            'user_id' => 3,
        ]);


        /**
         * Add some guitars to random users' collection.
         */
        $guitars = Guitar::all();

        foreach ($guitars as $guitar) {
            $users = [];

            for ($i = 0; $i < rand(2, 50); $i++) {
                $random = rand(4, 1500);
                array_push($users, $random);
            }

            $guitar->users()->attach($users);
        }
    }
}
