<?php

use Illuminate\Database\Seeder;

class CtaSectionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cta_sections')->insert([
            'title' => 'Meet',
            'cta_icon_class' => 'fa-users',
            'cta_text' => 'Get to know guitar players in your area, and by extension, their guitar! Arrange a meet-up in person and rock out together!',
        ]);

        DB::table('cta_sections')->insert([
            'title' => 'Discover',
            'cta_icon_class' => 'fa-search',
            'cta_text' => 'Discover guitars and read about other people\'s experiences with them.',
        ]);

        DB::table('cta_sections')->insert([
            'title' => 'Profile level',
            'cta_icon_class' => 'fa-user-plus',
            'cta_text' => 'Earn experience points and level up your profile by contributing to the site.',
        ]);
    }
}
