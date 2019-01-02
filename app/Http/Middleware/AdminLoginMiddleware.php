<?php

namespace App\Http\Middleware;
use Auth;
use Closure;

class adminLoginMiddleware {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //Kiểm tra xem có user đăng nhập không thông qua Auth
        if (Auth::check()) {
            //Kiểm tra xem có phải admin không qua cột lavel ở bảng users = 1: admin
            $user = Auth::user();
            if ($user->level == '1') {
                return $next($request);  // Làm tiếp bước tiếp theo
            }
            else{
                return redirect()->route('getloginPage')->with('thongbao',"Bạn không có quyền truy cập Admin");
            }
        }else{
            return redirect()->route('getloginPage')->with('thongbao',"Bạn không có quyền truy cập Admin");
        }
    }
}
