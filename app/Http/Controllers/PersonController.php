<?php

namespace App\Http\Controllers;

use DB;
use Alert;

use App\Co_dep;
use App\Person;
use Illuminate\Http\Request;

class PersonController extends Controller
{
    public function index(){
        $g_person = "";
        $person  = DB::table('person')
        ->leftJoin('co_dep', 'person.dep_code', '=', 'co_dep.dep_code')
        ->select('person.person_id','person.person_cid','person.person_fname','person.person_lname','person.dep_code','person.status','co_dep.dep_name')
        ->get();

        $dep = Co_dep::where('status','Y')->get();
        return view('person.index',[
            'person'=>$person,
            'dep'=>$dep,
            'g_person'=>$g_person
        ]);
    }

    public function add(Request $request){
        $request->validate([
            'person_cid' => 'required',
            'person_fname' => 'required',
            'person_lname' => 'required',
            'dep_code' => 'required',

        ]);

        if (isset($_POST['btn-submit'])) {

            $person = Person::where('person_cid',$request->person_cid)->count();
            if($person == 0){
                $q = new Person;
                $q->person_cid = $request->person_cid;
                $q->person_fname = $request->person_fname;
                $q->person_lname = $request->person_lname;
                $q->dep_code = $request->dep_code;
                $q->status = $request->status;
                $q->save();
                Alert::success('บันทึกข้อมูลเรียบร้อย', 'บันทึกข้อมูลบุคลากรเรียบร้อย กรุณาตรวจสอบความถูกต้องอีกครั้ง');
            }else{
                Alert::error('เกิดข้อผิดพลาด', 'มีผู้ใช้เลขบัตรประชาชนนี้แล้ว กรุณาตรวจสอบอีกครั้ง');
            }

        }else{
            Alert::error('เกิดข้อผิดพลาด', 'ไม่สามารถบันทึกข้อมูลบุคลากรได้ กรุณาตรวจสอบอีกครั้ง');
        }

        return back();
    }

    public function get_person($id){
        $dep = Co_dep::where('status','Y')->get();
        $g_person = Person::where('person_id',$id)->first();
        return view('person.update',['g_person'=>$g_person,'dep'=>$dep]);
    }

    public function update(Request $request){
        if (isset($_POST['btn-submit'])) {
            $q = DB::table('person')
            ->where('person_id', $request->person_id)
            ->update([
                'person_fname' => $request->person_fname,
                'person_lname' => $request->person_lname,
                'dep_code' => $request->dep_code,
                'status' => $request->status
                ]);
            Alert::success('แก้ไขข้อมูลเรียบร้อย', 'แก้ไขข้อมูลบุคลากรเรียบร้อย กรุณาตรวจสอบความถูกต้องอีกครั้ง');
        }else{
            Alert::error('เกิดข้อผิดพลาด', 'ไม่สามารถบันทึกข้อมูลบุคลากรได้ กรุณาตรวจสอบอีกครั้ง');
        }
        return back();
    }
}
