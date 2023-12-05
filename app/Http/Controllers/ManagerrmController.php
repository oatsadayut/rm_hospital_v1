<?php

namespace App\Http\Controllers;

use DB;
use Alert;

use App\Co_system;
use App\Co_dep;
use App\Co_affected_person;
use App\Rmmain;
use App\RmList;
use App\Rmlistall;
use App\Rmlistdep;
use App\Rmrisk;
use App\Person;
use App\User;
use App\Rmdep;
use App\Rmcommittee;
use App\Co_sex;
use App\Co_specd;
use App\Co_source;
use App\Co_committee;
use App\Co_clinic;
use App\Co_level;
use App\Co_effect;
use App\Co_risk;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ManagerrmController extends Controller
{
    // public function index()
    // {
    //     $date_first = date('Y-m-01');
    //     $date_last = date('Y-m-t');

    //     $q_person = Person::where('person_cid', Auth::user()->cid)->first();

    //     if (Auth::user()->permission == 3 || Auth::user()->permission == 4) {
    //         $q = Rmlistall::whereBetween('rmmain_daterp', [$date_first, $date_last])->get();
    //     } else if (Auth::user()->permission == 2) {
    //         $q = Rmlistdep::whereBetween('rmmain_daterp', [$date_first, $date_last])
    //             ->where('rmdepcode', 'LIKE', '%' . $q_person->dep_code . '%')
    //             ->get();
    //     } else {
    //         $q = Rmlistdep::whereBetween('rmmain_daterp', [$date_first, $date_last])
    //             ->where('rmmain_cidwr', Auth::user()->cid)
    //             ->get();
    //     }

    //     $q_dep = Co_dep::where('status', 'Y')->get();
    //     $dep = "0";

    //     $q_committee = Co_committee::where('status', 'Y')->get();
    //     $committee = "0";

    //     return view('managerrm.index', [
    //         'q' => $q,
    //         'date_first' => $date_first,
    //         'date_last' => $date_last,
    //         'dep' => $dep,
    //         'q_dep' => $q_dep,
    //         'q_committee' => $q_committee,
    //         'committee' => $committee
    //     ]);
    // }


    public function index(){
        $date_first = date('Y-m-01');
        $date_last = date('Y-m-t');

        $user_cid = Auth::user()->cid;
        $q_person = Person::where('person_cid', $user_cid)->first();
        $person_dep = $q_person->dep_code;

        $q_dep = Co_dep::where('status', 'Y')->get();
        $dep = "0";

        $q_committee = Co_committee::where('status', 'Y')->get();
        $committee = "0";

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
            AND r.`status` = 'Y'
            GROUP BY r.rmmain_id") );
        }
        else if($permission == 2){
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
            AND r.`status` = 'Y'
            GROUP BY r.rmmain_id") );
        }

        return view('managerrm.index', [
            'q' => $q,
            'date_first' => $date_first,
            'date_last' => $date_last,
            'dep' => $dep,
            'q_dep' => $q_dep,
            'q_committee' => $q_committee,
            'committee' => $committee,
            'permission' => $permission,
            'person_dep' => $person_dep
        ]);

    }

    public function getdate(Request $request){
        $date_first = $request->date_first;
        $date_last = $request->date_last;

        $dep = $request->dep;
        $committee = $request->committee;

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

        return view('managerrm.index', [
            'q' => $q,
            'date_first' => $date_first,
            'date_last' => $date_last,
            'dep' => $dep,
            'q_dep' => $q_dep,
            'committee' => $committee,
            'q_committee' => $q_committee,
            'permission' => $permission,
            'person_dep' => $person_dep
        ]);

    }

    // public function getdate(Request $request)
    // {
    //     $date_first = $request->date_first;
    //     $date_last = $request->date_last;
    //     $dep = $request->dep;
    //     $committee = $request->committee;

    //     $q_person = Person::where('person_cid', Auth::user()->cid)->first();


    //     $q_dep = Co_dep::where('status', 'Y')->get();
    //     $q_committee = Co_committee::where('status', 'Y')->get();

    //     if (Auth::user()->permission == 3 || Auth::user()->permission == 4) {
    //         if ($dep == "0") {
    //             $q = Rmlistall::whereBetween('rmmain_daterp', [$date_first, $date_last])->get();
    //         } else {
    //             $q = Rmlistdep::whereBetween('rmmain_daterp', [$date_first, $date_last])
    //                 ->where('rmdepcode', $dep)
    //                 ->get();
    //         }
    //     } else if (Auth::user()->permission == 2) {
    //         $q = Rmlistdep::whereBetween('rmmain_daterp', [$date_first, $date_last])
    //             ->where('rmdepcode', $q_person->dep_code)
    //             ->orWhere('rmmain_cidwr', Auth::user()->cid)
    //             ->get();
    //     } else {
    //         if ($dep == "0") {
    //             $q = Rmlistdep::whereBetween('rmmain_daterp', [$date_first, $date_last])
    //                 ->where('rmmain_cidwr', Auth::user()->cid)->get();
    //         } else {
    //             $q = Rmlistdep::whereBetween('rmmain_daterp', [$date_first, $date_last])
    //                 ->where('rmdepcode', 'LIKE', '%' . $dep . '%')
    //                 ->where('rmmain_cidwr', Auth::user()->cid)->get();
    //         }
    //     }


    //     return view('managerrm.index', [
    //         'q' => $q,
    //         'date_first' => $date_first,
    //         'date_last' => $date_last,
    //         'dep' => $dep,
    //         'q_dep' => $q_dep,
    //         'committee' => $committee,
    //         'q_committee' => $q_committee
    //     ]);
    // }

    public function detail($id)
    {
        $q = Rmmain::where('rmmain_id', $id)->where('status', 'Y')->first();
        $q_system = Co_system::where('status', 'Y')->get();

        $q_person_chk = Person::where('person_cid', $q->rmmain_cidrp)->where('status', 'Y')->count();
        $q_person = Person::where('person_cid', $q->rmmain_cidrp)->where('status', 'Y')->first();

        //รหัสความเสี่ยง
        $q_risk_code  = DB::table('rmrisk')
            ->join('co_risk', 'co_risk.risk_code', '=', 'rmrisk.risk_code')
            ->select('co_risk.risk_code', 'co_risk.risk_name', 'co_risk.export_code')
            ->where('rmrisk.rmmain_id', $q->rmmain_id)
            ->where('co_risk.status', 'Y')
            ->get();

        //หน่วยงานที่เกี่ยวข้อง
        $q_dep_code  = DB::table('rmdep')
            ->join('co_dep', 'co_dep.dep_code', '=', 'rmdep.dep_code')
            ->select('co_dep.dep_code', 'co_dep.dep_name', 'co_dep.place')
            ->where('rmdep.rmmain_id', $q->rmmain_id)
            ->where('co_dep.status', 'Y')
            ->get();

        //กรรมการที่เกี่ยวข้อง
        $q_committee_code  = DB::table('rmcommittee')
            ->join('co_committee', 'co_committee.committee_code', '=', 'rmcommittee.committee_code')
            ->select('co_committee.committee_code', 'co_committee.committee_name', 'co_committee.committee_export')
            ->where('rmcommittee.rmmain_id', $q->rmmain_id)
            ->where('co_committee.status', 'Y')
            ->get();

        return view('managerrm.detail', [
            'q' => $q,
            'q_committee_code' => $q_committee_code,
            'q_dep_code' => $q_dep_code,
            'q_risk_code' => $q_risk_code,
            'q_system' => $q_system,
            'q_person' => $q_person,
            'q_person_chk' => $q_person_chk
        ]);
    }

    public function review(Request $request)
    {
        $id = $request->rmmain_id;

        if (isset($_POST['btn-submit'])) {
            $q = DB::table('rmmain')
                ->where('rmmain_id', $id)
                ->update([
                    'rm_date_review' => $request->rm_date_review,
                    'rm_results_review' => $request->rm_results_review,
                    'system_code' => $request->rm_review
                ]);

            Alert::success('บันทึกข้อมูลเรียบร้อย', 'บันทึกข้อมูลทบทวนเรียบร้อย กรุณาตรวจสอบอีกครั้ง');
        } else {
            Alert::error('ไม่สามารถบันทึกข้อมูลได้', 'เกิดข้อผิดพลาด กรุณาติดต่อเจ้าหน้าที่');
        }
        return back();
    }

    public function frmupdate($id)
    {
        $qe = Rmmain::where('rmmain_id', $id)->where('status', 'Y')->first();
        $q_persons = Person::where('status', 'Y')->get();
        $q_sex = Co_sex::all();
        $q_dep = Co_dep::where('status', 'Y')->get();
        $q_clinic = Co_clinic::where('status', 'Y')->get();
        $q_level = Co_level::where('status', 'Y')->get();
        $q_committee = Co_committee::where('status', 'Y')->get();
        $q_system = Co_system::where('status', 'Y')->get();
        $q_risk = Co_risk::where('status', 'Y')->get();
        $q_specd = Co_specd::where('status', 'Y')->get();
        $q_effect = Co_effect::where('status', 'Y')->get();
        $q_source = Co_source::where('status', 'Y')->get();
        $q_affected_person = Co_affected_person::where('status', 'Y')->get();


        //รหัสความเสี่ยง
        $q_risk_code  = DB::table('rmrisk')
            ->join('co_risk', 'co_risk.risk_code', '=', 'rmrisk.risk_code')
            ->select('rmrisk.risk_code')
            ->where('rmrisk.rmmain_id', $id)
            ->where('co_risk.status', 'Y')
            ->get();
        //หน่วยงานที่เกี่ยวข้อง
        $q_dep_code  = DB::table('rmdep')
            ->join('co_dep', 'co_dep.dep_code', '=', 'rmdep.dep_code')
            ->select('rmdep.dep_code')
            ->where('rmdep.rmmain_id', $id)
            ->where('co_dep.status', 'Y')
            ->get();
        //กรรมการที่เกี่ยวข้อง
        $q_committee_code  = DB::table('rmcommittee')
            ->join('co_committee', 'co_committee.committee_code', '=', 'rmcommittee.committee_code')
            ->select('rmcommittee.committee_code')
            ->where('rmcommittee.rmmain_id', $id)
            ->where('co_committee.status', 'Y')
            ->get();

        return view('managerrm.update', [
            'qe' => $qe,
            'q_risk_code' => $q_risk_code,
            'q_dep_code' => $q_dep_code,
            'q_committee_code' => $q_committee_code,
            'q_persons' => $q_persons,
            'q_source' => $q_source,
            'q_affected_person' => $q_affected_person,
            'q_sex' => $q_sex,
            'q_effect' => $q_effect,
            'q_specd' => $q_specd,
            'q_risk' => $q_risk,
            'q_level' => $q_level,
            'q_clinic' => $q_clinic,
            'q_system' => $q_system,
            'q_committee' => $q_committee,
            'q_dep' => $q_dep
        ]);
    }

    public function updaterm(Request $request)
    {
        $request->validate([
            'rm_date' => 'required', //วันที่เกิดความเสี่ยง
            'rm_time' => 'required', //เวลาที่เกิดความเสี่ยง
            'rm_reporter' => 'required', //ผู้รายงาน

            'rm_title' => 'required', //หัวข้อความเสี่ยง
            'rm_detail' => 'required', //รายละเอียดความเสี่ยง
            'source_code' => 'required', //แหล่งที่มา
            'rm_violence_level' => 'required', //ระดับความรุนแรง
            'rm_effect' => 'required', //ผลกระทบ

        ]);
        if (isset($_POST['btn-submit'])) {

            $this->update_risk_code($request->rmmain_id, $request);
            $this->update_rm_dep($request->rmmain_id, $request);
            $this->update_rm_committee($request->rmmain_id, $request);

            $cidrp =  $request->rm_reporter;
            $person = Person::where('person_cid', $cidrp)->first();
            if ($person != '' || $person != null) {
                $dep_person_rp = $person->dep_code;
            } else {
                $dep_person_rp = 32;
            }

            $q = DB::table('rmmain')
                ->where('rmmain_id', $request->rmmain_id)
                ->update([
                    'source_code' => $request->source_code, //แหล่งข้อมูล
                    'rmmain_dateon' => $request->rm_date, //วันที่เกิดเหตุ
                    'rmmain_time' => $request->rm_time, //เวลาเกิดเหตุการณ์
                    'rm_part_time' => $request->part_show_hidden, //ช่วงเวลา
                    'rm_point' => $request->rm_point, //สถานที่เกิดเหตุ
                    'rmmain_topic' => $request->rm_title, //หัวข้อเหตุการณ์
                    'rmmain_detail' => $request->rm_detail, //รายละเอียดเหตุการณ์
                    'rm_affected_person' => $request->rm_affected_person, //ผู้ได้รับผลกระทบ
                    'rm_affected_sex' => $request->rm_affected_sex, //เพศ
                    'rm_affected_age' => $request->rm_affected_age, //อายุ
                    'effect_code' => $request->rm_effect, //ผลกระทบ
                    'specd_code' => $request->rm_disease, //โรคเฉพาะ
                    'clinic_code' => $request->rm_risk_type, //ชนิดความเสี่ยง
                    'level_code' => $request->rm_violence_level, //ระดับความรุนแรง
                    'rm_date_review' => $request->rm_date_review, //วันที่ทบทวน
                    'rm_results_review' => $request->rm_results_review, //ผลการทบทวน
                    'rmmain_cidrp' => $request->rm_reporter, //ผู้เขียนรายงาน
                    'rmmain_deprp' => $dep_person_rp, //หน่วยงานของผู้รายงาน

                ]);
            Alert::success('แก้ไขข้อมูลเรียบร้อย', 'แก้ไขข้อมูลเรียบร้อย กรุณาตรวจสอบความถูกต้องอีกครั้ง');
        } else {
            Alert::error('ไม่สามารถทำรายการได้', 'กรุณาติดต่อเจ้าหน้าที่ผู้ดูแลระบบ');
        }
        return back();
    }

    public function update_risk_code($rmmain_id, $request)
    {
        $e = Rmrisk::where('rmmain_id', $rmmain_id);
        $e->delete();
        foreach ($request->rm_risk_code as $item) {
            $q = new Rmrisk;
            $q->risk_code = $item; //รหัสความเสี่ยง
            $q->rmmain_id = $rmmain_id; //id ความเสี่ยง (ตาราง rmmain)
            $q->status = "Y"; //สถานะ
            $q->save();
        };
    }

    public function update_rm_dep($rmmain_id, $request)
    {
        $e = Rmdep::where('rmmain_id', $rmmain_id);
        $e->delete();
        foreach ($request->rm_dep as $item) {
            $q = new Rmdep;
            $q->dep_code = $item; //รหัสหน่วยงาน
            $q->rmmain_id = $rmmain_id; //id ความเสี่ยง (ตาราง rmmain)
            $q->status = "Y"; //สถานะ
            $q->save();
        };
    }

    public function update_rm_committee($rmmain_id, $request)
    {
        $e = Rmcommittee::where('rmmain_id', $rmmain_id);
        $e->delete();
        foreach ($request->rm_committee as $item) {
            $q = new Rmcommittee;
            $q->committee_code = $item; //รหัสกรรมการความเสี่ยง
            $q->rmmain_id = $rmmain_id; //id ความเสี่ยง (ตาราง rmmain)
            $q->status = "Y"; //สถานะ
            $q->save();
        };
    }
}
