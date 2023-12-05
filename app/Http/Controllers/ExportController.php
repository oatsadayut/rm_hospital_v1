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
        $committee = $request->committee;
        return Excel::download(new RmExport($dateStart,$dateEnd,$dep,$committee), 'report_export_'+ $dateStart + $dateEnd + $dep + $committee +'.xlsx');
    }

    public function rmexport(Request $request)
    {
        $dateStart = $request->dateStart;
        $dateEnd = $request->dateEnd;
        $dep = $request->dep;
        $committee = $request->committee;
        return (new RmExport)->datestart($dateStart)->dateend($dateEnd)->dep($dep)->committee($committee)->download("rick_export_$dateStart$dateEnd$dep$committee.xlsx");
    }
}
