<?php

namespace AscentCreative\CMS\Commands;

use Illuminate\Console\Command;

use Illuminate\Support\Facades\Storage;

class RefreshMultiSizeImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cms:refreshmultisizeimages';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Recreate MultiSizeImages based on current config sizes';

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
     * @return int
     */
    public function handle()
    {

       // echo 'running';

        $path = Storage::disk('public')->path('upload/default');

        //echo $path;
        
        // dump(glob($path . "/*[!@]*.{jpg,jpeg,png}", GLOB_BRACE));

        $this->info('Refreshing Images...');

        $iCount = 0;

        foreach(glob($path . "/*.{jpg,jpeg,png}", GLOB_BRACE) as $filename) {

            // if filename contains an @ it's a multisize version
            //  - if we have the parent file, delete it
            //  - if we don't have the parent file, keep it

            // or, do we just ignore them, and simply refresh images without the @?
            // maybe this for now...!
            if(str_contains($filename, '@') === false) {
                $multiSizeImage = new \Guizoxxv\LaravelMultiSizeImage\MultiSizeImage();
                $multiSizeImage->processImage($filename);
                $iCount++;
            }

        }

        $this->info('Complete: ' . $iCount . ' image' . ($iCount!=1?'s were':' was') . ' refreshed.');
        
        return 0;


    }
}
