<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log_cancel_rm extends Model
{
    protected $table = "log_cancel_rm";
    public $primarykey = "id";
    public $timestamp = true;
}
