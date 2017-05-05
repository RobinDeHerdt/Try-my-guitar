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
        DB::table('messages')->insert([
            'message' => 'this is a testmessage to the administrator',
            'sender_id' => 2,
            'receiver_id' => 1,
        ]);
    }
}
