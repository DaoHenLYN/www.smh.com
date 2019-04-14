<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    //后台首页
    public function index()
    {
        return view('admin.index');
    }
    // 欢迎页面
    public function welcome()
    {
        return view('admin.welcome');
    }
    // 退出登录
    public function logout()
    {
        // 清空session中的用户数据
        session()->forget('user');
        return redirect('admin/login');
    }
}
