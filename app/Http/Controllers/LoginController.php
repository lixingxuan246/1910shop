<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\P_users;

class LoginController extends Controller
{
    //登陆
    public function index(Request $request){
        $data = $request->all();
        $usermodel = new P_users();
        $res = $usermodel->where('user_name','=',$data['user_name'])->first();
//        echo $res['password'];die;

        if($res){    //判断有无此用户：如果有
        if(password_verify($data['password'],$res['password'])){//判断密码是否正确
            $time =time();
            $usermodel->where('user_name','=',$data['user_name'])->update(['last_login'=>$time]);
            echo 'Password is valid!';
        }else{
            echo 'Invalid password.';
        }



        }else{   //如果没有
            echo 'no';
        }
    }
}
