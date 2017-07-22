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
        DB::table('cta_items')->insert([
            'title' => 'Meet',
            'icon_class' => 'fa-users',
            'content_en' => 'Get to know guitar players in your area, and by extension, their guitar! Arrange a meet-up in person and rock out together!',
            'content_nl' => 'Ontmoet gitaristen uit jouw buurt en probeer hun gitaar uit!',
            'active' => true,
        ]);

        DB::table('cta_items')->insert([
            'title' => 'Discover',
            'icon_class' => 'fa-search',
            'content_en' => 'Discover guitars and read about other people\'s experiences with them.',
            'content_nl' => 'Ontdek nieuwe gitaren en lees ervaringen van de anderen.',
            'active' => true,
        ]);

        DB::table('cta_items')->insert([
            'title' => 'Profile level',
            'icon_class' => 'fa-user-plus',
            'content_en' => 'Earn experience points and level up your profile by contributing to the site.',
            'content_nl' => 'Verdien ervaringspunten en level je profiel door bij te dragen aan de website.',
            'active' => true,
        ]);
    }
}
