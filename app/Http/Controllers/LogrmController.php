<?php

namespace App\Http\Controllers;

use DB;
use Alert;

use App\Log_cancel_rm;
use Illuminate\Http\Request;

class LogrmController extends Controller
{
    //log การยกเลิก RM
    public function log_cancel_rm(Request $request){
        if (isset($_POST['btn-submit'])) {
            $q = new Log_cancel_rm;
            $q->rmmain_id = $request->rmmain_id;
            $q->user_id = $request->person_id;
            $q->log_detail = $request->log_detail;
            $q->save();

            $this->rmmain($request);
            Alert::success('ยกเลิกเรียบร้อย', 'กรุณาตรวจสอบความถูกต้องอีกครั้ง');
        }else{
            Alert::error('เกิดข้อผิดพลาด', 'กรุณาแจ้งหน้าที่ผู้ดูแลระบบ');
        }
        return redirect('/managerrm');
    }

    public function rmmain($request){
        $q = DB::table('rmmain')
        ->where('rmmain_id', $request->rmmain_id)
        ->update([
                'status' => 'N', //สถานะความเสี่ยง
        ]);
    }
}
