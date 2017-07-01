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
            'content' => 'Get to know guitar players in your area, and by extension, their guitar! Arrange a meet-up in person and rock out together!',
            'active' => true,
        ]);

        DB::table('cta_items')->insert([
            'title' => 'Discover',
            'icon_class' => 'fa-search',
            'content' => 'Discover guitars and read about other people\'s experiences with them.',
            'active' => true,
        ]);

        DB::table('cta_items')->insert([
            'title' => 'Profile level',
            'icon_class' => 'fa-user-plus',
            'content' => 'Earn experience points and level up your profile by contributing to the site.',
            'active' => true,
        ]);
    }
}
