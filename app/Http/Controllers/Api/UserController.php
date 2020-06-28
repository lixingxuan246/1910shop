<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\P_users;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Redis;
class UserController extends Controller
{
    //用户注册
    public function reg(Request $request){
        //接收数据
        $data = $request->all();
        $user_name = $request->post('user_name');
        $len = strlen($data['password']);
        //密码长度是否大于6
        if($len<6){
            $response =[
              'errno' => 500001,
              'msg' => '密码长度必须大于6'
            ];
            return $response;
//            die("密码长度必须大于6");
        }
        //两次密码要一致
        if($data['password'] != $data['pwds']){
            $response =[
                'errno' => 500001,
                'msg' => '密码必须保持一致'
            ];
            return $response;
        }

        $usermodel = new P_users();
        $usermodel->user_name = $user_name;
        $usermodel->email = $data['email'];
        $usermodel->password = password_hash($data['password'],PASSWORD_BCRYPT);
        $usermodel->reg_time = time();
        $res = $usermodel->save();

        if($res){
            $response =[
                'errno' => 500001,
                'msg' => '注册成功'
            ];
            return $response;
//            return redirect('user/login');
        }else{
            echo '注册失败';
            $response =[
                'errno' => 500002,
                'msg' => '注册失败'
            ];
            return $response;
        }


    }

    //用户登陆
    public function login(Request $request){
        $data = $request->all();
        $usermodel = new P_users();
        $res = $usermodel->where('user_name','=',$data['user_name'])->first();
//        echo $res['password'];die;

        if($res){    //判断有无此用户：如果有
            if(password_verify($data['password'],$res['password'])){//判断密码是否正确
                $time =time();
                $usermodel->where('user_name','=',$data['user_name'])->update(['last_login'=>$time]);
                //存cookie
//            setcookie('uid',$res->user_id,time()+3600,'/');
//            setcookie('name',$res->user_name,time()+3600,'/');
                Cookie::queue('uid2',$res->user_id,10);
                //            print_r($_COOKIE);
                if(isset($_COOKIE['uid2']) ){
                    echo 'Password is valid! 11111111';
                    //生成token
                    $str = $res->user_id . $res->user_name . time();
                    $token = substr(md5($str),10,16) . substr(md5($str),0,10);

                    //将token保存在redis中
                    Redis::set($token,$res->user_id);       // sldkfjslkfj 1234

                    $response = [
                        'errno' => 0,
                        'msg'   => 'ok',
                        'token' => $token
                    ];
                    return $response;

                }else{
                    echo 'Password is valid! 22222222';

                }
                echo 'Password is valid!';
            }else{
                echo 'Invalid password.';
            }



        }else{   //如果没有
            echo 'no';
        }
    }

}
