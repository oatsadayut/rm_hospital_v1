<?php

namespace App\Http\Middleware;

use DB;
use Alert;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class Checkuser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::check() && Auth::user()->status_at == 1){
            if(Auth::user()->permission == 1 || Auth::user()->permission == 2 || Auth::user()->permission == 3 || Auth::user()->permission == 4){
                if(Auth::user()->id){
                    $this->log_auth(Auth::user()->id);
                }
                return $next($request);
            }else{
                Alert::warning('เกิดข้อผิดพลาด', 'บัญชีนี้ไม่มีสิทธิ์การใช้งานระบบ กรุณาติดต่อเจ้าหน้าที่');
                Auth::logout();
                return redirect('/');
            }
        }else{
            Alert::warning('เกิดข้อผิดพลาด', 'บัญชีนี้ยังไม่ได้รับการอนุมัติ หรือ ถูกยกเลิก กรุณาติดต่อเจ้าหน้าที่');
            Auth::logout();
            return redirect('/');
        }
    }

    public function log_auth($userid){
        $ipclient = \Request::getClientIp(true);
        $d = date('Y-m-d H:i:s');
        $log_auth = DB::table('log_auth')->insert([
            'log_auth_event'=>'login',
            'log_auth_userid'=>$userid,
            'log_auth_time'=>$d,
            'log_auth_ip'=>$ipclient
        ]);
    }
}
