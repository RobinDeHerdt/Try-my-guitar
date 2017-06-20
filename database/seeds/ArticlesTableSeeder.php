<?php

use Illuminate\Database\Seeder;

class ArticlesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('articles')->insert([
            'title' => "Matt heafy's signature",
            'image_uri' => 'images/matt-heafy.jpg',
            'user_id' => 1,
            'body' => "Epiphone and Trivium's Matt Heafy have teamed up to create the Limited Edition Matt Heafy Les Paul Custom Electric Guitar, a totally killer original take on the world-famous Les Paul. Designed in close collaboration with Matt Heafy, each Ltd. Ed. Matt Heafy Les Paul Custom reflects his distinctive approach to guitar, which has earned him and Trivium scores of dedicated fans around the world. Each of Trivium's albums has sold over half a million copies worldwide. Check out a Trivium performance and you'll see why. The rule books on how-to-play a Les Paul go right out the window when Heafy plugs in and his revolutionary use of an LP Custom seven-string is a breakthrough in contemporary metal and hard rock. Now, Matt Heafy joins an illustrious group of Epiphone artists with the introduction of this signature model. \n\n The Limited Edition Matt Heafy Les Paul Custom features an all blacked-out ebony gloss finish that's especially striking on the sleek profile of an LP Custom. Like all great Les Pauls, it features a mahogany body with a plain maple veneer top, a time-tested combination that has gone virtually unchanged since the '50s. The mahogany neck has a fast 1960's SlimTaper ˜D' profile with a glued-in deep set-neck joint with an \"Axcess\" heel for a smooth and easy reach to the upper frets. The scale length is 24.75\" and the ebony fingerboard has a 12\" radius and 22 medium jumbo frets and features pearloid block inlays, which seem to practically glow in the dark against the Ebony finish. The nut, which is also black is 1-11/16\". The classic clipped dovewing headstock features the historic pearloid \"split-diamond\" Les Paul Custom inlay and a vintage style \"Epiphone\" logo in white. The bell-shaped truss rod cover is black with a shadow of white binding and MKH Les Paul Custom in white silk screen. Each guitar features beautiful 7-ply white and black binding on the top and 5-ply binding on the headstock. The fingerboard features single ply white binding. \n\n This Ltd. Ed. Matt Heafy Les Paul Custom features an EMG-85 in the neck position and an EMG-81 in the bridge position. The EMG-81 is one of the most popular metal pickups ever and has been at the center of a sound revolution since it was first introduced. Utilizing powerful ceramic magnets and close aperture coils, the EMG-81 is designed for detailed intensity, incredible amounts of high end cut, and fluid sustain. The EMG-85 features Alnico-V magnets and has a slightly more rounded tone. The classic combination of an EMG 81 with an EMG 85 in a Les Paul Custom offers metal guitarists an incredible array of extreme possibilities. \n\n The Limited Edition Matt Heafy Les Paul Custom features Epiphone's no-compromise electronics including a 1/4\" non-rotating output jack and volume and tone controls with Black Speed Knobs that are powered by full-size 500KÎ potentiometers. The pickup switch is Epiphone's all-metal 3-way pickup selector with a black toggle cap. Epiphone Rock Solid Hardware: Like all Epiphones, it includes Epiphone's made-to-last heavy-duty hardware including Epiphone StrapLocks, including a black LockTone tune-o-matic/StopBar on this special axe. It also features deluxe die-cast machine heads with metal \"tulip buttons\" with a 14:1 tuning ratio. Case sold separately.",
        ]);

        DB::table('comments')->insert([
            'body' => "I\'m so looking forward to trying this guitar.",
            'article_id' => 1,
            'user_id' => 4,
        ]);

        DB::table('comments')->insert([
            'body' => "Matt Heafy is such a cool guy.",
            'article_id' => 1,
            'user_id' => 4,
        ]);
    }
}
