<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\P_users;
class RegController extends Controller
{
    //注册用户
    public function index(Request $request){
      $data = $request->all();
      $user_name = $request->post('user_name');

      if($data['password'] != $data['pwds']){
          echo '密码不一致';
          die;
      }

      $usermodel = new P_users();
      $usermodel->user_name = $user_name;
        $usermodel->email = $data['email'];
        $usermodel->password = password_hash($data['password'],PASSWORD_BCRYPT);
        $usermodel->reg_time = time();
      $res = $usermodel->save();

      if($res){
          return redirect('user/login');
      }else{
echo '注册失败';
      }


    }
}
