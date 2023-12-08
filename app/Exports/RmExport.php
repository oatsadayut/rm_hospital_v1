<?php

namespace App\Exports;

use DB;
use App\Co_dep;
use App\Co_committee;
use App\Person;
use Illuminate\Support\Facades\Auth;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class RmExport implements FromView
{
    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function datestart(string $dateStart)
    {
        $this->dateStart = $dateStart;

        return $this;
    }

    public function dateend(string $dateEnd)
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }

    public function dep(string $dep)
    {
        $this->dep = $dep;

        return $this;
    }

    public function committee(string $commitTee)
    {
        $this->commitTee = $commitTee;

        return $this;
    }

    public function view(): View
    {
        $date_first = $this->dateStart;
        $date_last = $this->dateEnd;
        $dep = $this->dep;
        $committee = $this->commitTee;

        $user_cid = Auth::user()->cid;
        $q_person = Person::where('person_cid', $user_cid)->first();
        $person_dep = $q_person->dep_code;

        $q_dep = Co_dep::where('status', 'Y')->get();
        $q_committee = Co_committee::where('status', 'Y')->get();

        $qdep = ($dep == "0" ? "" : "AND rmd.dep_code = $dep");
        $qcommittee = ($committee == "0" ? "" : "AND rcm.committee_code = $committee");

        $permission = Auth::user()->permission;

        if($permission == 3 || $permission == 4){
            $q = DB::select( DB::raw("
                                SELECT 
                                `r`.`rmmain_id` AS `rmmain_id`,
                                `r`.`rmmain_dateon` AS `rmmain_dateon`,
                                `r`.`rmmain_daterp` AS `rmmain_daterp`,
                                `r`.`rmmain_time` AS `rmmain_time`,
                                `r`.`rmmain_topic` AS `rmmain_topic`,
                                `r`.`rmmain_detail` AS `rmmain_detail`,
                                (SELECT GROUP_CONCAT(rd.dep_code) FROM rmdep rd WHERE rd.rmmain_id = r.rmmain_id AND rd.`status` = 'Y') AS rmdepcode,
                                (SELECT GROUP_CONCAT(cdep.dep_name) FROM rmdep rd2 INNER JOIN co_dep cdep ON rd2.dep_code = cdep.dep_code WHERE rd2.rmmain_id = r.rmmain_id AND rd2.`status` = 'Y') AS rmdepname,
                                (SELECT GROUP_CONCAT(rmt.committee_code) FROM rmcommittee rmt WHERE rmt.rmmain_id = r.rmmain_id AND rmt.`status` = 'Y') AS rmcommitteecode,
                                (SELECT GROUP_CONCAT(cmt.committee_name) FROM rmcommittee rmt2 INNER JOIN co_committee cmt ON rmt2.committee_code = cmt.committee_code WHERE rmt2.rmmain_id = r.rmmain_id AND rmt2.`status` = 'Y') AS rmcommitteename,
                                `r`.`level_code` AS `level_code`,
                                `cl`.`level_name` AS `rmlevel`,
                                `cc`.`clinic_name` AS `clinic_name`,
                                concat(`p`.`person_fname`,' ',`p`.`person_lname`) AS `fullname`,
                                `r`.`rmmain_cidrp` AS `rmmain_cidrp`,
                                `r`.`system_code` AS `system_code`,
                                `cs`.`system_name` AS `system_name`,
                                `r`.`created_at` AS `created_at`,
                                `r`.`status` AS `status` 
                                FROM rmmain r
                                INNER JOIN rmdep rmd ON r.rmmain_id = rmd.rmmain_id AND rmd.`status` = 'Y'
                                INNER JOIN rmcommittee rcm ON r.rmmain_id = rcm.rmmain_id AND rcm.`status` = 'Y'
                                LEFT OUTER JOIN co_level cl ON r.level_code = cl.level_code
                                LEFT OUTER JOIN co_clinic cc ON r.clinic_code = cc.clinic_code
                                LEFT OUTER JOIN person p ON r.rmmain_cidrp = p.person_cid
                                LEFT OUTER JOIN co_system cs ON r.system_code = cs.system_code
                                WHERE r.rmmain_daterp BETWEEN '$date_first' AND '$date_last'
                                $qdep
                                $qcommittee
                                AND r.`status` = 'Y'
                                GROUP BY r.rmmain_id") );
        }else if($permission == 2){
            $q = DB::select( DB::raw("
                                SELECT 
                                `r`.`rmmain_id` AS `rmmain_id`,
                                `r`.`rmmain_dateon` AS `rmmain_dateon`,
                                `r`.`rmmain_daterp` AS `rmmain_daterp`,
                                `r`.`rmmain_time` AS `rmmain_time`,
                                `r`.`rmmain_topic` AS `rmmain_topic`,
                                `r`.`rmmain_detail` AS `rmmain_detail`,
                                (SELECT GROUP_CONCAT(rd.dep_code) FROM rmdep rd WHERE rd.rmmain_id = r.rmmain_id AND rd.`status` = 'Y') AS rmdepcode,
                                (SELECT GROUP_CONCAT(cdep.dep_name) FROM rmdep rd2 INNER JOIN co_dep cdep ON rd2.dep_code = cdep.dep_code WHERE rd2.rmmain_id = r.rmmain_id AND rd2.`status` = 'Y') AS rmdepname,
                                (SELECT GROUP_CONCAT(rmt.committee_code) FROM rmcommittee rmt WHERE rmt.rmmain_id = r.rmmain_id AND rmt.`status` = 'Y') AS rmcommitteecode,
                                (SELECT GROUP_CONCAT(cmt.committee_name) FROM rmcommittee rmt2 INNER JOIN co_committee cmt ON rmt2.committee_code = cmt.committee_code WHERE rmt2.rmmain_id = r.rmmain_id AND rmt2.`status` = 'Y') AS rmcommitteename,
                                `r`.`level_code` AS `level_code`,
                                `cl`.`level_name` AS `rmlevel`,
                                `cc`.`clinic_name` AS `clinic_name`,
                                concat(`p`.`person_fname`,' ',`p`.`person_lname`) AS `fullname`,
                                `r`.`rmmain_cidrp` AS `rmmain_cidrp`,
                                `r`.`rmmain_cidwr` AS `rmmain_cidwr`,
                                `r`.`system_code` AS `system_code`,
                                `cs`.`system_name` AS `system_name`,
                                `r`.`created_at` AS `created_at`,
                                `r`.`status` AS `status` 
                                FROM rmmain r
                                INNER JOIN rmdep rmd ON r.rmmain_id = rmd.rmmain_id AND rmd.`status` = 'Y'
                                INNER JOIN rmcommittee rcm ON r.rmmain_id = rcm.rmmain_id AND rcm.`status` = 'Y'
                                LEFT OUTER JOIN co_level cl ON r.level_code = cl.level_code
                                LEFT OUTER JOIN co_clinic cc ON r.clinic_code = cc.clinic_code
                                LEFT OUTER JOIN person p ON r.rmmain_cidrp = p.person_cid
                                LEFT OUTER JOIN co_system cs ON r.system_code = cs.system_code
                                WHERE r.rmmain_daterp BETWEEN '$date_first' AND '$date_last'
                                AND rmd.dep_code = '$person_dep'
                                $qcommittee
                                AND r.`status` = 'Y'
                                GROUP BY r.rmmain_id") );
        }
        else{
            $q = DB::select( DB::raw("
                                SELECT 
                                `r`.`rmmain_id` AS `rmmain_id`,
                                `r`.`rmmain_dateon` AS `rmmain_dateon`,
                                `r`.`rmmain_daterp` AS `rmmain_daterp`,
                                `r`.`rmmain_time` AS `rmmain_time`,
                                `r`.`rmmain_topic` AS `rmmain_topic`,
                                `r`.`rmmain_detail` AS `rmmain_detail`,
                                (SELECT GROUP_CONCAT(rd.dep_code) FROM rmdep rd WHERE rd.rmmain_id = r.rmmain_id AND rd.`status` = 'Y') AS rmdepcode,
                                (SELECT GROUP_CONCAT(cdep.dep_name) FROM rmdep rd2 INNER JOIN co_dep cdep ON rd2.dep_code = cdep.dep_code WHERE rd2.rmmain_id = r.rmmain_id AND rd2.`status` = 'Y') AS rmdepname,
                                (SELECT GROUP_CONCAT(rmt.committee_code) FROM rmcommittee rmt WHERE rmt.rmmain_id = r.rmmain_id AND rmt.`status` = 'Y') AS rmcommitteecode,
                                (SELECT GROUP_CONCAT(cmt.committee_name) FROM rmcommittee rmt2 INNER JOIN co_committee cmt ON rmt2.committee_code = cmt.committee_code WHERE rmt2.rmmain_id = r.rmmain_id AND rmt2.`status` = 'Y') AS rmcommitteename,
                                `r`.`level_code` AS `level_code`,
                                `cl`.`level_name` AS `rmlevel`,
                                `cc`.`clinic_name` AS `clinic_name`,
                                concat(`p`.`person_fname`,' ',`p`.`person_lname`) AS `fullname`,
                                `r`.`rmmain_cidrp` AS `rmmain_cidrp`,
                                `r`.`rmmain_cidwr` AS `rmmain_cidwr`,
                                `r`.`system_code` AS `system_code`,
                                `cs`.`system_name` AS `system_name`,
                                `r`.`created_at` AS `created_at`,
                                `r`.`status` AS `status` 
                                FROM rmmain r
                                INNER JOIN rmdep rmd ON r.rmmain_id = rmd.rmmain_id AND rmd.`status` = 'Y'
                                INNER JOIN rmcommittee rcm ON r.rmmain_id = rcm.rmmain_id AND rcm.`status` = 'Y'
                                LEFT OUTER JOIN co_level cl ON r.level_code = cl.level_code
                                LEFT OUTER JOIN co_clinic cc ON r.clinic_code = cc.clinic_code
                                LEFT OUTER JOIN person p ON r.rmmain_cidrp = p.person_cid
                                LEFT OUTER JOIN co_system cs ON r.system_code = cs.system_code
                                WHERE r.rmmain_daterp BETWEEN '$date_first' AND '$date_last'
                                AND r.rmmain_cidwr = '$user_cid'
                                $qdep
                                $qcommittee
                                AND r.`status` = 'Y'
                                GROUP BY r.rmmain_id") );
        }

        return view('excelexport.riskexport', [
            'q' => $q,
            'date_first' => $date_first,
            'date_last' => $date_last
        ]);
    }
}
