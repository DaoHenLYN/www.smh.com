<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Admin\User;
use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder; 
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Session;
class LoginController extends Controller
{
    //后台登录页面
    public function login()
    {
        return view('admin.login');
    }

    //生成验证码方法
    public function captcha($tmp)
    {
        $phrase = new PhraseBuilder;
        //设置验证码位数
        $code = $phrase->build(4);
        //生成验证码图片的Builder对象，配置相应属性
        $builder = new CaptchaBuilder($code, $phrase);
        //设置背景颜色
        $builder->setBackgroundColor(123, 203, 230);
        $builder->setMaxAngle(27);
        $builder->setMaxBehindLines(203);
        $builder->setMaxFrontLines(123);
        //可以设置图片宽高及字体
        $builder->build($width = 90, $height = 35, $font = null);
        // 获取验证码的内容
        $phrase = $builder->getPhrase();
        //把内容存入session
        \Session::flash('code', $phrase);
        //生成图片
        header("Cache-Control: no-cache, must-revalidate");
        header("Content-Type:image/jpeg");
        $builder->output();
    }

    // 登录处理
    public function dologin(Request $request)
    {
        // 1.获取用户提交的数据
        $input = $request -> except('_token');
        
        // dd($input);
        // 2.对提交的数据进行验证
        // 验证规则
        
        $rule =[
            'username'=>'required|between:4,10',
            'password'=>'required|between:4,10',
            'captcha'=>'required',
        ];
        $smg = [
            'username.required'=>'用户名必须不能为空',
            'username.between'=>'用户名必须在4-10位之间',
            'password.required'=>'密码必须不能为空',
            'password.between'=>'密码必须在4-10位之间',
            'captcha.required'=>'验证码不能为空',
        ];
        $validator = Validator::make($input,$rule,$smg);

        if ($validator->fails()) {
            return redirect('admin/login')
                        ->withErrors($validator)
                        ->withInput();
        }
        
        // 判断验证码是否正确
        if(strtolower($input['captcha']) != strtolower(session()->get('code'))){
            return redirect('admin/login')->with('errors','验证码错误');
        }

        // 判断用户是存在11
        $user = User::where('user_name',$input['username'])->first();
        if(!$user){
            return redirect('admin/login')->with('errors','用户名不存在');
        }
        // 判断密码是否正确（crypt:laravel的加密）
        if($input['password'] != Crypt::decrypt($user->user_pass)){
            return redirect('admin/login')->with('errors','密码错误');

        }
        // 保存用户到session中
        Session::put('user',$user);
        // 下面的方法是去session中的值
        // session()get('user')->username;
        
        // 如果验证都正确的话，跳转页面
        return redirect('admin/index');
    }
    // 加密
    // public function jiami(){
    //     $str = '123456';
    //     $ca = Crypt::encrypt($str);
    //     return $ca;
    // }
}
