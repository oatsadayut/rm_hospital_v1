<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Co_source extends Model
{
    protected $table = "co_source";
    public $primarykey = "source_code";
    protected $fillable = [
        'source_code', 'source_name', 'status',
    ];

}
