<?php

namespace App\Http\Controllers;

use DB;
use Alert;

use App\Co_source;
use App\Co_dep;
use App\Co_dep_srp;
use App\Co_effect;
use App\Co_affected_person;
use App\Co_affected_person_srp;
use App\Co_specd;
use App\Co_clinic;
use App\Co_risk;
use App\Co_risk_srp;
use App\Co_committee;
use App\Co_riskgroup;

// สรพ.
use App\Co_subgroup_risk;
use App\Co_riskgroup_srp;
use App\Co_category_risk;
use App\Co_subcategory_risk;
use Illuminate\Http\Request;

class RmcodeController extends Controller
{
    public function index(){
        $committee_p2 = Co_committee::where('status','Y')->get();
        $riskcode_srp_p2 = Co_risk_srp::where('status','Y')->get();
        $riskgroup_p2 = Co_riskgroup::where('status','Y')->get();
        $clinic_p2 = Co_clinic::where('status','Y')->get();

        $committee = Co_committee::all();
        $riskcode = Co_risk::all();
        $riskcode_srp = Co_risk_srp::all();
        $riskgroup = Co_riskgroup::all();
        $source = Co_source::all();
        $effect = Co_effect::all();
        $clinic = Co_clinic::all();
        $specd = Co_specd::all();
        $dep = Co_dep::all();
        $dep_srp = Co_dep_srp::all();
        $affected = Co_affected_person::all();
        $affected_srp = Co_affected_person_srp::all();

        return view('rmcode.index',[
            'committee_p2'=>$committee_p2,
            'riskcode_srp_p2'=>$riskcode_srp_p2,
            'riskgroup_p2'=>$riskgroup_p2,
            'clinic_p2'=>$clinic_p2,
            'riskgroup'=>$riskgroup,
            'committee'=>$committee,
            'source'=>$source,
            'riskcode'=>$riskcode,
            'riskcode_srp'=>$riskcode_srp,
            'effect'=>$effect,
            'specd'=>$specd,
            'clinic'=>$clinic,
            'dep'=>$dep,
            'dep_srp'=>$dep_srp,
            'affected'=>$affected,
            'affected_srp'=>$affected_srp
        ]);
    }

    //แหล่งข้อมูล
    public function frmsource($id){
        $qe = Co_source::where('source_code',$id)->first();
        return view('rmcode.tabcontent.edit.editsource',['qe'=>$qe]);
    }
    public function addsource(Request $request){
        if (isset($_POST['btn-submit'])) {
            DB::table('co_source')->insert([
                'source_name' => $request->source_name,
                'status' => $request->status
            ]);
            Alert::success('บันทึกข้อมูลเรียบร้อย', 'บันทึกข้อมูลเรียบร้อย กรุณาตรวจสอบอีกครั้ง');
        }
        return back();
    }
    public function editsource(Request $request){
        if (isset($_POST['btn-submit'])) {
            $q = DB::table('co_source')
            ->where('source_code', $request->code)
            ->update([
                    'source_name' => $request->source_name,
                    'status' => $request->status,
            ]);
            Alert::success('แก้ไข้ข้อมูลเรียบร้อย', 'แก้ไข้ข้อมูลเรียบร้อย กรุณาตรวจสอบอีกครั้ง');
        }
        return back();
    }

    //หน่วยงาน
    public function frmdep($id){
        $qe = Co_dep::where('dep_code',$id)->first();
        $dep_srp = Co_dep_srp::all();
        return view('rmcode.tabcontent.edit.editdep',['qe'=>$qe,'dep_srp'=>$dep_srp]);
    }
    public function adddep(Request $request){
        if (isset($_POST['btn-submit'])) {
            DB::table('co_dep')->insert([
                'dep_name' => $request->dep_name,
                'dep_ename' => $request->dep_ename,
                'place' => $request->place,
                'status' => $request->status
            ]);
            Alert::success('บันทึกข้อมูลเรียบร้อย', 'บันทึกข้อมูลเรียบร้อย กรุณาตรวจสอบอีกครั้ง');
        }
        return back();
    }
    public function editdep(Request $request){
        if (isset($_POST['btn-submit'])) {
            $q = DB::table('co_dep')
            ->where('dep_code', $request->code)
            ->update([
                    'dep_name' => $request->dep_name,
                    'dep_ename' => $request->dep_ename,
                    'place' => $request->place,
                    'status' => $request->status,
            ]);
            Alert::success('แก้ไข้ข้อมูลเรียบร้อย', 'แก้ไข้ข้อมูลเรียบร้อย กรุณาตรวจสอบอีกครั้ง');
        }
        return back();
    }

    //ผู้ได้รับผลกระทบ
    public function frmaffected($id){
        $qe = Co_affected_person::where('affected_code',$id)->first();
        $affected_srp = Co_affected_person_srp::all();
        return view('rmcode.tabcontent.edit.editaffected',['qe'=>$qe,'affected_srp'=>$affected_srp]);
    }
    public function addaffected(Request $request){
        if (isset($_POST['btn-submit'])) {
            DB::table('co_affected_person')->insert([
                'affected_name' => $request->affected_name,
                'export_code' => $request->export_code,
                'status' => $request->status
            ]);
            Alert::success('บันทึกข้อมูลเรียบร้อย', 'บันทึกข้อมูลเรียบร้อย กรุณาตรวจสอบอีกครั้ง');
        }
        return back();
    }
    public function editaffected(Request $request){
        if (isset($_POST['btn-submit'])) {
            $q = DB::table('co_affected_person')
            ->where('affected_code', $request->code)
            ->update([
                'affected_name' => $request->affected_name,
                'export_code' => $request->export_code,
                'status' => $request->status
            ]);
            Alert::success('แก้ไข้ข้อมูลเรียบร้อย', 'แก้ไข้ข้อมูลเรียบร้อย กรุณาตรวจสอบอีกครั้ง');
        }
        return back();
    }

    //ผลกระทบ
    public function frmeffect($id){
        $qe = Co_effect::where('effect_code',$id)->first();
        return view('rmcode.tabcontent.edit.editeffect',['qe'=>$qe]);
    }
    public function addeffect(Request $request){
        if (isset($_POST['btn-submit'])) {
            DB::table('co_effect')->insert([
                'effect_name' => $request->effect_name,
                'status' => $request->status
            ]);
            Alert::success('บันทึกข้อมูลเรียบร้อย', 'บันทึกข้อมูลเรียบร้อย กรุณาตรวจสอบอีกครั้ง');
        }
        return back();
    }
    public function editeffect(Request $request){
        if (isset($_POST['btn-submit'])) {
            $q = DB::table('co_effect')
            ->where('effect_code', $request->code)
            ->update([
                'effect_name' => $request->effect_name,
                'status' => $request->status
            ]);
            Alert::success('แก้ไข้ข้อมูลเรียบร้อย', 'แก้ไข้ข้อมูลเรียบร้อย กรุณาตรวจสอบอีกครั้ง');
        }
        return back();
    }

    //โรคเฉพาะ
    public function frmspecd($id){
        $qe = Co_specd::where('specd_code',$id)->first();
        return view('rmcode.tabcontent.edit.editspecd',['qe'=>$qe]);
    }
    public function addspecd(Request $request){
        if (isset($_POST['btn-submit'])) {
            DB::table('co_specd')->insert([
                'specd_name' => $request->specd_name,
                'status' => $request->status
            ]);
            Alert::success('บันทึกข้อมูลเรียบร้อย', 'บันทึกข้อมูลเรียบร้อย กรุณาตรวจสอบอีกครั้ง');
        }
        return back();
    }
    public function editspecd(Request $request){
        if (isset($_POST['btn-submit'])) {
            $q = DB::table('co_specd')
            ->where('specd_code', $request->code)
            ->update([
                'specd_name' => $request->specd_name,
                'status' => $request->status
            ]);
            Alert::success('แก้ไข้ข้อมูลเรียบร้อย', 'แก้ไข้ข้อมูลเรียบร้อย กรุณาตรวจสอบอีกครั้ง');
        }
        return back();
    }

    //ชนิดความเสี่ยง
    public function frmclinic($id){
        $qe = Co_clinic::where('clinic_code',$id)->first();
        return view('rmcode.tabcontent.edit.editclinic',['qe'=>$qe]);
    }
    public function addclinic(Request $request){
        if (isset($_POST['btn-submit'])) {
            DB::table('co_clinic')->insert([
                'clinic_name' => $request->clinic_name,
                'status' => $request->status
            ]);
            Alert::success('บันทึกข้อมูลเรียบร้อย', 'บันทึกข้อมูลเรียบร้อย กรุณาตรวจสอบอีกครั้ง');
        }
        return back();
    }
    public function editclinic(Request $request){
        if (isset($_POST['btn-submit'])) {
            $q = DB::table('co_clinic')
            ->where('clinic_code', $request->code)
            ->update([
                'clinic_name' => $request->clinic_name,
                'status' => $request->status
            ]);
            Alert::success('แก้ไข้ข้อมูลเรียบร้อย', 'แก้ไข้ข้อมูลเรียบร้อย กรุณาตรวจสอบอีกครั้ง');
        }
        return back();
    }

    //รหัสความเสี่ยง
    public function frmriskcode($id){
        $qe = Co_risk::where('risk_code',$id)->first();
        $committee = Co_committee::all();
        $riskgroup = Co_riskgroup::all();
        $riskcode_srp = Co_risk_srp::all();
        $clinic = Co_clinic::all();
        return view('rmcode.tabcontent.edit.editriskcode',[
            'qe'=>$qe,
            'committee'=>$committee,
            'riskgroup'=>$riskgroup,
            'riskcode_srp'=>$riskcode_srp,
            'clinic'=>$clinic

            ]);
    }
    public function addriskcode(Request $request){
        if (isset($_POST['btn-submit'])) {
            DB::table('co_risk')->insert([
                'risk_name' => $request->risk_name,
                'riskgroup_code' => $request->riskgroup_code,
                'committee_code' => $request->committee_code,
                'clinic_code' => $request->clinic_code,
                'export_code' => $request->export_code,
                'status' => $request->status
            ]);
            Alert::success('บันทึกข้อมูลเรียบร้อย', 'บันทึกข้อมูลเรียบร้อย กรุณาตรวจสอบอีกครั้ง');
        }
        return back();
    }
    public function editriskcode(Request $request){
        if (isset($_POST['btn-submit'])) {
            $q = DB::table('co_risk')
            ->where('risk_code', $request->code)
            ->update([
                'risk_name' => $request->risk_name,
                'riskgroup_code' => $request->riskgroup_code,
                'committee_code' => $request->committee_code,
                'clinic_code' => $request->clinic_code,
                'export_code' => $request->export_code,
                'status' => $request->status
            ]);
            Alert::success('แก้ไข้ข้อมูลเรียบร้อย', 'แก้ไข้ข้อมูลเรียบร้อย กรุณาตรวจสอบอีกครั้ง');
        }
        return back();
    }

    //รหัสกรรมการ
    public function frmcommittee($id){
        $qe = Co_committee::where('committee_code',$id)->first();
        return view('rmcode.tabcontent.edit.editcommittee',[
            'qe'=>$qe,
            ]);
    }
    public function addcommittee(Request $request){
        if (isset($_POST['btn-submit'])) {
            DB::table('co_committee')->insert([
                'committee_name' => $request->committee_name,
                'status' => $request->status
            ]);
            Alert::success('บันทึกข้อมูลเรียบร้อย', 'บันทึกข้อมูลเรียบร้อย กรุณาตรวจสอบอีกครั้ง');
        }
        return back();
    }
    public function editcommittee(Request $request){
        if (isset($_POST['btn-submit'])) {
            $q = DB::table('co_committee')
            ->where('committee_code', $request->code)
            ->update([
                'committee_name' => $request->committee_name,
                'status' => $request->status
            ]);
            Alert::success('แก้ไข้ข้อมูลเรียบร้อย', 'แก้ไข้ข้อมูลเรียบร้อย กรุณาตรวจสอบอีกครั้ง');
        }
        return back();
    }

    //หน่วยงาน สรพ
    public function frmsrpdep($id){
        $qe = Co_dep_srp::where('dep_srp_id',$id)->first();
        return view('rmcode.tabcontent.edit.editsrpdep',['qe'=>$qe]);
    }

    public function addsrpdep(Request $request){
        if (isset($_POST['btn-submit'])) {
            DB::table('co_dep_srp')->insert([
                'dep_srp_name' => $request->dep_srp_name,
                'dep_srp_export_code' => $request->dep_srp_export_code
            ]);
            Alert::success('บันทึกข้อมูลเรียบร้อย', 'บันทึกข้อมูลเรียบร้อย กรุณาตรวจสอบอีกครั้ง');
        }
        return back();
    }

    public function editsrpdep(Request $request){
        if (isset($_POST['btn-submit'])) {
            $q = DB::table('co_dep_srp')
            ->where('dep_srp_id', $request->code)
            ->update([
                    'dep_srp_name' => $request->dep_srp_name,
                    'dep_srp_export_code' => $request->dep_srp_export_code
            ]);
            Alert::success('แก้ไข้ข้อมูลเรียบร้อย', 'แก้ไข้ข้อมูลเรียบร้อย กรุณาตรวจสอบอีกครั้ง');
        }
        return back();
    }

    //รหัสส่งออก ผู้ได้รับผลกระทบ สรพ.
    public function frmsrpaffected($id){
        $qe = Co_affected_person_srp::where('affected_srp_id',$id)->first();
        return view('rmcode.tabcontent.edit.editsrpaffected',['qe'=>$qe]);
    }

    public function addsrpaffected(Request $request){
        if (isset($_POST['btn-submit'])) {
            DB::table('co_affected_person_srp')->insert([
                'affected_srp_name' => $request->affected_srp_name,
                'affected_export_code' => $request->affected_export_code,
                'status' => $request->status,
            ]);
            Alert::success('บันทึกข้อมูลเรียบร้อย', 'บันทึกข้อมูลเรียบร้อย กรุณาตรวจสอบอีกครั้ง');
        }
        return back();
    }

    public function editsrpaffected(Request $request){
        if (isset($_POST['btn-submit'])) {
            $q = DB::table('co_affected_person_srp')
            ->where('affected_srp_id', $request->code)
            ->update([
                    'affected_srp_name' => $request->affected_srp_name,
                    'affected_export_code' => $request->affected_export_code,
                    'status' => $request->status
            ]);
            Alert::success('แก้ไข้ข้อมูลเรียบร้อย', 'แก้ไข้ข้อมูลเรียบร้อย กรุณาตรวจสอบอีกครั้ง');
        }
        return back();
    }

    //รหัสความเสี่ยง สรพ.
    public function frmsrpriskcode($id){
        $qe = Co_risk_srp::where('code_srp_id',$id)->first();

        $subgroup_risk = Co_subgroup_risk::all();
        $riskgroup_srp = Co_riskgroup_srp::all();
        $category_risk = Co_category_risk::all();
        $subcategory_risk = Co_subcategory_risk::all();

        return view('rmcode.tabcontent.edit.editsrpriskcode',[
                'qe'=>$qe,
                'subgroup_risk'=>$subgroup_risk,
                'riskgroup_srp'=>$riskgroup_srp,
                'category_risk'=>$category_risk,
                'subcategory_risk'=>$subcategory_risk
            ]);
    }

    public function addsrpriskcode(Request $request){
        if (isset($_POST['btn-submit'])) {
            DB::table('co_code_srp_risk')->insert([
                'code_export_srp' => $request->code_export_srp,
                'name_srp_risk' => $request->name_srp_risk,
                'riskgroup_code' => $request->riskgroup_code,
                'subgroup_srp_risk' => $request->subgroup_srp_risk,
                'category_srp_risk' => $request->category_srp_risk,
                'subcategory_srp_risk' => $request->subcategory_srp_risk,
                'status' => $request->status
            ]);
            Alert::success('บันทึกข้อมูลเรียบร้อย', 'บันทึกข้อมูลเรียบร้อย กรุณาตรวจสอบอีกครั้ง');
        }
        return back();
    }

    public function editsrpriskcode(Request $request){
        if (isset($_POST['btn-submit'])) {
            $q = DB::table('co_code_srp_risk')
            ->where('code_srp_id', $request->code)
            ->update([
                'code_export_srp' => $request->code_export_srp,
                'name_srp_risk' => $request->name_srp_risk,
                'riskgroup_code' => $request->riskgroup_code,
                'subgroup_srp_risk' => $request->subgroup_srp_risk,
                'category_srp_risk' => $request->category_srp_risk,
                'subcategory_srp_risk' => $request->subcategory_srp_risk,
                'status' => $request->status
            ]);
            Alert::success('แก้ไข้ข้อมูลเรียบร้อย', 'แก้ไข้ข้อมูลเรียบร้อย กรุณาตรวจสอบอีกครั้ง');
        }
        return back();
    }

    // ****************************************************** frmview manager Rmcode  *********************************************

    //ผู้ได้รับผลกระทบ
    public function view_manager_affected(){
        $affected = Co_affected_person::all();
        $affected_srp = Co_affected_person_srp::all();

        return view('rmcode.tabcontent.manage.m_affected',[
            'affected'=>$affected,
            'affected_srp'=>$affected_srp

        ]);
    }

    //โรคเฉพาะ
    public function view_manager_clinic(){
        $clinic = Co_clinic::all();
        return view('rmcode.tabcontent.manage.m_clinic',[
            'clinic'=>$clinic
        ]);
    }

    //กรรมการที่เกี่ยวข้อง
    public function view_manager_committee(){
        $committee = Co_committee::all();
        return view('rmcode.tabcontent.manage.m_committee',[
            'committee'=>$committee
        ]);
    }

    //หน่วยงาน
    public function view_manager_dep(){
        $dep = Co_dep::all();
        $dep_srp = Co_dep_srp::all();
        return view('rmcode.tabcontent.manage.m_dep',[
            'dep'=>$dep,
            'dep_srp'=>$dep_srp
        ]);
    }

    //ผลกระทบ
    public function view_manager_effect(){
        $effect = Co_effect::all();
        return view('rmcode.tabcontent.manage.m_effect',[
            'effect'=>$effect
        ]);
    }

    //รหัสความเสี่ยง
    public function view_manager_riskcode(){
        $committee_p2 = Co_committee::where('status','Y')->get();
        $riskcode_srp_p2 = Co_risk_srp::where('status','Y')->get();
        $riskgroup_p2 = Co_riskgroup::where('status','Y')->get();
        $clinic_p2 = Co_clinic::where('status','Y')->get();

        $riskcode = Co_risk::all();
        $riskcode_srp = Co_risk_srp::all();

        return view('rmcode.tabcontent.manage.m_riskcode',[
            'riskcode'=>$riskcode,
            'riskcode_srp'=>$riskcode_srp,
            'committee_p2'=>$committee_p2,
            'riskcode_srp_p2'=>$riskcode_srp_p2,
            'riskgroup_p2'=>$riskgroup_p2,
            'clinic_p2'=>$clinic_p2
        ]);
    }

    //แหล่งข้อมูล
    public function view_manager_source(){
        $source = Co_source::all();
        return view('rmcode.tabcontent.manage.m_source',[
            'source'=>$source
        ]);
    }

    //โรคเฉพาะ
    public function view_manager_specd(){
        $specd = Co_specd::all();
        return view('rmcode.tabcontent.manage.m_specd',[
            'specd'=>$specd
        ]);
    }

    //รหัสส่งออกหน่วยงาน
    public function view_manager_srpdep(){
        $dep_srp = Co_dep_srp::all();
        return view('rmcode.tabcontent.manage.m_srpdep',[
            'dep_srp'=>$dep_srp
        ]);
    }

    //รหัสส่งออกผู้ได้รับผลกระทบ
    public function view_manager_srpaffected(){
        $affected_srp = Co_affected_person_srp::all();
        return view('rmcode.tabcontent.manage.m_srpaffected',[
            'affected_srp'=>$affected_srp
        ]);
    }

    //รหัสส่งออกผู้ได้รับผลกระทบ
    public function view_manager_srpriskcode(){
        $riskcode_srp = Co_risk_srp::all();

        $subgroup_risk = Co_subgroup_risk::where('status','Y')->get();
        $riskgroup_srp = Co_riskgroup_srp::where('status','Y')->get();
        $category_risk = Co_category_risk::where('status','Y')->get();
        $subcategory_risk = Co_subcategory_risk::where('status','Y')->get();

        return view('rmcode.tabcontent.manage.m_srpriskcode',[
            'riskcode_srp'=>$riskcode_srp,
            'subgroup_risk'=>$subgroup_risk,
            'riskgroup_srp'=>$riskgroup_srp,
            'category_risk'=>$category_risk,
            'subcategory_risk'=>$subcategory_risk
        ]);
    }

}
