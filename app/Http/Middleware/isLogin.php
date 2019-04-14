<?php

namespace App\Http\Middleware;

use Closure;

class isLogin
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
        // 判断是否已经登录
        if(session()->get('user')){
            return $next($request);
        }else{
            return redirect('admin/login')->with('errors','请登录');
        }
        
    }
}
