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
    protected $description = 'Permanently delete items trashed for more than 2 weeks.';

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
        $date = Carbon::now()->subWeeks(2);

        switch ($this->argument('data_type')) {
            case 'articles':
                $articles = Article::onlyTrashed()->where('deleted_at', '<=', $date)->get();

                foreach ($articles as $article) {
                    $article->comments()->forceDelete();
                    $article->forceDelete();
                }
                break;
        }
    }
}
