<?php

namespace App\Http\Controllers;

use DB;
use PDF;
use App\Rmmain;
use App\Person;
use App\Co_dep;
use App\Co_committee;
use App\Rmcommittee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PrintrmController extends Controller
{
    //ใบความเสี่ยง
    public function printrm($id){
        $d_t = date('H:i:s');

        $d_n = date('d/m/Y');

        $q = Rmmain::where('rmmain_id',$id)->first();

        //ผู้ปริ้นรายงาน
        $q_user = Person::where('person_id',Auth::user()->person_id)->first();

        //ผู้รายงาน
        $qrp_c = Person::where('person_cid',$q->rmmain_cidrp)->count();
        $qrp = Person::where('person_cid',$q->rmmain_cidrp)->first();

        //รหัสความเสี่ยง
        $q_risk_code  = DB::table('rmrisk')
            ->join('co_risk', 'co_risk.risk_code', '=', 'rmrisk.risk_code')
            ->select('co_risk.risk_code', 'co_risk.risk_name','co_risk.export_code')
            ->where('rmrisk.rmmain_id',$q->rmmain_id)
            ->where('co_risk.status','Y')
            ->get();

        //หน่วยงานที่เกี่ยวข้อง
        $q_dep_code  = DB::table('rmdep')
            ->join('co_dep', 'co_dep.dep_code', '=', 'rmdep.dep_code')
            ->select('co_dep.dep_code', 'co_dep.dep_name','co_dep.place')
            ->where('rmdep.rmmain_id',$q->rmmain_id)
            ->where('co_dep.status','Y')
            ->get();

        //กรรมการที่เกี่ยวข้อง
        $q_committee_code  = DB::table('rmcommittee')
            ->join('co_committee', 'co_committee.committee_code', '=', 'rmcommittee.committee_code')
            ->select('co_committee.committee_code', 'co_committee.committee_name','co_committee.committee_export')
            ->where('rmcommittee.rmmain_id',$q->rmmain_id)
            ->where('co_committee.status','Y')
            ->get();

        $pdf = PDF::loadView('pdf.rmprint',[
            'q'=>$q,
            'qrp'=>$qrp,
            'qrp_c'=>$qrp_c,
            'q_risk_code'=>$q_risk_code,
            'q_dep_code'=>$q_dep_code,
            'q_committee_code'=>$q_committee_code,
            'q_user'=>$q_user,
            'd_n'=>$d_n,
            'd_t'=>$d_t
        ]);
        return @$pdf->stream();

    }

    //รายงานภาพรวมระดับ โรงพยาบาล
    public function report_all_summary_rm(Request $request){
        $q_user = Person::where('person_id',Auth::user()->person_id)->first(); //คนที่พิมพ์
        $d_t = date('H:i:s'); //เวลาที่พิมพ์
        $d_n = date('d/m/Y'); //วันที่พิมพ์

        $date_start = $request->date_start; //วันเริ่มต้นที่เลือก
        $date_end = $request->date_end; //สิ้นสุดวันที่เลือก

        $q_rm = Rmmain::whereBetween('rmmain_dateon', [$date_start, $date_end])->where('status','Y')->count();
        $q_rm_check = Rmmain::where('system_code','2')->whereBetween('rmmain_dateon', [$date_start, $date_end])->where('status','Y')->count();
        $q_rm_uncheck = Rmmain::where('system_code','1')->whereBetween('rmmain_dateon', [$date_start, $date_end])->where('status','Y')->count();

        $q_rm_time_1 = Rmmain::where('rm_part_time','เช้า')->whereBetween('rmmain_dateon', [$date_start, $date_end])->where('status','Y')->count();
        $q_rm_time_2 = Rmmain::where('rm_part_time','บ่าย')->whereBetween('rmmain_dateon', [$date_start, $date_end])->where('status','Y')->count();
        $q_rm_time_3 = Rmmain::where('rm_part_time','ดึก')->whereBetween('rmmain_dateon', [$date_start, $date_end])->where('status','Y')->count();

        $q_affected_1 = Rmmain::where('rm_affected_person','1')->whereBetween('rmmain_dateon', [$date_start, $date_end])->where('status','Y')->count();
        $q_affected_2 = Rmmain::where('rm_affected_person','2')->whereBetween('rmmain_dateon', [$date_start, $date_end])->where('status','Y')->count();
        $q_affected_3 = Rmmain::where('rm_affected_person','3')->whereBetween('rmmain_dateon', [$date_start, $date_end])->where('status','Y')->count();

        $q_effect_1 = Rmmain::where('effect_code','1')->whereBetween('rmmain_dateon', [$date_start, $date_end])->where('status','Y')->count();
        $q_effect_2 = Rmmain::where('effect_code','2')->whereBetween('rmmain_dateon', [$date_start, $date_end])->where('status','Y')->count();
        $q_effect_3 = Rmmain::where('effect_code','3')->whereBetween('rmmain_dateon', [$date_start, $date_end])->where('status','Y')->count();
        $q_effect_4 = Rmmain::where('effect_code','4')->whereBetween('rmmain_dateon', [$date_start, $date_end])->where('status','Y')->count();
        $q_effect_5 = Rmmain::where('effect_code','5')->whereBetween('rmmain_dateon', [$date_start, $date_end])->where('status','Y')->count();
        $q_effect_6 = Rmmain::where('effect_code','6')->whereBetween('rmmain_dateon', [$date_start, $date_end])->where('status','Y')->count();

        $q_committee_PCT  = DB::table('rmcommittee')->join('rmmain', 'rmmain.rmmain_id', '=', 'rmcommittee.rmmain_id')->whereBetween('rmmain.rmmain_dateon', [$date_start, $date_end])->where('rmcommittee.committee_code','1')->where('rmmain.status','Y')->count();
        $q_committee_PTC  = DB::table('rmcommittee')->join('rmmain', 'rmmain.rmmain_id', '=', 'rmcommittee.rmmain_id')->whereBetween('rmmain.rmmain_dateon', [$date_start, $date_end])->where('rmcommittee.committee_code','2')->where('rmmain.status','Y')->count();
        $q_committee_IC  = DB::table('rmcommittee')->join('rmmain', 'rmmain.rmmain_id', '=', 'rmcommittee.rmmain_id')->whereBetween('rmmain.rmmain_dateon', [$date_start, $date_end])->where('rmcommittee.committee_code','3')->where('rmmain.status','Y')->count();
        $q_committee_ENV  = DB::table('rmcommittee')->join('rmmain', 'rmmain.rmmain_id', '=', 'rmcommittee.rmmain_id')->whereBetween('rmmain.rmmain_dateon', [$date_start, $date_end])->where('rmcommittee.committee_code','4')->where('rmmain.status','Y')->count();
        $q_committee_EQU  = DB::table('rmcommittee')->join('rmmain', 'rmmain.rmmain_id', '=', 'rmcommittee.rmmain_id')->whereBetween('rmmain.rmmain_dateon', [$date_start, $date_end])->where('rmcommittee.committee_code','5')->where('rmmain.status','Y')->count();
        $q_committee_IM  = DB::table('rmcommittee')->join('rmmain', 'rmmain.rmmain_id', '=', 'rmcommittee.rmmain_id')->whereBetween('rmmain.rmmain_dateon', [$date_start, $date_end])->where('rmcommittee.committee_code','6')->where('rmmain.status','Y')->count();
        $q_committee_HRD  = DB::table('rmcommittee')->join('rmmain', 'rmmain.rmmain_id', '=', 'rmcommittee.rmmain_id')->whereBetween('rmmain.rmmain_dateon', [$date_start, $date_end])->where('rmcommittee.committee_code','7')->where('rmmain.status','Y')->count();
        $q_committee_RM  = DB::table('rmcommittee')->join('rmmain', 'rmmain.rmmain_id', '=', 'rmcommittee.rmmain_id')->whereBetween('rmmain.rmmain_dateon', [$date_start, $date_end])->where('rmcommittee.committee_code','8')->where('rmmain.status','Y')->count();
        $q_committee_null  = DB::table('rmcommittee')->join('rmmain', 'rmmain.rmmain_id', '=', 'rmcommittee.rmmain_id')->whereBetween('rmmain.rmmain_dateon', [$date_start, $date_end])->where('rmcommittee.committee_code','9')->where('rmmain.status','Y')->count();

        $q_clinic_1 = Rmmain::where('clinic_code','1')->whereBetween('rmmain_dateon', [$date_start, $date_end])->where('status','Y')->count();
        $q_clinic_2 = Rmmain::where('clinic_code','2')->whereBetween('rmmain_dateon', [$date_start, $date_end])->where('status','Y')->count();
        $q_clinic_3 = Rmmain::where('clinic_code','3')->whereBetween('rmmain_dateon', [$date_start, $date_end])->where('status','Y')->count();


        $q_source_1 = Rmmain::where('source_code','1')->whereBetween('rmmain_dateon', [$date_start, $date_end])->where('status','Y')->count();
        $q_source_2 = Rmmain::where('source_code','2')->whereBetween('rmmain_dateon', [$date_start, $date_end])->where('status','Y')->count();
        $q_source_3 = Rmmain::where('source_code','3')->whereBetween('rmmain_dateon', [$date_start, $date_end])->where('status','Y')->count();
        $q_source_4 = Rmmain::where('source_code','4')->whereBetween('rmmain_dateon', [$date_start, $date_end])->where('status','Y')->count();
        $q_source_5 = Rmmain::where('source_code','5')->whereBetween('rmmain_dateon', [$date_start, $date_end])->where('status','Y')->count();
        $q_source_6 = Rmmain::where('source_code','6')->whereBetween('rmmain_dateon', [$date_start, $date_end])->where('status','Y')->count();
        $q_source_7 = Rmmain::where('source_code','7')->whereBetween('rmmain_dateon', [$date_start, $date_end])->where('status','Y')->count();
        $q_source_8 = Rmmain::where('source_code','8')->whereBetween('rmmain_dateon', [$date_start, $date_end])->where('status','Y')->count();

        $q_level_1 = Rmmain::where('level_code','1')->whereBetween('rmmain_dateon', [$date_start, $date_end])->where('status','Y')->count();
        $q_level_2 = Rmmain::where('level_code','2')->whereBetween('rmmain_dateon', [$date_start, $date_end])->where('status','Y')->count();
        $q_level_3 = Rmmain::where('level_code','3')->whereBetween('rmmain_dateon', [$date_start, $date_end])->where('status','Y')->count();
        $q_level_4 = Rmmain::where('level_code','4')->whereBetween('rmmain_dateon', [$date_start, $date_end])->where('status','Y')->count();
        $q_level_5 = Rmmain::where('level_code','5')->whereBetween('rmmain_dateon', [$date_start, $date_end])->where('status','Y')->count();
        $q_level_6 = Rmmain::where('level_code','6')->whereBetween('rmmain_dateon', [$date_start, $date_end])->where('status','Y')->count();
        $q_level_7 = Rmmain::where('level_code','7')->whereBetween('rmmain_dateon', [$date_start, $date_end])->where('status','Y')->count();
        $q_level_8 = Rmmain::where('level_code','8')->whereBetween('rmmain_dateon', [$date_start, $date_end])->where('status','Y')->count();
        $q_level_9 = Rmmain::where('level_code','9')->whereBetween('rmmain_dateon', [$date_start, $date_end])->where('status','Y')->count();
        $q_level_10 = Rmmain::where('level_code','10')->whereBetween('rmmain_dateon', [$date_start, $date_end])->where('status','Y')->count();
        $q_level_11 = Rmmain::where('level_code','11')->whereBetween('rmmain_dateon', [$date_start, $date_end])->where('status','Y')->count();
        $q_level_12 = Rmmain::where('level_code','12')->whereBetween('rmmain_dateon', [$date_start, $date_end])->where('status','Y')->count();
        $q_level_13 = Rmmain::where('level_code','13')->whereBetween('rmmain_dateon', [$date_start, $date_end])->where('status','Y')->count();
        $q_level_14 = Rmmain::where('level_code','14')->whereBetween('rmmain_dateon', [$date_start, $date_end])->where('status','Y')->count();
        $q_level_16 = Rmmain::where('level_code','16')->whereBetween('rmmain_dateon', [$date_start, $date_end])->where('status','Y')->count();
        $q_level_17 = Rmmain::where('level_code','17')->whereBetween('rmmain_dateon', [$date_start, $date_end])->where('status','Y')->count();
        $q_level_18 = Rmmain::where('level_code','18')->whereBetween('rmmain_dateon', [$date_start, $date_end])->where('status','Y')->count();
        $q_level_19 = Rmmain::where('level_code','19')->whereBetween('rmmain_dateon', [$date_start, $date_end])->where('status','Y')->count();


        $q_top5_riskcode_1  = DB::table('rmrisk')
        ->leftJoin('rmmain', 'rmrisk.rmmain_id', '=', 'rmmain.rmmain_id')
        ->leftJoin('co_risk', 'rmrisk.risk_code', '=', 'co_risk.risk_code')
        ->select(DB::raw('co_risk.risk_name,COUNT(rmrisk.risk_code) AS count'))
        ->whereBetween('rmmain.rmmain_dateon', [$date_start, $date_end])
        ->where('rmmain.clinic_code','1')
        ->where('rmmain.status','Y')
        ->groupBy('rmrisk.risk_code')
        ->orderBy('count', 'DESC')
        ->limit(5)
        ->get();

        $q_top5_riskcode_2  = DB::table('rmrisk')
        ->leftJoin('rmmain', 'rmrisk.rmmain_id', '=', 'rmmain.rmmain_id')
        ->leftJoin('co_risk', 'rmrisk.risk_code', '=', 'co_risk.risk_code')
        ->select(DB::raw('co_risk.risk_name,COUNT(rmrisk.risk_code) AS count'))
        ->whereBetween('rmmain.rmmain_dateon', [$date_start, $date_end])
        ->where('rmmain.clinic_code','2')
        ->where('rmmain.status','Y')
        ->groupBy('rmrisk.risk_code')
        ->orderBy('count', 'DESC')
        ->limit(5)
        ->get();

        $q_person_report  = DB::table('rmmain')
        ->leftJoin('person', 'rmmain.rmmain_cidrp', '=', 'person.person_cid')
        ->leftJoin('co_dep', 'person.dep_code', '=', 'co_dep.dep_code')
        ->select(DB::raw('co_dep.dep_name,co_dep.dep_ename,COUNT(person.dep_code) AS count'))
        ->whereBetween('rmmain.rmmain_dateon', [$date_start, $date_end])
        ->where('rmmain.status','Y')
        ->where('person.status','Y')
        ->where('rmmain.rmmain_cidrp','<>','')
        ->groupBy('person.dep_code')
        ->orderBy('count', 'DESC')
        ->get();

        $pdf = PDF::loadView('report.pdf.report_all_summary_rm',[
            'date_start'=>$date_start, //วันเริ่มต้น
            'date_end'=>$date_end, //วันเริ่มต้น
            'd_n'=>$d_n, //วันปริ้น
            'd_t'=>$d_t, //เวลาปริ้น
            'q_user'=>$q_user, //ผู้ปริ้น

            'q_rm'=>$q_rm, //ความเสี่ยงทั้งหมด
            'q_rm_check'=>$q_rm_check, //ความเสี่ยงทั้งหมดที่ทบทวนแล้ว
            'q_rm_uncheck'=>$q_rm_uncheck, //ความเสี่ยงทั้งหมดที่ยังไม่ทบทวน
            'q_rm_time_1'=>$q_rm_time_1, //ความเสี่ยงเวรเช้า
            'q_rm_time_2'=>$q_rm_time_2, //ความเสี่ยงเวรบ่าย
            'q_rm_time_3'=>$q_rm_time_3, //ความเสี่ยงเวรดึก
            'q_affected_1'=>$q_affected_1, //ผู้ได้รับผลกระทบ บุคคล
            'q_affected_2'=>$q_affected_2, //ผู้ได้รับผลกระทบ กลุ่มบุคคล
            'q_affected_3'=>$q_affected_3, //ผู้ได้รับผลกระทบ หน่วยงาน
            'q_effect_1'=>$q_effect_1, //ผลกระทบ AE Error
            'q_effect_2'=>$q_effect_2, //ผลกระทบ AE
            'q_effect_3'=>$q_effect_3, //ผลกระทบ Error
            'q_effect_4'=>$q_effect_4, //ผลกระทบ Error Alert*
            'q_effect_5'=>$q_effect_5, //ผลกระทบ Sentinel Event*
            'q_effect_6'=>$q_effect_6, //ผลกระทบ ที่ไม่ระบุ

            'q_committee_PCT'=>$q_committee_PCT, //กรรมการที่เกี่ยวข้อง PCT
            'q_committee_PTC'=>$q_committee_PTC, //กรรมการที่เกี่ยวข้อง PTC
            'q_committee_IC'=>$q_committee_IC, //กรรมการที่เกี่ยวข้อง IC
            'q_committee_ENV'=>$q_committee_ENV, //กรรมการที่เกี่ยวข้อง ENV
            'q_committee_EQU'=>$q_committee_EQU, //กรรมการที่เกี่ยวข้อง EQU
            'q_committee_IM'=>$q_committee_IM, //กรรมการที่เกี่ยวข้อง IM
            'q_committee_HRD'=>$q_committee_HRD, //กรรมการที่เกี่ยวข้อง HRD
            'q_committee_RM'=>$q_committee_RM, //กรรมการที่เกี่ยวข้อง RM
            'q_committee_null'=>$q_committee_null, //กรรมการที่เกี่ยวข้อง ไม่ระบุ

            'q_clinic_1'=>$q_clinic_1, //clinical risk
            'q_clinic_2'=>$q_clinic_2, //non clinical risk
            'q_clinic_3'=>$q_clinic_3, //ไม่ระบุ clinical

            'q_source_1'=>$q_source_1, //แหล่งที่มาความเสี่ยง ทะเบียนความบันทึกความเสี่ยง
            'q_source_2'=>$q_source_2, //แหล่งที่มาความเสี่ยง ข้อร้องเรียน ข้อคิดเห็น คำชื่นชม
            'q_source_3'=>$q_source_3, //แหล่งที่มาความเสี่ยง ทบทวน 12 กิจกรรม
            'q_source_4'=>$q_source_4, //แหล่งที่มาความเสี่ยง ทบทวน trigger tool
            'q_source_5'=>$q_source_5, //แหล่งที่มาความเสี่ยง เหตุการณ์สำคัญ
            'q_source_6'=>$q_source_6, //แหล่งที่มาความเสี่ยง Round
            'q_source_7'=>$q_source_7, //แหล่งที่มาความเสี่ยง ใบซ่อมบำรุง
            'q_source_8'=>$q_source_8, //แหล่งที่มาความเสี่ยง ทบทวน Re-Admit 28 วัน

            'q_top5_riskcode_1'=>$q_top5_riskcode_1, //TOP 5 รหัสความเสี่ยง clinic
            'q_top5_riskcode_2'=>$q_top5_riskcode_2, //TOP 5 รหัสความเสี่ยง Non clinic

            'q_person_report'=>$q_person_report, //หน่วยงานที่รายงานความเสี่ยง
            'q_level_1'=>$q_level_1, //ระดับ A
            'q_level_2'=>$q_level_2, //ระดับ B
            'q_level_3'=>$q_level_3, //ระดับ C
            'q_level_4'=>$q_level_4, //ระดับ D
            'q_level_5'=>$q_level_5, //ระดับ E
            'q_level_6'=>$q_level_6, //ระดับ F
            'q_level_7'=>$q_level_7, //ระดับ G
            'q_level_8'=>$q_level_8, //ระดับ H
            'q_level_9'=>$q_level_9, //ระดับ I
            'q_level_10'=>$q_level_10, //ระดับ 1 Non Clinic  Near Miss
            'q_level_11'=>$q_level_11, //ระดับ 2 Non Clinic Miss  น้อย 10,000
            'q_level_12'=>$q_level_12, //ระดับ 3 Non Clinic Miss 10,000 ถึง 100,000
            'q_level_13'=>$q_level_13, //ระดับ 4 Non Clinic Miss มากกว่า 100,000
            'q_level_14'=>$q_level_14, //ไม่ระบุ
            'q_level_16'=>$q_level_16, //ระดับ 1 ข้อคิดเห็น/ข้อเสนอแนะ
            'q_level_17'=>$q_level_17, //ระดับ 2 ข้อร้องเรียนเรื่องเล็ก
            'q_level_18'=>$q_level_18, //ระดับ 3 ข้อร้องเรียนเรื่องใหญ่
            'q_level_19'=>$q_level_19, //ระดับ 4 การฟ้องร้อง


        ]);
        return @$pdf->stream();
    }

    //รายงานภาพรวมระดับ หน่วยงาน
    public function report_dep_summary_rm(Request $request){
        $q_dep = Co_dep::where('dep_code',$request->dep)->first();
        $q_user = Person::where('person_id',Auth::user()->person_id)->first(); //คนที่พิมพ์
        $d_t = date('H:i:s'); //เวลาที่พิมพ์
        $d_n = date('d/m/Y'); //วันที่พิมพ์

        $date_start = $request->date_start; //วันเริ่มต้นที่เลือก
        $date_end = $request->date_end; //สิ้นสุดวันที่เลือก

        $dep_code = $q_dep->dep_code;

        $q_rm = Rmmain::whereBetween('rmmain_dateon', [$date_start, $date_end])->where('rmmain_deprp',$dep_code)->where('status','Y')->count();
        $q_rm_check = Rmmain::where('system_code','2')->whereBetween('rmmain_dateon', [$date_start, $date_end])->where('rmmain_deprp',$dep_code)->where('status','Y')->count();
        $q_rm_uncheck = Rmmain::where('system_code','1')->whereBetween('rmmain_dateon', [$date_start, $date_end])->where('rmmain_deprp',$dep_code)->where('status','Y')->count();

        $q_rm_time_1 = Rmmain::where('rm_part_time','เช้า')->whereBetween('rmmain_dateon', [$date_start, $date_end])->where('rmmain_deprp',$dep_code)->where('status','Y')->count();
        $q_rm_time_2 = Rmmain::where('rm_part_time','บ่าย')->whereBetween('rmmain_dateon', [$date_start, $date_end])->where('rmmain_deprp',$dep_code)->where('status','Y')->count();
        $q_rm_time_3 = Rmmain::where('rm_part_time','ดึก')->whereBetween('rmmain_dateon', [$date_start, $date_end])->where('rmmain_deprp',$dep_code)->where('status','Y')->count();

        $q_affected_1 = Rmmain::where('rm_affected_person','1')->whereBetween('rmmain_dateon', [$date_start, $date_end])->where('rmmain_deprp',$dep_code)->where('status','Y')->count();
        $q_affected_2 = Rmmain::where('rm_affected_person','2')->whereBetween('rmmain_dateon', [$date_start, $date_end])->where('rmmain_deprp',$dep_code)->where('status','Y')->count();
        $q_affected_3 = Rmmain::where('rm_affected_person','3')->whereBetween('rmmain_dateon', [$date_start, $date_end])->where('rmmain_deprp',$dep_code)->where('status','Y')->count();

        $q_effect_1 = Rmmain::where('effect_code','1')->whereBetween('rmmain_dateon', [$date_start, $date_end])->where('rmmain_deprp',$dep_code)->where('status','Y')->count();
        $q_effect_2 = Rmmain::where('effect_code','2')->whereBetween('rmmain_dateon', [$date_start, $date_end])->where('rmmain_deprp',$dep_code)->where('status','Y')->count();
        $q_effect_3 = Rmmain::where('effect_code','3')->whereBetween('rmmain_dateon', [$date_start, $date_end])->where('rmmain_deprp',$dep_code)->where('status','Y')->count();
        $q_effect_4 = Rmmain::where('effect_code','4')->whereBetween('rmmain_dateon', [$date_start, $date_end])->where('rmmain_deprp',$dep_code)->where('status','Y')->count();
        $q_effect_5 = Rmmain::where('effect_code','5')->whereBetween('rmmain_dateon', [$date_start, $date_end])->where('rmmain_deprp',$dep_code)->where('status','Y')->count();
        $q_effect_6 = Rmmain::where('effect_code','6')->whereBetween('rmmain_dateon', [$date_start, $date_end])->where('rmmain_deprp',$dep_code)->where('status','Y')->count();

        $q_committee_PCT  = DB::table('rmcommittee')->join('rmmain', 'rmmain.rmmain_id', '=', 'rmcommittee.rmmain_id')->whereBetween('rmmain.rmmain_dateon', [$date_start, $date_end])->where('rmcommittee.committee_code','1')->where('rmmain_deprp',$dep_code)->where('rmmain.status','Y')->count();
        $q_committee_PTC  = DB::table('rmcommittee')->join('rmmain', 'rmmain.rmmain_id', '=', 'rmcommittee.rmmain_id')->whereBetween('rmmain.rmmain_dateon', [$date_start, $date_end])->where('rmcommittee.committee_code','2')->where('rmmain_deprp',$dep_code)->where('rmmain.status','Y')->count();
        $q_committee_IC  = DB::table('rmcommittee')->join('rmmain', 'rmmain.rmmain_id', '=', 'rmcommittee.rmmain_id')->whereBetween('rmmain.rmmain_dateon', [$date_start, $date_end])->where('rmcommittee.committee_code','3')->where('rmmain_deprp',$dep_code)->where('rmmain.status','Y')->count();
        $q_committee_ENV  = DB::table('rmcommittee')->join('rmmain', 'rmmain.rmmain_id', '=', 'rmcommittee.rmmain_id')->whereBetween('rmmain.rmmain_dateon', [$date_start, $date_end])->where('rmcommittee.committee_code','4')->where('rmmain_deprp',$dep_code)->where('rmmain.status','Y')->count();
        $q_committee_EQU  = DB::table('rmcommittee')->join('rmmain', 'rmmain.rmmain_id', '=', 'rmcommittee.rmmain_id')->whereBetween('rmmain.rmmain_dateon', [$date_start, $date_end])->where('rmcommittee.committee_code','5')->where('rmmain_deprp',$dep_code)->where('rmmain.status','Y')->count();
        $q_committee_IM  = DB::table('rmcommittee')->join('rmmain', 'rmmain.rmmain_id', '=', 'rmcommittee.rmmain_id')->whereBetween('rmmain.rmmain_dateon', [$date_start, $date_end])->where('rmcommittee.committee_code','6')->where('rmmain_deprp',$dep_code)->where('rmmain.status','Y')->count();
        $q_committee_HRD  = DB::table('rmcommittee')->join('rmmain', 'rmmain.rmmain_id', '=', 'rmcommittee.rmmain_id')->whereBetween('rmmain.rmmain_dateon', [$date_start, $date_end])->where('rmcommittee.committee_code','7')->where('rmmain_deprp',$dep_code)->where('rmmain.status','Y')->count();
        $q_committee_RM  = DB::table('rmcommittee')->join('rmmain', 'rmmain.rmmain_id', '=', 'rmcommittee.rmmain_id')->whereBetween('rmmain.rmmain_dateon', [$date_start, $date_end])->where('rmcommittee.committee_code','8')->where('rmmain_deprp',$dep_code)->where('rmmain.status','Y')->count();
        $q_committee_null  = DB::table('rmcommittee')->join('rmmain', 'rmmain.rmmain_id', '=', 'rmcommittee.rmmain_id')->whereBetween('rmmain.rmmain_dateon', [$date_start, $date_end])->where('rmcommittee.committee_code','9')->where('rmmain_deprp',$dep_code)->where('rmmain.status','Y')->count();

        $q_clinic_1 = Rmmain::where('clinic_code','1')->whereBetween('rmmain_dateon', [$date_start, $date_end])->where('rmmain_deprp',$dep_code)->where('status','Y')->count();
        $q_clinic_2 = Rmmain::where('clinic_code','2')->whereBetween('rmmain_dateon', [$date_start, $date_end])->where('rmmain_deprp',$dep_code)->where('status','Y')->count();
        $q_clinic_3 = Rmmain::where('clinic_code','3')->whereBetween('rmmain_dateon', [$date_start, $date_end])->where('rmmain_deprp',$dep_code)->where('status','Y')->count();


        $q_source_1 = Rmmain::where('source_code','1')->whereBetween('rmmain_dateon', [$date_start, $date_end])->where('rmmain_deprp',$dep_code)->where('status','Y')->count();
        $q_source_2 = Rmmain::where('source_code','2')->whereBetween('rmmain_dateon', [$date_start, $date_end])->where('rmmain_deprp',$dep_code)->where('status','Y')->count();
        $q_source_3 = Rmmain::where('source_code','3')->whereBetween('rmmain_dateon', [$date_start, $date_end])->where('rmmain_deprp',$dep_code)->where('status','Y')->count();
        $q_source_4 = Rmmain::where('source_code','4')->whereBetween('rmmain_dateon', [$date_start, $date_end])->where('rmmain_deprp',$dep_code)->where('status','Y')->count();
        $q_source_5 = Rmmain::where('source_code','5')->whereBetween('rmmain_dateon', [$date_start, $date_end])->where('rmmain_deprp',$dep_code)->where('status','Y')->count();
        $q_source_6 = Rmmain::where('source_code','6')->whereBetween('rmmain_dateon', [$date_start, $date_end])->where('rmmain_deprp',$dep_code)->where('status','Y')->count();
        $q_source_7 = Rmmain::where('source_code','7')->whereBetween('rmmain_dateon', [$date_start, $date_end])->where('rmmain_deprp',$dep_code)->where('status','Y')->count();
        $q_source_8 = Rmmain::where('source_code','8')->whereBetween('rmmain_dateon', [$date_start, $date_end])->where('rmmain_deprp',$dep_code)->where('status','Y')->count();

        $q_level_1 = Rmmain::where('level_code','1')->whereBetween('rmmain_dateon', [$date_start, $date_end])->where('rmmain_deprp',$dep_code)->where('status','Y')->count();
        $q_level_2 = Rmmain::where('level_code','2')->whereBetween('rmmain_dateon', [$date_start, $date_end])->where('rmmain_deprp',$dep_code)->where('status','Y')->count();
        $q_level_3 = Rmmain::where('level_code','3')->whereBetween('rmmain_dateon', [$date_start, $date_end])->where('rmmain_deprp',$dep_code)->where('status','Y')->count();
        $q_level_4 = Rmmain::where('level_code','4')->whereBetween('rmmain_dateon', [$date_start, $date_end])->where('rmmain_deprp',$dep_code)->where('status','Y')->count();
        $q_level_5 = Rmmain::where('level_code','5')->whereBetween('rmmain_dateon', [$date_start, $date_end])->where('rmmain_deprp',$dep_code)->where('status','Y')->count();
        $q_level_6 = Rmmain::where('level_code','6')->whereBetween('rmmain_dateon', [$date_start, $date_end])->where('rmmain_deprp',$dep_code)->where('status','Y')->count();
        $q_level_7 = Rmmain::where('level_code','7')->whereBetween('rmmain_dateon', [$date_start, $date_end])->where('rmmain_deprp',$dep_code)->where('status','Y')->count();
        $q_level_8 = Rmmain::where('level_code','8')->whereBetween('rmmain_dateon', [$date_start, $date_end])->where('rmmain_deprp',$dep_code)->where('status','Y')->count();
        $q_level_9 = Rmmain::where('level_code','9')->whereBetween('rmmain_dateon', [$date_start, $date_end])->where('rmmain_deprp',$dep_code)->where('status','Y')->count();
        $q_level_10 = Rmmain::where('level_code','10')->whereBetween('rmmain_dateon', [$date_start, $date_end])->where('rmmain_deprp',$dep_code)->where('status','Y')->count();
        $q_level_11 = Rmmain::where('level_code','11')->whereBetween('rmmain_dateon', [$date_start, $date_end])->where('rmmain_deprp',$dep_code)->where('status','Y')->count();
        $q_level_12 = Rmmain::where('level_code','12')->whereBetween('rmmain_dateon', [$date_start, $date_end])->where('rmmain_deprp',$dep_code)->where('status','Y')->count();
        $q_level_13 = Rmmain::where('level_code','13')->whereBetween('rmmain_dateon', [$date_start, $date_end])->where('rmmain_deprp',$dep_code)->where('status','Y')->count();
        $q_level_14 = Rmmain::where('level_code','14')->whereBetween('rmmain_dateon', [$date_start, $date_end])->where('rmmain_deprp',$dep_code)->where('status','Y')->count();
        $q_level_16 = Rmmain::where('level_code','16')->whereBetween('rmmain_dateon', [$date_start, $date_end])->where('rmmain_deprp',$dep_code)->where('status','Y')->count();
        $q_level_17 = Rmmain::where('level_code','17')->whereBetween('rmmain_dateon', [$date_start, $date_end])->where('rmmain_deprp',$dep_code)->where('status','Y')->count();
        $q_level_18 = Rmmain::where('level_code','18')->whereBetween('rmmain_dateon', [$date_start, $date_end])->where('rmmain_deprp',$dep_code)->where('status','Y')->count();
        $q_level_19 = Rmmain::where('level_code','19')->whereBetween('rmmain_dateon', [$date_start, $date_end])->where('rmmain_deprp',$dep_code)->where('status','Y')->count();


        $q_top5_riskcode_1  = DB::table('rmrisk')
        ->leftJoin('rmmain', 'rmrisk.rmmain_id', '=', 'rmmain.rmmain_id')
        ->leftJoin('co_risk', 'rmrisk.risk_code', '=', 'co_risk.risk_code')
        ->select(DB::raw('co_risk.risk_name,COUNT(rmrisk.risk_code) AS count'))
        ->whereBetween('rmmain.rmmain_dateon', [$date_start, $date_end])
        ->where('rmmain_deprp',$dep_code)
        ->where('rmmain.clinic_code','1')
        ->where('rmmain.status','Y')
        ->groupBy('rmrisk.risk_code')
        ->orderBy('count', 'DESC')
        ->limit(5)
        ->get();

        $q_top5_riskcode_2  = DB::table('rmrisk')
        ->leftJoin('rmmain', 'rmrisk.rmmain_id', '=', 'rmmain.rmmain_id')
        ->leftJoin('co_risk', 'rmrisk.risk_code', '=', 'co_risk.risk_code')
        ->select(DB::raw('co_risk.risk_name,COUNT(rmrisk.risk_code) AS count'))
        ->whereBetween('rmmain.rmmain_dateon', [$date_start, $date_end])
        ->where('rmmain_deprp',$dep_code)
        ->where('rmmain.clinic_code','2')
        ->where('rmmain.status','Y')
        ->groupBy('rmrisk.risk_code')
        ->orderBy('count', 'DESC')
        ->limit(5)
        ->get();

        $pdf = PDF::loadView('report.pdf.report_dep_summary_rm',[
            'q_dep'=>$q_dep,
            'dep_code'=>$dep_code,
            'date_start'=>$date_start, //วันเริ่มต้น
            'date_end'=>$date_end, //วันเริ่มต้น
            'd_n'=>$d_n, //วันปริ้น
            'd_t'=>$d_t, //เวลาปริ้น
            'q_user'=>$q_user, //ผู้ปริ้น

            'q_rm'=>$q_rm, //ความเสี่ยงทั้งหมด
            'q_rm_check'=>$q_rm_check, //ความเสี่ยงทั้งหมดที่ทบทวนแล้ว
            'q_rm_uncheck'=>$q_rm_uncheck, //ความเสี่ยงทั้งหมดที่ยังไม่ทบทวน
            'q_rm_time_1'=>$q_rm_time_1, //ความเสี่ยงเวรเช้า
            'q_rm_time_2'=>$q_rm_time_2, //ความเสี่ยงเวรบ่าย
            'q_rm_time_3'=>$q_rm_time_3, //ความเสี่ยงเวรดึก
            'q_affected_1'=>$q_affected_1, //ผู้ได้รับผลกระทบ บุคคล
            'q_affected_2'=>$q_affected_2, //ผู้ได้รับผลกระทบ กลุ่มบุคคล
            'q_affected_3'=>$q_affected_3, //ผู้ได้รับผลกระทบ หน่วยงาน
            'q_effect_1'=>$q_effect_1, //ผลกระทบ AE Error
            'q_effect_2'=>$q_effect_2, //ผลกระทบ AE
            'q_effect_3'=>$q_effect_3, //ผลกระทบ Error
            'q_effect_4'=>$q_effect_4, //ผลกระทบ Error Alert*
            'q_effect_5'=>$q_effect_5, //ผลกระทบ Sentinel Event*
            'q_effect_6'=>$q_effect_6, //ผลกระทบ ที่ไม่ระบุ

            'q_committee_PCT'=>$q_committee_PCT, //กรรมการที่เกี่ยวข้อง PCT
            'q_committee_PTC'=>$q_committee_PTC, //กรรมการที่เกี่ยวข้อง PTC
            'q_committee_IC'=>$q_committee_IC, //กรรมการที่เกี่ยวข้อง IC
            'q_committee_ENV'=>$q_committee_ENV, //กรรมการที่เกี่ยวข้อง ENV
            'q_committee_EQU'=>$q_committee_EQU, //กรรมการที่เกี่ยวข้อง EQU
            'q_committee_IM'=>$q_committee_IM, //กรรมการที่เกี่ยวข้อง IM
            'q_committee_HRD'=>$q_committee_HRD, //กรรมการที่เกี่ยวข้อง HRD
            'q_committee_RM'=>$q_committee_RM, //กรรมการที่เกี่ยวข้อง RM
            'q_committee_null'=>$q_committee_null, //กรรมการที่เกี่ยวข้อง ไม่ระบุ

            'q_clinic_1'=>$q_clinic_1, //clinical risk
            'q_clinic_2'=>$q_clinic_2, //non clinical risk
            'q_clinic_3'=>$q_clinic_3, //ไม่ระบุ clinical

            'q_source_1'=>$q_source_1, //แหล่งที่มาความเสี่ยง ทะเบียนความบันทึกความเสี่ยง
            'q_source_2'=>$q_source_2, //แหล่งที่มาความเสี่ยง ข้อร้องเรียน ข้อคิดเห็น คำชื่นชม
            'q_source_3'=>$q_source_3, //แหล่งที่มาความเสี่ยง ทบทวน 12 กิจกรรม
            'q_source_4'=>$q_source_4, //แหล่งที่มาความเสี่ยง ทบทวน trigger tool
            'q_source_5'=>$q_source_5, //แหล่งที่มาความเสี่ยง เหตุการณ์สำคัญ
            'q_source_6'=>$q_source_6, //แหล่งที่มาความเสี่ยง Round
            'q_source_7'=>$q_source_7, //แหล่งที่มาความเสี่ยง ใบซ่อมบำรุง
            'q_source_8'=>$q_source_8, //แหล่งที่มาความเสี่ยง ทบทวน Re-Admit 28 วัน

            'q_top5_riskcode_1'=>$q_top5_riskcode_1, //TOP 5 รหัสความเสี่ยง clinic
            'q_top5_riskcode_2'=>$q_top5_riskcode_2, //TOP 5 รหัสความเสี่ยง Non clinic

            'q_level_1'=>$q_level_1, //ระดับ A
            'q_level_2'=>$q_level_2, //ระดับ B
            'q_level_3'=>$q_level_3, //ระดับ C
            'q_level_4'=>$q_level_4, //ระดับ D
            'q_level_5'=>$q_level_5, //ระดับ E
            'q_level_6'=>$q_level_6, //ระดับ F
            'q_level_7'=>$q_level_7, //ระดับ G
            'q_level_8'=>$q_level_8, //ระดับ H
            'q_level_9'=>$q_level_9, //ระดับ I
            'q_level_10'=>$q_level_10, //ระดับ 1 Non Clinic  Near Miss
            'q_level_11'=>$q_level_11, //ระดับ 2 Non Clinic Miss  น้อย 10,000
            'q_level_12'=>$q_level_12, //ระดับ 3 Non Clinic Miss 10,000 ถึง 100,000
            'q_level_13'=>$q_level_13, //ระดับ 4 Non Clinic Miss มากกว่า 100,000
            'q_level_14'=>$q_level_14, //ไม่ระบุ
            'q_level_16'=>$q_level_16, //ระดับ 1 ข้อคิดเห็น/ข้อเสนอแนะ
            'q_level_17'=>$q_level_17, //ระดับ 2 ข้อร้องเรียนเรื่องเล็ก
            'q_level_18'=>$q_level_18, //ระดับ 3 ข้อร้องเรียนเรื่องใหญ่
            'q_level_19'=>$q_level_19, //ระดับ 4 การฟ้องร้อง
        ]);

        return @$pdf->stream();
    }


    //รายงานภาพรวมระดับ กรรมการที่เกี่ยวข้อง (ทีม)
    public function report_committee_summary_rm(Request $request){
        $q_committee = Co_committee::where('committee_code',$request->committee)->first();
        $q_user = Person::where('person_id',Auth::user()->person_id)->first(); //คนที่พิมพ์
        $d_t = date('H:i:s'); //เวลาที่พิมพ์
        $d_n = date('d/m/Y'); //วันที่พิมพ์

        $date_start = $request->date_start; //วันเริ่มต้นที่เลือก
        $date_end = $request->date_end; //สิ้นสุดวันที่เลือก

        $committee_code = $q_committee->committee_code;

        $q_rm  = DB::table('rmcommittee')->join('rmmain', 'rmmain.rmmain_id', '=', 'rmcommittee.rmmain_id')->whereBetween('rmmain.rmmain_dateon', [$date_start, $date_end])->where('rmcommittee.committee_code',$committee_code)->where('rmmain.status','Y')->count();
        $q_rm_check  = DB::table('rmcommittee')->join('rmmain', 'rmmain.rmmain_id', '=', 'rmcommittee.rmmain_id')->whereBetween('rmmain.rmmain_dateon', [$date_start, $date_end])->where('rmcommittee.committee_code',$committee_code)->where('rmmain.system_code','2')->where('rmmain.status','Y')->count();
        $q_rm_uncheck  = DB::table('rmcommittee')->join('rmmain', 'rmmain.rmmain_id', '=', 'rmcommittee.rmmain_id')->whereBetween('rmmain.rmmain_dateon', [$date_start, $date_end])->where('rmcommittee.committee_code',$committee_code)->where('rmmain.system_code','1')->where('rmmain.status','Y')->count();

        $q_rm_time_1  = DB::table('rmcommittee')->join('rmmain', 'rmmain.rmmain_id', '=', 'rmcommittee.rmmain_id')->whereBetween('rmmain.rmmain_dateon', [$date_start, $date_end])->where('rmcommittee.committee_code',$committee_code)->where('rmmain.rm_part_time','เช้า')->where('rmmain.status','Y')->count();
        $q_rm_time_2  = DB::table('rmcommittee')->join('rmmain', 'rmmain.rmmain_id', '=', 'rmcommittee.rmmain_id')->whereBetween('rmmain.rmmain_dateon', [$date_start, $date_end])->where('rmcommittee.committee_code',$committee_code)->where('rmmain.rm_part_time','บ่าย')->where('rmmain.status','Y')->count();
        $q_rm_time_3  = DB::table('rmcommittee')->join('rmmain', 'rmmain.rmmain_id', '=', 'rmcommittee.rmmain_id')->whereBetween('rmmain.rmmain_dateon', [$date_start, $date_end])->where('rmcommittee.committee_code',$committee_code)->where('rmmain.rm_part_time','ดึก')->where('rmmain.status','Y')->count();

        $q_affected_1  = DB::table('rmcommittee')->join('rmmain', 'rmmain.rmmain_id', '=', 'rmcommittee.rmmain_id')->whereBetween('rmmain.rmmain_dateon', [$date_start, $date_end])->where('rmcommittee.committee_code',$committee_code)->where('rmmain.rm_affected_person','1')->where('rmmain.status','Y')->count();
        $q_affected_2  = DB::table('rmcommittee')->join('rmmain', 'rmmain.rmmain_id', '=', 'rmcommittee.rmmain_id')->whereBetween('rmmain.rmmain_dateon', [$date_start, $date_end])->where('rmcommittee.committee_code',$committee_code)->where('rmmain.rm_affected_person','2')->where('rmmain.status','Y')->count();
        $q_affected_3  = DB::table('rmcommittee')->join('rmmain', 'rmmain.rmmain_id', '=', 'rmcommittee.rmmain_id')->whereBetween('rmmain.rmmain_dateon', [$date_start, $date_end])->where('rmcommittee.committee_code',$committee_code)->where('rmmain.rm_affected_person','3')->where('rmmain.status','Y')->count();

        $q_effect_1  = DB::table('rmcommittee')->join('rmmain', 'rmmain.rmmain_id', '=', 'rmcommittee.rmmain_id')->whereBetween('rmmain.rmmain_dateon', [$date_start, $date_end])->where('rmcommittee.committee_code',$committee_code)->where('rmmain.effect_code','1')->where('rmmain.status','Y')->count();
        $q_effect_2  = DB::table('rmcommittee')->join('rmmain', 'rmmain.rmmain_id', '=', 'rmcommittee.rmmain_id')->whereBetween('rmmain.rmmain_dateon', [$date_start, $date_end])->where('rmcommittee.committee_code',$committee_code)->where('rmmain.effect_code','2')->where('rmmain.status','Y')->count();
        $q_effect_3  = DB::table('rmcommittee')->join('rmmain', 'rmmain.rmmain_id', '=', 'rmcommittee.rmmain_id')->whereBetween('rmmain.rmmain_dateon', [$date_start, $date_end])->where('rmcommittee.committee_code',$committee_code)->where('rmmain.effect_code','3')->where('rmmain.status','Y')->count();
        $q_effect_4  = DB::table('rmcommittee')->join('rmmain', 'rmmain.rmmain_id', '=', 'rmcommittee.rmmain_id')->whereBetween('rmmain.rmmain_dateon', [$date_start, $date_end])->where('rmcommittee.committee_code',$committee_code)->where('rmmain.effect_code','4')->where('rmmain.status','Y')->count();
        $q_effect_5  = DB::table('rmcommittee')->join('rmmain', 'rmmain.rmmain_id', '=', 'rmcommittee.rmmain_id')->whereBetween('rmmain.rmmain_dateon', [$date_start, $date_end])->where('rmcommittee.committee_code',$committee_code)->where('rmmain.effect_code','5')->where('rmmain.status','Y')->count();
        $q_effect_6  = DB::table('rmcommittee')->join('rmmain', 'rmmain.rmmain_id', '=', 'rmcommittee.rmmain_id')->whereBetween('rmmain.rmmain_dateon', [$date_start, $date_end])->where('rmcommittee.committee_code',$committee_code)->where('rmmain.effect_code','6')->where('rmmain.status','Y')->count();

        $q_clinic_1  = DB::table('rmcommittee')->join('rmmain', 'rmmain.rmmain_id', '=', 'rmcommittee.rmmain_id')->whereBetween('rmmain.rmmain_dateon', [$date_start, $date_end])->where('rmcommittee.committee_code',$committee_code)->where('rmmain.clinic_code','1')->where('rmmain.status','Y')->count();
        $q_clinic_2  = DB::table('rmcommittee')->join('rmmain', 'rmmain.rmmain_id', '=', 'rmcommittee.rmmain_id')->whereBetween('rmmain.rmmain_dateon', [$date_start, $date_end])->where('rmcommittee.committee_code',$committee_code)->where('rmmain.clinic_code','2')->where('rmmain.status','Y')->count();
        $q_clinic_3  = DB::table('rmcommittee')->join('rmmain', 'rmmain.rmmain_id', '=', 'rmcommittee.rmmain_id')->whereBetween('rmmain.rmmain_dateon', [$date_start, $date_end])->where('rmcommittee.committee_code',$committee_code)->where('rmmain.clinic_code','3')->where('rmmain.status','Y')->count();

        $q_source_1  = DB::table('rmcommittee')->join('rmmain', 'rmmain.rmmain_id', '=', 'rmcommittee.rmmain_id')->whereBetween('rmmain.rmmain_dateon', [$date_start, $date_end])->where('rmcommittee.committee_code',$committee_code)->where('rmmain.source_code','1')->where('rmmain.status','Y')->count();
        $q_source_2  = DB::table('rmcommittee')->join('rmmain', 'rmmain.rmmain_id', '=', 'rmcommittee.rmmain_id')->whereBetween('rmmain.rmmain_dateon', [$date_start, $date_end])->where('rmcommittee.committee_code',$committee_code)->where('rmmain.source_code','2')->where('rmmain.status','Y')->count();
        $q_source_3  = DB::table('rmcommittee')->join('rmmain', 'rmmain.rmmain_id', '=', 'rmcommittee.rmmain_id')->whereBetween('rmmain.rmmain_dateon', [$date_start, $date_end])->where('rmcommittee.committee_code',$committee_code)->where('rmmain.source_code','3')->where('rmmain.status','Y')->count();
        $q_source_4  = DB::table('rmcommittee')->join('rmmain', 'rmmain.rmmain_id', '=', 'rmcommittee.rmmain_id')->whereBetween('rmmain.rmmain_dateon', [$date_start, $date_end])->where('rmcommittee.committee_code',$committee_code)->where('rmmain.source_code','4')->where('rmmain.status','Y')->count();
        $q_source_5  = DB::table('rmcommittee')->join('rmmain', 'rmmain.rmmain_id', '=', 'rmcommittee.rmmain_id')->whereBetween('rmmain.rmmain_dateon', [$date_start, $date_end])->where('rmcommittee.committee_code',$committee_code)->where('rmmain.source_code','5')->where('rmmain.status','Y')->count();
        $q_source_6  = DB::table('rmcommittee')->join('rmmain', 'rmmain.rmmain_id', '=', 'rmcommittee.rmmain_id')->whereBetween('rmmain.rmmain_dateon', [$date_start, $date_end])->where('rmcommittee.committee_code',$committee_code)->where('rmmain.source_code','6')->where('rmmain.status','Y')->count();
        $q_source_7  = DB::table('rmcommittee')->join('rmmain', 'rmmain.rmmain_id', '=', 'rmcommittee.rmmain_id')->whereBetween('rmmain.rmmain_dateon', [$date_start, $date_end])->where('rmcommittee.committee_code',$committee_code)->where('rmmain.source_code','7')->where('rmmain.status','Y')->count();
        $q_source_8  = DB::table('rmcommittee')->join('rmmain', 'rmmain.rmmain_id', '=', 'rmcommittee.rmmain_id')->whereBetween('rmmain.rmmain_dateon', [$date_start, $date_end])->where('rmcommittee.committee_code',$committee_code)->where('rmmain.source_code','8')->where('rmmain.status','Y')->count();

        $q_level_1  = DB::table('rmcommittee')->join('rmmain', 'rmmain.rmmain_id', '=', 'rmcommittee.rmmain_id')->whereBetween('rmmain.rmmain_dateon', [$date_start, $date_end])->where('rmcommittee.committee_code',$committee_code)->where('rmmain.level_code','8')->where('rmmain.status','Y')->count();
        $q_level_2  = DB::table('rmcommittee')->join('rmmain', 'rmmain.rmmain_id', '=', 'rmcommittee.rmmain_id')->whereBetween('rmmain.rmmain_dateon', [$date_start, $date_end])->where('rmcommittee.committee_code',$committee_code)->where('rmmain.level_code','2')->where('rmmain.status','Y')->count();
        $q_level_3  = DB::table('rmcommittee')->join('rmmain', 'rmmain.rmmain_id', '=', 'rmcommittee.rmmain_id')->whereBetween('rmmain.rmmain_dateon', [$date_start, $date_end])->where('rmcommittee.committee_code',$committee_code)->where('rmmain.level_code','3')->where('rmmain.status','Y')->count();
        $q_level_4  = DB::table('rmcommittee')->join('rmmain', 'rmmain.rmmain_id', '=', 'rmcommittee.rmmain_id')->whereBetween('rmmain.rmmain_dateon', [$date_start, $date_end])->where('rmcommittee.committee_code',$committee_code)->where('rmmain.level_code','4')->where('rmmain.status','Y')->count();
        $q_level_5  = DB::table('rmcommittee')->join('rmmain', 'rmmain.rmmain_id', '=', 'rmcommittee.rmmain_id')->whereBetween('rmmain.rmmain_dateon', [$date_start, $date_end])->where('rmcommittee.committee_code',$committee_code)->where('rmmain.level_code','5')->where('rmmain.status','Y')->count();
        $q_level_6  = DB::table('rmcommittee')->join('rmmain', 'rmmain.rmmain_id', '=', 'rmcommittee.rmmain_id')->whereBetween('rmmain.rmmain_dateon', [$date_start, $date_end])->where('rmcommittee.committee_code',$committee_code)->where('rmmain.level_code','6')->where('rmmain.status','Y')->count();
        $q_level_7  = DB::table('rmcommittee')->join('rmmain', 'rmmain.rmmain_id', '=', 'rmcommittee.rmmain_id')->whereBetween('rmmain.rmmain_dateon', [$date_start, $date_end])->where('rmcommittee.committee_code',$committee_code)->where('rmmain.level_code','7')->where('rmmain.status','Y')->count();
        $q_level_8  = DB::table('rmcommittee')->join('rmmain', 'rmmain.rmmain_id', '=', 'rmcommittee.rmmain_id')->whereBetween('rmmain.rmmain_dateon', [$date_start, $date_end])->where('rmcommittee.committee_code',$committee_code)->where('rmmain.level_code','8')->where('rmmain.status','Y')->count();
        $q_level_9  = DB::table('rmcommittee')->join('rmmain', 'rmmain.rmmain_id', '=', 'rmcommittee.rmmain_id')->whereBetween('rmmain.rmmain_dateon', [$date_start, $date_end])->where('rmcommittee.committee_code',$committee_code)->where('rmmain.level_code','9')->where('rmmain.status','Y')->count();
        $q_level_10  = DB::table('rmcommittee')->join('rmmain', 'rmmain.rmmain_id', '=', 'rmcommittee.rmmain_id')->whereBetween('rmmain.rmmain_dateon', [$date_start, $date_end])->where('rmcommittee.committee_code',$committee_code)->where('rmmain.level_code','10')->where('rmmain.status','Y')->count();
        $q_level_11  = DB::table('rmcommittee')->join('rmmain', 'rmmain.rmmain_id', '=', 'rmcommittee.rmmain_id')->whereBetween('rmmain.rmmain_dateon', [$date_start, $date_end])->where('rmcommittee.committee_code',$committee_code)->where('rmmain.level_code','11')->where('rmmain.status','Y')->count();
        $q_level_12  = DB::table('rmcommittee')->join('rmmain', 'rmmain.rmmain_id', '=', 'rmcommittee.rmmain_id')->whereBetween('rmmain.rmmain_dateon', [$date_start, $date_end])->where('rmcommittee.committee_code',$committee_code)->where('rmmain.level_code','12')->where('rmmain.status','Y')->count();
        $q_level_13  = DB::table('rmcommittee')->join('rmmain', 'rmmain.rmmain_id', '=', 'rmcommittee.rmmain_id')->whereBetween('rmmain.rmmain_dateon', [$date_start, $date_end])->where('rmcommittee.committee_code',$committee_code)->where('rmmain.level_code','13')->where('rmmain.status','Y')->count();
        $q_level_14  = DB::table('rmcommittee')->join('rmmain', 'rmmain.rmmain_id', '=', 'rmcommittee.rmmain_id')->whereBetween('rmmain.rmmain_dateon', [$date_start, $date_end])->where('rmcommittee.committee_code',$committee_code)->where('rmmain.level_code','14')->where('rmmain.status','Y')->count();
        $q_level_15  = DB::table('rmcommittee')->join('rmmain', 'rmmain.rmmain_id', '=', 'rmcommittee.rmmain_id')->whereBetween('rmmain.rmmain_dateon', [$date_start, $date_end])->where('rmcommittee.committee_code',$committee_code)->where('rmmain.level_code','15')->where('rmmain.status','Y')->count();
        $q_level_16  = DB::table('rmcommittee')->join('rmmain', 'rmmain.rmmain_id', '=', 'rmcommittee.rmmain_id')->whereBetween('rmmain.rmmain_dateon', [$date_start, $date_end])->where('rmcommittee.committee_code',$committee_code)->where('rmmain.level_code','16')->where('rmmain.status','Y')->count();
        $q_level_17  = DB::table('rmcommittee')->join('rmmain', 'rmmain.rmmain_id', '=', 'rmcommittee.rmmain_id')->whereBetween('rmmain.rmmain_dateon', [$date_start, $date_end])->where('rmcommittee.committee_code',$committee_code)->where('rmmain.level_code','17')->where('rmmain.status','Y')->count();
        $q_level_18  = DB::table('rmcommittee')->join('rmmain', 'rmmain.rmmain_id', '=', 'rmcommittee.rmmain_id')->whereBetween('rmmain.rmmain_dateon', [$date_start, $date_end])->where('rmcommittee.committee_code',$committee_code)->where('rmmain.level_code','18')->where('rmmain.status','Y')->count();
        $q_level_19  = DB::table('rmcommittee')->join('rmmain', 'rmmain.rmmain_id', '=', 'rmcommittee.rmmain_id')->whereBetween('rmmain.rmmain_dateon', [$date_start, $date_end])->where('rmcommittee.committee_code',$committee_code)->where('rmmain.level_code','19')->where('rmmain.status','Y')->count();

        $q_top5_riskcode_1  = DB::table('rmrisk')
        ->leftJoin('rmmain', 'rmrisk.rmmain_id', '=', 'rmmain.rmmain_id')
        ->leftJoin('rmcommittee','rmcommittee.rmmain_id','=','rmrisk.rmmain_id')
        ->leftJoin('co_risk', 'rmrisk.risk_code', '=', 'co_risk.risk_code')
        ->select(DB::raw('co_risk.risk_name,COUNT(rmrisk.risk_code) AS count'))
        ->whereBetween('rmmain.rmmain_dateon', [$date_start, $date_end])
        ->where('rmcommittee.committee_code',$committee_code)
        ->where('rmmain.clinic_code','1')
        ->where('rmmain.status','Y')
        ->groupBy('rmrisk.risk_code')
        ->orderBy('count', 'DESC')
        ->limit(5)
        ->get();

        $q_top5_riskcode_2  = DB::table('rmrisk')
        ->leftJoin('rmmain', 'rmrisk.rmmain_id', '=', 'rmmain.rmmain_id')
        ->leftJoin('rmcommittee','rmcommittee.rmmain_id','=','rmrisk.rmmain_id')
        ->leftJoin('co_risk', 'rmrisk.risk_code', '=', 'co_risk.risk_code')
        ->select(DB::raw('co_risk.risk_name,COUNT(rmrisk.risk_code) AS count'))
        ->whereBetween('rmmain.rmmain_dateon', [$date_start, $date_end])
        ->where('rmcommittee.committee_code',$committee_code)
        ->where('rmmain.clinic_code','2')
        ->where('rmmain.status','Y')
        ->groupBy('rmrisk.risk_code')
        ->orderBy('count', 'DESC')
        ->limit(5)
        ->get();

        $pdf = PDF::loadView('report.pdf.report_committee_summary_rm',[
            'q_committee'=>$q_committee,
            'committee_code'=>$committee_code,
            'date_start'=>$date_start, //วันเริ่มต้น
            'date_end'=>$date_end, //วันเริ่มต้น
            'd_n'=>$d_n, //วันปริ้น
            'd_t'=>$d_t, //เวลาปริ้น
            'q_user'=>$q_user, //ผู้ปริ้น

            'q_rm'=>$q_rm, //ความเสี่ยงทั้งหมด
            'q_rm_check'=>$q_rm_check, //ความเสี่ยงทั้งหมดที่ทบทวนแล้ว
            'q_rm_uncheck'=>$q_rm_uncheck, //ความเสี่ยงทั้งหมดที่ยังไม่ทบทวน
            'q_rm_time_1'=>$q_rm_time_1, //ความเสี่ยงเวรเช้า
            'q_rm_time_2'=>$q_rm_time_2, //ความเสี่ยงเวรบ่าย
            'q_rm_time_3'=>$q_rm_time_3, //ความเสี่ยงเวรดึก
            'q_affected_1'=>$q_affected_1, //ผู้ได้รับผลกระทบ บุคคล
            'q_affected_2'=>$q_affected_2, //ผู้ได้รับผลกระทบ กลุ่มบุคคล
            'q_affected_3'=>$q_affected_3, //ผู้ได้รับผลกระทบ หน่วยงาน
            'q_effect_1'=>$q_effect_1, //ผลกระทบ AE Error
            'q_effect_2'=>$q_effect_2, //ผลกระทบ AE
            'q_effect_3'=>$q_effect_3, //ผลกระทบ Error
            'q_effect_4'=>$q_effect_4, //ผลกระทบ Error Alert*
            'q_effect_5'=>$q_effect_5, //ผลกระทบ Sentinel Event*
            'q_effect_6'=>$q_effect_6, //ผลกระทบ ที่ไม่ระบุ

            'q_clinic_1'=>$q_clinic_1, //clinical risk
            'q_clinic_2'=>$q_clinic_2, //non clinical risk
            'q_clinic_3'=>$q_clinic_3, //ไม่ระบุ clinical

            'q_source_1'=>$q_source_1, //แหล่งที่มาความเสี่ยง ทะเบียนความบันทึกความเสี่ยง
            'q_source_2'=>$q_source_2, //แหล่งที่มาความเสี่ยง ข้อร้องเรียน ข้อคิดเห็น คำชื่นชม
            'q_source_3'=>$q_source_3, //แหล่งที่มาความเสี่ยง ทบทวน 12 กิจกรรม
            'q_source_4'=>$q_source_4, //แหล่งที่มาความเสี่ยง ทบทวน trigger tool
            'q_source_5'=>$q_source_5, //แหล่งที่มาความเสี่ยง เหตุการณ์สำคัญ
            'q_source_6'=>$q_source_6, //แหล่งที่มาความเสี่ยง Round
            'q_source_7'=>$q_source_7, //แหล่งที่มาความเสี่ยง ใบซ่อมบำรุง
            'q_source_8'=>$q_source_8, //แหล่งที่มาความเสี่ยง ทบทวน Re-Admit 28 วัน

            'q_top5_riskcode_1'=>$q_top5_riskcode_1, //TOP 5 รหัสความเสี่ยง clinic
            'q_top5_riskcode_2'=>$q_top5_riskcode_2, //TOP 5 รหัสความเสี่ยง Non clinic

            'q_level_1'=>$q_level_1, //ระดับ A
            'q_level_2'=>$q_level_2, //ระดับ B
            'q_level_3'=>$q_level_3, //ระดับ C
            'q_level_4'=>$q_level_4, //ระดับ D
            'q_level_5'=>$q_level_5, //ระดับ E
            'q_level_6'=>$q_level_6, //ระดับ F
            'q_level_7'=>$q_level_7, //ระดับ G
            'q_level_8'=>$q_level_8, //ระดับ H
            'q_level_9'=>$q_level_9, //ระดับ I
            'q_level_10'=>$q_level_10, //ระดับ 1 Non Clinic  Near Miss
            'q_level_11'=>$q_level_11, //ระดับ 2 Non Clinic Miss  น้อย 10,000
            'q_level_12'=>$q_level_12, //ระดับ 3 Non Clinic Miss 10,000 ถึง 100,000
            'q_level_13'=>$q_level_13, //ระดับ 4 Non Clinic Miss มากกว่า 100,000
            'q_level_14'=>$q_level_14, //ไม่ระบุ
            'q_level_16'=>$q_level_16, //ระดับ 1 ข้อคิดเห็น/ข้อเสนอแนะ
            'q_level_17'=>$q_level_17, //ระดับ 2 ข้อร้องเรียนเรื่องเล็ก
            'q_level_18'=>$q_level_18, //ระดับ 3 ข้อร้องเรียนเรื่องใหญ่
            'q_level_19'=>$q_level_19, //ระดับ 4 การฟ้องร้อง
        ]);
        return @$pdf->stream();
    }
}
