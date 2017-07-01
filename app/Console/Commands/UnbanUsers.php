<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\User;

class UnbanUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:unban';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Unban users who received a temporary ban for 14 days.';

    /**
     * Create a new command instance.
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $date = Carbon::now();

        $users = User::where('inactive_until', '<=', $date)->get();

        foreach ($users as $user) {
            $user->inactive_until = null;
            $user->active = true;
            $user->save();
        }
    }
}
