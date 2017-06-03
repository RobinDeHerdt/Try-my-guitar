<?php

use Illuminate\Database\Seeder;

class AboutSectionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('about_sections')->insert([
            'title' => 'Meet',
            'show_cta' => true,
            'cta_icon_class' => 'fa-user-plus',
            'cta_text' => 'Get to know guitar players in your area, and by extension, their guitar! Arrange a meet-up in person and rock out together!',
            'column_one' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed tempus justo eget ipsum placerat iaculis. Nunc vitae velit magna. Nulla molestie magna vitae arcu vestibulum tincidunt. Nulla non venenatis felis.',
            'column_two' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed tempus justo eget ipsum placerat iaculis. Nunc vitae velit magna. Nulla molestie magna vitae arcu vestibulum tincidunt. Nulla non venenatis felis.',
        ]);

        DB::table('about_sections')->insert([
            'title' => 'Discover',
            'show_cta' => true,
            'cta_icon_class' => 'fa-search',
            'cta_text' => 'Discover guitars and read about other people\'s experiences with them.',
            'column_one' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed tempus justo eget ipsum placerat iaculis. Nunc vitae velit magna. Nulla molestie magna vitae arcu vestibulum tincidunt. Nulla non venenatis felis.',
            'column_two' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed tempus justo eget ipsum placerat iaculis. Nunc vitae velit magna. Nulla molestie magna vitae arcu vestibulum tincidunt. Nulla non venenatis felis.',
        ]);

        DB::table('about_sections')->insert([
            'title' => 'Crow sourced',
            'show_cta' => true,
            'cta_icon_class' => 'fa-users',
            'cta_text' => 'Crowd sourced collection of all guitars in existance.',
            'column_one' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed tempus justo eget ipsum placerat iaculis. Nunc vitae velit magna. Nulla molestie magna vitae arcu vestibulum tincidunt. Nulla non venenatis felis.',
            'column_two' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed tempus justo eget ipsum placerat iaculis. Nunc vitae velit magna. Nulla molestie magna vitae arcu vestibulum tincidunt. Nulla non venenatis felis.',
        ]);

        DB::table('about_sections')->insert([
            'title' => 'Another about section',
            'show_cta' => false,
            'column_one' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed tempus justo eget ipsum placerat iaculis. Nunc vitae velit magna. Nulla molestie magna vitae arcu vestibulum tincidunt. Nulla non venenatis felis.',
            'column_two' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed tempus justo eget ipsum placerat iaculis. Nunc vitae velit magna. Nulla molestie magna vitae arcu vestibulum tincidunt. Nulla non venenatis felis.',
        ]);
    }
}
