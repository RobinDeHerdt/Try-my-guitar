<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Article;
use Illuminate\Console\Command;

class RemoveTrashed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'trash:remove {data_type}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete items trashed for more than 2 weeks permanently.';

    /**
     * Create a new command instance.
     *
     * @return void
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
        $date = Carbon::now()->subWeeks(2);

        switch ($this->argument('data_type'))
        {
            case 'articles':
                Article::onlyTrashed()->where('deleted_at', '<=', $date)->forceDelete();
                break;
        }
    }
}
