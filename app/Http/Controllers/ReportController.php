<?php

namespace App\Http\Controllers;

use DB;
use App\Co_dep;
use App\Co_committee;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(){
        $dep = Co_dep::where('status','Y')->get();
        $committee = Co_committee::where('status','Y')->get();

        return view('report.index',['dep'=>$dep,'committee'=>$committee]);
    }

    public function view_report_getpointdep(){
        return view('report.listreport.getpointrm');
    }

    //api
    public function Getdep(){
        $getdep = DB::table('rmmain')
            ->join('co_dep', 'rmmain.rm_point', '=', 'co_dep.dep_code')
            ->select(DB::raw('co_dep.dep_name,count(*) as count'))
            ->where('rmmain.rm_point', '<>', ' ')
            ->groupBy('rmmain.rm_point')
            ->get();

            return response()->json($getdep);
    }
}
