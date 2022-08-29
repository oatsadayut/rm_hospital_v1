<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rmmain extends Model
{
    protected $table = "rmmain";
    public $primarykey = "rmmain_id";
    public $timestamp = true;

    public function effect(){
        return $this->hasOne(Co_effect::class,'effect_code','effect_code');
    }

    public function source(){
        return $this->belongsTo(Co_source::class,'source_code','source_code');
    }

    public function level(){
        return $this->belongsTo(Co_level::class,'level_code','level_code');
    }

    public function system(){
        return $this->belongsTo(Co_system::class,'system_code','system_code');
    }

    public function specd(){
        return $this->hasOne(Co_specd::class,'specd_code','specd_code');
    }

    public function affected(){
        return $this->hasOne(Co_affected_person::class,'affected_code','rm_affected_person');
    }

    public function c_sex(){
        return $this->hasOne(Co_sex::class,'code','rm_affected_sex');
    }

    public function c_deprp(){
        return $this->hasOne(Co_dep::class,'dep_code','rmmain_deprp');
    }

    public function c_dep(){
        return $this->hasOne(Co_dep::class,'dep_code','rm_point');
    }

    public function c_clinic(){
        return $this->hasOne(Co_clinic::class,'clinic_code','clinic_code');
    }


}
