<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingsrpController extends Controller
{
    public function frmdepsrp(){
        return view('rmcode.tabcontent.srp.addcode.depsrp');
    }
}
