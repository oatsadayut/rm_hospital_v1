<?php

namespace App\Http\Controllers;

use DB;
use Alert;

use App\User;
use App\Permission;
use App\Log_user_event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        if(Auth::user()->permission == 4){
            $permission = Permission::where('status','Y')->whereIn('per_id', [1, 2, 3, 4])->get();
            $q_all = DB::table('users')
            ->join('person', 'person.person_id', '=', 'users.person_id')
            ->join('permission', 'permission.per_id', '=', 'users.permission')
            ->select('person.person_id','users.id','users.cid','users.status_at','person.person_fname','person.person_lname','permission.per_name','permission.per_id')
            ->where('users.status_at','>','0')
            ->get();
        }elseif(Auth::user()->permission == 3){
            $permission = Permission::where('status','Y')->whereNotIn('per_id', [4])->get();
            $q_all = DB::table('users')
            ->join('person', 'person.person_id', '=', 'users.person_id')
            ->join('permission', 'permission.per_id', '=', 'users.permission')
            ->select('person.person_id','users.id','users.cid','users.status_at','person.person_fname','person.person_lname','permission.per_name','permission.per_id')
            ->where('users.status_at','>','0')
            ->where('users.permission','<>','4')
            ->get();
        }

        $q = DB::table('users')
        ->join('person', 'person.person_id', '=', 'users.person_id')
        ->select('person.person_id','users.id','users.cid','users.status_at','person.person_fname','person.person_lname')
        ->where('users.status_at','0')
        ->get();

        $q_count = DB::table('users')
        ->where('users.status_at','0')
        ->count();

        return view('user.index',[
            'q'=>$q,
            'q_all'=>$q_all,
            'q_count'=>$q_count,
            'permission'=>$permission
        ]);
    }

    public function frmsubmit($id){
        if(Auth::user()->permission == 4){
            $permission = Permission::where('status','Y')->whereIn('per_id', [1, 2, 3, 4])->get();
        }elseif(Auth::user()->permission == 3){
            $permission = Permission::where('status','Y')->whereNotIn('per_id', [4])->get();
        }

        $q = DB::table('users')
        ->join('person', 'person.person_id', '=', 'users.person_id')
        ->select('person.person_id','users.id','users.cid','users.status_at','person.person_fname','person.person_lname')
        ->where('users.status_at','0')
        ->where('users.id',$id)
        ->first();

        return view('user.submit',[
            'q'=>$q,
            'permission'=>$permission
        ]);
    }

    public function submit(Request $request){
        if (isset($_POST['btn-submit'])) {
            $this->log_event_submit($request->user_id);

            $q = DB::table('users')
            ->where('id', $request->user_id)
            ->update([
                'permission' => $request->permission,
                'status_at' => '1',
                ]);
            Alert::success('อนุมัติเรียบร้อย', 'อนุมัติเรียบร้อย กรุณาตรวจสอบความถูกต้องอีกครั้ง');
        }else{
            Alert::success('เกิดข้อผิดพลาด', 'ไม่สามารถอนุมัติได้ กรุณาตรวจสอบความถูกต้องอีกครั้ง');
        }
        return redirect('/user');
    }

    public function cancel(Request $request){
        if (isset($_POST['btn-submit'])) {
            $this->log_event_cancel($request->user_cancel_id);

            $q = DB::table('users')
            ->where('id', $request->user_cancel_id)
            ->delete();

            Alert::success('ยกเลิกเรียบร้อย', 'ยกเลิกเรียบร้อย กรุณาตรวจสอบความถูกต้องอีกครั้ง');
        }else{
            Alert::success('เกิดข้อผิดพลาด', 'ไม่สามารถยกเลิกได้ กรุณาตรวจสอบความถูกต้องอีกครั้ง');
        }
        return back();
    }

    public function unblock(Request $request){
        if (isset($_POST['btn-submit'])) {
            $this->log_event_unblock($request->user_unblock_id);

            $q = DB::table('users')
            ->where('id', $request->user_unblock_id)
            ->update([
                'status_at' => '1',
                ]);
            Alert::success('Unblock รายการนี้เรียบร้อย', 'Unblock รายการนี้เรียบร้อย กรุณาตรวจสอบความถูกต้องอีกครั้ง');
        }else{
            Alert::success('เกิดข้อผิดพลาด', 'ไม่สามารถ Unblock ได้ กรุณาตรวจสอบความถูกต้องอีกครั้ง');
        }
        return back();
    }

    public function block(Request $request){
        if (isset($_POST['btn-submit'])) {
            $this->log_event_block($request->user_block_id);

            $q = DB::table('users')
            ->where('id', $request->user_block_id)
            ->update([
                'status_at' => '2',
                ]);
            Alert::success('ยกเลิกใช้งานเรียบร้อย', 'ยกเลิกใช้งานเรียบร้อย กรุณาตรวจสอบความถูกต้องอีกครั้ง');
        }else{
            Alert::success('เกิดข้อผิดพลาด', 'ไม่สามารถยกเลิกได้ กรุณาตรวจสอบความถูกต้องอีกครั้ง');
        }
        return back();
    }

    public function frmedit($id){
        if(Auth::user()->permission == 4){
            $permission = Permission::where('status','Y')->whereIn('per_id', [1, 2, 3, 4])->get();
        }elseif(Auth::user()->permission == 3){
            $permission = Permission::where('status','Y')->whereNotIn('per_id', [4])->get();
        }
        $q_all = DB::table('users')
        ->join('person', 'person.person_id', '=', 'users.person_id')
        ->join('permission', 'permission.per_id', '=', 'users.permission')
        ->select('person.person_id','users.id','users.cid','users.status_at','person.person_fname','person.person_lname','permission.per_name','permission.per_id')
        ->where('users.id',$id)
        ->where('users.status_at','>','0')
        ->first();
        return view('user.edit',[
            'q_all'=>$q_all,
            'permission'=>$permission
            ]);
    }

    public function edit(Request $request){
        if (isset($_POST['btn-submit'])) {
            $this->log_event_edit($request->user_id);

            if($request->password != "" || $request->password != null){
                $q = DB::table('users')
                ->where('id', $request->user_id)
                ->update([
                    'permission' => $request->permission,
                    'password' => Hash::make($request->password),
                ]);
            }else{
                $q = DB::table('users')
                ->where('id', $request->user_id)
                ->update([
                    'permission' => $request->permission,
                ]);
            }

            Alert::success('แก้ไขเรียบร้อย', 'แก้ไขเรียบร้อย กรุณาตรวจสอบความถูกต้องอีกครั้ง');
        }else{
            Alert::success('เกิดข้อผิดพลาด', 'ไม่สามารถแก้ไขได้ กรุณาตรวจสอบความถูกต้องอีกครั้ง');
        }
        return back();
    }


    public function log_event_submit($request){
        $qs = new Log_user_event;
        $qs->user_event_id = $request;
        $qs->staff_id = Auth::user()->id;
        $qs->event = 'Submit';
        $qs->save();
    }

    public function log_event_cancel($request){
        $qs = new Log_user_event;
        $qs->user_event_id = $request;
        $qs->staff_id = Auth::user()->id;
        $qs->event = 'Cancel';
        $qs->save();
    }

    public function log_event_block($request){
        $qs = new Log_user_event;
        $qs->user_event_id = $request;
        $qs->staff_id = Auth::user()->id;
        $qs->event = 'Block';
        $qs->save();
    }

    public function log_event_edit($request){
        $qs = new Log_user_event;
        $qs->user_event_id = $request;
        $qs->staff_id = Auth::user()->id;
        $qs->event = 'Edit';
        $qs->save();
    }

    public function log_event_unblock($request){
        $qs = new Log_user_event;
        $qs->user_event_id = $request;
        $qs->staff_id = Auth::user()->id;
        $qs->event = 'Unblock';
        $qs->save();
    }

}
