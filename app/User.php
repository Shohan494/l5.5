<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    const VERIFIED_USER = "1";
    const UNVERIFIED_USER = "0";
    const ADMIN_USER = "true";
    const REGULAR_USER = "false";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    
    // needed for the buyer seller extends user that's why
    // *****************************************
    // **********************************
    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'verified',
        'verification_token',
        'admin',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'verification_token',
    ];

    public function setNameAttribute($name)
    {
        $this->attributes['name'] = strtolower($name);
    }

    public function getNameAttribute($name)
    {
        return ucwords($name);
    }

    public function setEmailAttribute($email)
    {
        $this->attributes['email'] = $email;
    }

    public function getEmailAttribute($email)
    {
        return ucwords($email);
    }


    public function isVerified()
    {
        return $this->verified == User::VERIFIED_USER;
    }

    public function isAdmin()
    {
        return $this->status == User::ADMIN_USER;
    }

    public static function generate_token()
    {
        return str_random(40);
    }
}
