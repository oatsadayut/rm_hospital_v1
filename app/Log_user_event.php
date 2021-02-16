<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log_user_event extends Model
{
    protected $table = "log_user_event";
    public $primarykey = "id";
    public $timestamp = true;
}
