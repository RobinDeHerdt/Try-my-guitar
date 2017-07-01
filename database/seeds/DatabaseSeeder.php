<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(MessagesTableSeeder::class);
        $this->call(GuitarBrandsTableSeeder::class);
        $this->call(GuitarsTableSeeder::class);
        $this->call(GuitarTypesTableSeeder::class);
        $this->call(GuitarImagesTableSeeder::class);
        $this->call(ReportsTableSeeder::class);
        $this->call(CtaItemsTableSeeder::class);
        $this->call(ExperiencesTableSeeder::class);
        $this->call(ArticlesTableSeeder::class);
    }
}
