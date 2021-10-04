<?php

namespace AscentCreative\CMS\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Spatie\Permission\Traits\HasRoles;
use Spatie\Activitylog\Models\Activity;

class User extends Authenticatable // implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasRoles;

   // protected $table = "jhl_users";


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

     // as we've split the names, return the full name as needed:
     public function getNameAttribute() {
        return $this->first_name . ' ' . $this->last_name;
    }


    public function activityOn() {
        return $this->morphMany(Activity::class, 'subject');
    }

    public function activityBy() {
        return $this->morphMany(Activity::class, 'causer');
    }

    public function getLastLoginAttribute() {

        $act = $this->activityOn()->orderBy('created_at', 'desc')->first();
        if ($act) {
            return $act->created_at;
        }
        
    }

    
}
