<?php
namespace app\index\controller;
use \think\Controller;
use think\Session;

class Index extends Controller
{
    public function index()
    {
       return  $this->fetch();
    }


    //获取登录用户昵称
    public function user(){
        $nickname=Session::get('nickname');
        $uname=Session::get('uname');
        $user=[
            'nickname'=>$nickname,
            'uname'=>$uname
        ];
        return json($user);
    }

    //退出
    public function quit(){
        Session::delete('uname');
        Session::delete('nickname');
        return  $this->fetch('index');
    }
}
