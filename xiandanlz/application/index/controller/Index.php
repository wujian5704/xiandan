<?php
namespace app\index\controller;
use \think\Controller;
use think\Session;

class Index extends Controller
{
    public function index()
    {
//        $uname=Session::get('uname');
//        $nickname=Session::get('nickname');
//        if($uname!='' && $nickname!=''){
//            $this->assign('uname',$uname);
//            $this->assign('nickname',$nickname);
//        }
       return  $this->fetch();
    }

    public function user(){
        $nickname=Session::get('nickname');
        $user=[
            'nickname'=>$nickname,
        ];
        return json($user);
    }
}
