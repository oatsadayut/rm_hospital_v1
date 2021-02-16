<?php

namespace App\Http\Controllers;

use Alert;
use App\User;
use App\Rmdep;
use App\Rmcommittee;
use App\Rmmain;
use App\Rmrisk;
use App\Person;
use App\Co_sex;
use App\Co_dep;
use App\Co_specd;
use App\Co_source;
use App\Co_committee;
use App\Co_system;
use App\Co_clinic;
use App\Co_level;
use App\Co_effect;
use App\Co_risk;
use App\Co_affected_person;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class RegisterrmComtroller extends Controller
{
    public function index(){
        $q_person = Person::where('status','Y')->get();
        $q_sex = Co_sex::all();
        $q_dep = Co_dep::where('status','Y')->get();
        $q_clinic = Co_clinic::where('status','Y')->get();
        $q_level = Co_level::where('status','Y')->get();
        $q_committee = Co_committee::where('status','Y')->get();
        $q_system = Co_system::where('status','Y')->get();
        $q_risk = Co_risk::where('status','Y')->get();
        $q_specd = Co_specd::where('status','Y')->get();
        $q_effect = Co_effect::where('status','Y')->get();
        $q_source = Co_source::where('status','Y')->get();
        $q_affected_person = Co_affected_person::where('status','Y')->get();
        return view('regrm.index',[
            'q_person'=>$q_person,
            'q_source'=>$q_source,
            'q_affected_person'=>$q_affected_person,
            'q_sex'=>$q_sex,
            'q_effect'=>$q_effect,
            'q_specd'=>$q_specd,
            'q_risk'=>$q_risk,
            'q_level'=>$q_level,
            'q_clinic'=>$q_clinic,
            'q_system'=>$q_system,
            'q_committee'=>$q_committee,
            'q_dep'=>$q_dep]);
    }

    public function regis($request){

        $d_n = date('Y-m-d');
        $d = date('YmdHis');
        $r = rand(1000,9999);
        $str_d = "M".$d.$r;

        $cidrp =  $request->rm_reporter;
        $person = Person::where('person_cid',$cidrp)->first();
        if($person != '' || $person != null){
            $dep_person_rp = $person->dep_code;
        }else{
            $dep_person_rp = 32;
        }

        if (isset($_POST['btn-submit'])) {

            $q = new Rmmain;
            $q->source_code = $request->source_code; //แหล่งข้อมูล
            $q->rmmain_dateon = $request->rm_date; //วันที่เกิดเหตุ
            $q->rmmain_daterp = $d_n; //วันที่ report
            $q->rmmain_time = $request->rm_time; //เวลาเกิดเหตุการณ์
            $q->rm_part_time = $request->part_show_hidden; //ช่วงเวลา

            $q->rm_point = $request->rm_point; //สถานที่เกิดเหตุ
            $q->rmmain_topic = $request->rm_title; //หัวข้อเหตุการณ์
            $q->rmmain_detail = $request->rm_detail; //รายละเอียดเหตุการณ์

            $q->rm_affected_person = $request->rm_affected_person; //ผู้ได้รับผลกระทบ
            $q->rm_affected_sex = $request->rm_affected_sex; //เพศ
            $q->rm_affected_age = $request->rm_affected_age; //อายุ
            $q->effect_code = $request->rm_effect; //ผลกระทบ
            $q->specd_code = $request->rm_disease; //โรคเฉพาะ

            $q->clinic_code = $request->rm_risk_type; //ชนิดความเสี่ยง
            $q->level_code = $request->rm_violence_level; //ระดับความรุนแรง

            $q->rm_date_review = $request->rm_date_review; //วันที่ทบทวน
            $q->system_code = 1; //ทบทวน
            $q->rm_results_review = $request->rm_results_review; //ผลการทบทวน

            $q->rmmain_cidrp = $request->rm_reporter; //ผู้เขียนรายงาน
            $q->rmmain_deprp = $dep_person_rp; //หน่วยงานของผู้รายงาน
            $q->rmmain_cidwr = Auth::user()->cid; //ผู้พิมพ์
            $q->serialinsert = $str_d;
            $q->status = "Y"; //สถานะ
            $q->save();

            return $q->id;
        }
    }

    public function rm_risk_code($rmmain_id,$request){
        foreach($request->rm_risk_code as $item){
            $q = new Rmrisk;
            $q->risk_code = $item; //รหัสความเสี่ยง
            $q->rmmain_id = $rmmain_id; //id ความเสี่ยง (ตาราง rmmain)
            $q->status = "Y"; //สถานะ
            $q->save();
        };
    }

    public function rm_dep($rmmain_id,$request){
        foreach($request->rm_dep as $item){
            $q = new Rmdep;
            $q->dep_code = $item; //รหัสหน่วยงาน
            $q->rmmain_id = $rmmain_id; //id ความเสี่ยง (ตาราง rmmain)
            $q->status = "Y"; //สถานะ
            $q->save();
        };
    }

    public function rm_committee($rmmain_id,$request){
        foreach($request->rm_committee as $item){
            $q = new Rmcommittee;
            $q->committee_code = $item; //รหัสกรรมการความเสี่ยง
            $q->rmmain_id = $rmmain_id; //id ความเสี่ยง (ตาราง rmmain)
            $q->status = "Y"; //สถานะ
            $q->save();
        };
    }

    public function store(Request $request){
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
        $regis_id = $this->regis($request);

        if($regis_id != "" || $regis_id != null){

            //Rmrisk insert รหัสควาเสี่ยง
            $this->rm_risk_code($regis_id,$request);
            //Rmdep insert รหัสหน่วยงาน
            $this->rm_dep($regis_id,$request);
            //Rmcommittee insert รหัสกรรมการความเสี่ยง
            $this->rm_committee($regis_id,$request);

            Alert::success('บันทึกข้อมูลเรียบร้อย', 'บันทึกข้อมูลความเสี่ยงเรียบร้อย กรุณาตรวจสอบความถูกต้องอีกครั้ง');
        }else{
            Alert::error('เกิดข้อผิดพลาด', 'ไม่สามารถบันทึกข้อมูลได้ กรุณาตรวจสอบความถูกต้องอีกครั้ง');
        }
        return back();
    }
}
