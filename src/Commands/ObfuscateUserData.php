<?php

namespace AscentCreative\CMS\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class ObfuscateUserData extends Command
{

    use ConfirmableTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cms:obfuscate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Replaces users' names and emails with fake data";

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

        echo get_class($this->getLaravel());

        if (! $this->confirmToProceed()) {
            return 1;
        }

        $faker = \Faker\Factory::create();

        $users = User::whereDoesntHave('roles', function($q) {
            $q->where('name', 'admin');
        })->get();

     

        foreach($users as $user) {
            $user->update([
                'first_name'=>$faker->firstName,
                'last_name'=>$faker->lastName,
                'email'=>$faker->email,
            ]);
        }

        return 0;
    }
}
