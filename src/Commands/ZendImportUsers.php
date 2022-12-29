<?php

namespace AscentCreative\CMS\Commands;

use Illuminate\Console\Command;

use Illuminate\Support\Facades\DB;

use App\Models\User;


class ZendImportUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cms:zendimportusers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import historical users from Zend';

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

        // \AscentCreative\Store\ZendImporter::import();
        // dump('Importing');

        $res = DB::connection('zend')->select('select * from core_user where isLive = 1 and emailAddress is not null');      

        foreach($res as $zUser) {

            // dd($zUser);

            $product = User::updateOrCreate([
                'id' => $zUser->id,
            ],[
                'first_name' => $zUser->firstName ?? '',
                'last_name' => $zUser->lastName ?? '',
                'email' => $zUser->emailAddress,
                'password' => $zUser->password,

            ]);

        }
    


        return 0;
    }
}
