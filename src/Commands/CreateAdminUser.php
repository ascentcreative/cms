<?php

namespace AscentCreative\CMS\Commands;

use Illuminate\Console\Command;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;


class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cms:createadminuser';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create an admin user';

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

        // do the roles and permissions exist?
        $permission = Permission::findOrCreate('administer', 'web');
        $role = Role::findOrCreate('admin', 'web');

        $role->givePermissionTo($permission);

        $first = $this->ask('First Name:');
        $last = $this->ask('Last Name:');
        $email = $this->ask("Email:");
        $pwd = $this->secret('Password: (What you type will be hidden)');

        $usr = \App\Models\User::create([
             'first_name' => $first,
             'last_name' => $last,
             'email' => $email,
             'password' => Hash::make($pwd),
        ]);
        

        $usr->assignRole($role);


        return 0;
    }
}
