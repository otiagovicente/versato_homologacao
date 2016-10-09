<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Contracts\Search;

class AlgoliaIndexer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'versato:index {table}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send table data to AlgoliaSearch';

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
    public function handle(Search $search)
    {
        //assign Table
        $table = $this->argument('table');
        //fetch data
        $collection = collect(
            \DB::table($table)->get()
        )->map(function($item){
            $item->objectID = $item->id;
            $item->brand_id = (int) $item->brand_id;
            return (array) $item;
        });
        
        //save to Algolia
        $search->index($table)->saveObjects($collection);
        //send message to user
        $this->info('All done!');
    }
}
