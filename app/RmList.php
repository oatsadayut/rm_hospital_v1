<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RmList extends Model
{
    protected $table = "rmlistall";
    public $primarykey = "rmmain_id";
    public $timestamp = true;
}
