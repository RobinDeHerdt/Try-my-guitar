<?php

use Illuminate\Database\Seeder;

class MessagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Add channels.
        DB::table('channels')->insert([
            'name' => 'Admin - Matt - James',
        ]);

        DB::table('channels')->insert([
            'name' => 'Best chat',
        ]);

        // Create pivot.
        DB::table('channel_user')->insert([
            'user_id' => 1,
            'channel_id' => 1,
            'accepted' => true,
        ]);

        DB::table('channel_user')->insert([
            'user_id' => 2,
            'channel_id' => 1,
            'accepted' => true,
        ]);

        DB::table('channel_user')->insert([
            'user_id' => 3,
            'channel_id' => 1,
            'accepted' => true,
        ]);

        DB::table('channel_user')->insert([
            'user_id' => 1,
            'channel_id' => 2,
            'accepted' => true,
        ]);

        DB::table('channel_user')->insert([
            'user_id' => 2,
            'channel_id' => 2,
            'accepted' => true,
        ]);
    }
}
