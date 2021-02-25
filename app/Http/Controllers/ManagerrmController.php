<?php

namespace App\Http\Controllers;

use DB;
use Alert;

use App\Co_system;
use App\Co_dep;
use App\Co_affected_person;
use App\Rmmain;
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
    public function index(){
        $date_first = date('Y-m-01');
        $date_last = date('Y-m-t');

        if(Auth::user()->permission >= 3){
            $q = Rmmain::whereBetween('rmmain_daterp', [$date_first, $date_last])->where('status','Y')->get();
        }else{
             $q = Rmmain::whereBetween('rmmain_daterp', [$date_first, $date_last])
                             ->where('rmmain_cidwr',Auth::user()->cid)
                             ->where('status','Y')
                             ->get();
        }

        return view('managerrm.index',[
            'q'=>$q,
            'date_first'=>$date_first,
            'date_last'=>$date_last
        ]);
    }

    public function getdate(Request $request){
        $date_first = $request->date_first;
        $date_last = $request->date_last;
        $q = Rmmain::whereBetween('rmmain_daterp', [$date_first, $date_last])->where('status','Y')->get();
        return view('managerrm.index',[
            'q'=>$q,
            'date_first'=>$date_first,
            'date_last'=>$date_last
        ]);
    }

    public function detail($id){
        $q = Rmmain::where('rmmain_id',$id)->where('status','Y')->first();
        $q_system = Co_system::where('status','Y')->get();

        $q_person_chk = Person::where('person_cid',$q->rmmain_cidrp)->where('status','Y')->count();
        $q_person = Person::where('person_cid',$q->rmmain_cidrp)->where('status','Y')->first();

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

        return view('managerrm.detail',[
            'q'=>$q,
            'q_committee_code'=>$q_committee_code,
            'q_dep_code'=>$q_dep_code,
            'q_risk_code'=>$q_risk_code,
            'q_system'=>$q_system,
            'q_person'=>$q_person,
            'q_person_chk'=>$q_person_chk
            ]);
    }

    public function review(Request $request){
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
        }else{
            Alert::error('ไม่สามารถบันทึกข้อมูลได้', 'เกิดข้อผิดพลาด กรุณาติดต่อเจ้าหน้าที่');
        }
        return back();

    }

    public function frmupdate($id){
        $qe = Rmmain::where('rmmain_id',$id)->where('status','Y')->first();
        $q_persons = Person::where('status','Y')->get();
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


        //รหัสความเสี่ยง
        $q_risk_code  = DB::table('rmrisk')
            ->join('co_risk', 'co_risk.risk_code', '=', 'rmrisk.risk_code')
            ->select('rmrisk.risk_code')
            ->where('rmrisk.rmmain_id',$id)
            ->where('co_risk.status','Y')
            ->get();
        //หน่วยงานที่เกี่ยวข้อง
        $q_dep_code  = DB::table('rmdep')
            ->join('co_dep', 'co_dep.dep_code', '=', 'rmdep.dep_code')
            ->select('rmdep.dep_code')
            ->where('rmdep.rmmain_id',$id)
            ->where('co_dep.status','Y')
            ->get();
        //กรรมการที่เกี่ยวข้อง
        $q_committee_code  = DB::table('rmcommittee')
            ->join('co_committee', 'co_committee.committee_code', '=', 'rmcommittee.committee_code')
            ->select('rmcommittee.committee_code')
            ->where('rmcommittee.rmmain_id',$id)
            ->where('co_committee.status','Y')
            ->get();

        return view('managerrm.update',[
            'qe'=>$qe,
            'q_risk_code'=>$q_risk_code,
            'q_dep_code'=>$q_dep_code,
            'q_committee_code'=>$q_committee_code,
            'q_persons'=>$q_persons,
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

    public function updaterm(Request $request){
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

            $this->update_risk_code($request->rmmain_id,$request);
            $this->update_rm_dep($request->rmmain_id,$request);
            $this->update_rm_committee($request->rmmain_id,$request);

            $cidrp =  $request->rm_reporter;
            $person = Person::where('person_cid',$cidrp)->first();
            if($person != '' || $person != null){
                $dep_person_rp = $person->dep_code;
            }else{
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
        }else{
            Alert::error('ไม่สามารถทำรายการได้', 'กรุณาติดต่อเจ้าหน้าที่ผู้ดูแลระบบ');
        }
        return back();
    }

    public function update_risk_code($rmmain_id,$request){
        $e = Rmrisk::where('rmmain_id',$rmmain_id);
        $e->delete();
        foreach($request->rm_risk_code as $item){
            $q = new Rmrisk;
            $q->risk_code = $item; //รหัสความเสี่ยง
            $q->rmmain_id = $rmmain_id; //id ความเสี่ยง (ตาราง rmmain)
            $q->status = "Y"; //สถานะ
            $q->save();
        };
    }

    public function update_rm_dep($rmmain_id,$request){
        $e = Rmdep::where('rmmain_id',$rmmain_id);
        $e->delete();
        foreach($request->rm_dep as $item){
            $q = new Rmdep;
            $q->dep_code = $item; //รหัสหน่วยงาน
            $q->rmmain_id = $rmmain_id; //id ความเสี่ยง (ตาราง rmmain)
            $q->status = "Y"; //สถานะ
            $q->save();
        };
    }

    public function update_rm_committee($rmmain_id,$request){
        $e = Rmcommittee::where('rmmain_id',$rmmain_id);
        $e->delete();
        foreach($request->rm_committee as $item){
            $q = new Rmcommittee;
            $q->committee_code = $item; //รหัสกรรมการความเสี่ยง
            $q->rmmain_id = $rmmain_id; //id ความเสี่ยง (ตาราง rmmain)
            $q->status = "Y"; //สถานะ
            $q->save();
        };
    }

}
