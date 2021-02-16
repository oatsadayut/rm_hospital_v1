<?php

namespace App\Http\Middleware;

use Alert;
use Closure;
use Illuminate\Support\Facades\Auth;

class Checkmember
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
            if(Auth::user()->permission == 2 || Auth::user()->permission == 3 || Auth::user()->permission == 4){
                return $next($request);
            }else{
                Alert::warning('เกิดข้อผิดพลาด', 'ไม่มีสิทธิ์การใช้งาน กรุณาติดต่อเจ้าหน้าที่');
                return redirect('/');
            }
        }else{
            Alert::warning('เกิดข้อผิดพลาด', 'บัญชีนี้ยังไม่ได้รับการอนุมัติ หรือ ถูกยกเลิก กรุณาติดต่อเจ้าหน้าที่');
            Auth::logout();
            return redirect('/');
        }
    }
}
