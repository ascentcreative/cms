<?php

namespace AscentCreative\CMS\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Events\Dispatcher;

use AscentCreative\SiteSearch\Models\IndexEntry;


class ReslugModel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cms:reslug {model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'ReSlug all records of a given model';

   
    /**
     * Execute the console command.
     *
     * @param Dispatcher $events
     *
     * @return mixed
     */
    public function handle(Dispatcher $events)
    {
      
        $cls = $this->argument('model');

        $models = $cls::withoutGlobalScopes()->get();
        
        $bar = $this->startBar($models->count(), "Reslugging Models: " . $cls);

        foreach($models as $model) {

            $model->setSlug(true);
            $model->save();

            $bar->advance();
        }

        $bar->advance();

    }


    private function startBar($max, $message=null) {
        $bar = $this->output->createProgressBar($max);
        if($message) {
            $bar->setFormat("%message%\n %current%/%max% [%bar%] %percent:3s%%");
            $bar->setMessage($message);
        }
        $bar->start();
        return $bar;
    }
}
