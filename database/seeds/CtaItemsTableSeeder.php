<?php

use Illuminate\Database\Seeder;

class CtaItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // @todo: fix these shitty NL translations
        DB::table('cta_items')->insert([
            'title' => 'Meet',
            'icon_class' => 'fa-users',
            'content_en' => 'Get to know guitar players in your area, and by extension, their guitar! Arrange a meet-up in person and rock out together!',
            'content_nl' => 'Leer gitaarspelers kennnen uit jouw buurt - en bij gevolg - hun gitaar!',
            'active' => true,
        ]);

        DB::table('cta_items')->insert([
            'title' => 'Discover',
            'icon_class' => 'fa-search',
            'content_en' => 'Discover guitars and read about other people\'s experiences with them.',
            'content_nl' => 'Ontdek nieuwe gitaren en lees de ervaringen van de eigenaars.',
            'active' => true,
        ]);

        DB::table('cta_items')->insert([
            'title' => 'Profile level',
            'icon_class' => 'fa-user-plus',
            'content_en' => 'Earn experience points and level up your profile by contributing to the site.',
            'content_nl' => 'Verdien exp punten en level je profiel door bij te dragen aan de website.',
            'active' => true,
        ]);
    }
}
