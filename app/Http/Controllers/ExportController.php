<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Exports\RmExport;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function rmindex()
    {
        $dateStart = $request->dateStart;
        $dateEnd = $request->dateEnd;
        $dep = $request->dep;
        $commitTee = $request->commitTee;
        return Excel::download(new RmExport($dateStart,$dateEnd,$dep,$commitTee), 'report_export_'+ $dateStart +"-"+ $dateEnd +"-"+ $dep + $commitTee +'.xlsx');
    }

    public function rmexport(Request $request)
    {
        $dateStart = $request->dateStart;
        $dateEnd = $request->dateEnd;
        $dep = $request->dep;
        $commitTee = $request->commitTee;
        return (new RmExport)->datestart($dateStart)->dateend($dateEnd)->dep($dep)->committee($commitTee)->download("rick_export_$dateStart-$dateEnd-$dep$commitTee.xlsx");
    }
}
