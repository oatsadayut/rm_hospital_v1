<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','person_id','cid', 'username', 'password',
    ];

    public function person(){
        return $this->hasOne(Person::class,'person_id','person_id');
    }

    public function per(){
        return $this->hasOne(Permission::class,'per_id','permission');
    }


}
