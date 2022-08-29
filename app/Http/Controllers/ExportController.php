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
        return Excel::download(new RmExport($dateStart,$dateEnd,$dep), 'report_export.xlsx');
    }

    public function rmexport(Request $request)
    {
        $dateStart = $request->dateStart;
        $dateEnd = $request->dateEnd;
        $dep = $request->dep;
        return (new RmExport)->datestart($dateStart)->dateend($dateEnd)->dep($dep)->download("rick_export.xlsx");
    }
}
