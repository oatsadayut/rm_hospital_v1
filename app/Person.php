<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $table = "person";
    public $primarykey = "person_id";
    public $timestamp = true;

    protected $fillable = [
        'person_id','person_cid', 'person_fname', 'person_lname', 'dep_code','person_birthdate','status',
    ];

    public function dep(){
        return $this->hasOne(Co_dep::class,'dep_code','dep_code');
    }
}
