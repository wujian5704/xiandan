<?php
namespace app\web\controller;

use think\Controller;
use think\Request;
use think\Db;

class Register extends Controller
{
    public function register()
    {
        $loginUrl=url('web/login/login');
        $this->assign('login_url',$loginUrl);

        /*接收注册信息*/
        $registerUrl=url('web/register/registerUrl');
        $this->assign('registerUrl',$registerUrl);
        return $this->fetch();
    }

    /*处理注册提交*/
    public function registerUrl(){
        /*接收页面传递（post）的值*/
        /*检查数据是否有这个变量是否提交*/
        $username=Request::instance()->has('userID','post');
        if($username==true){
            $uname=input('post.userID');      //用户名
            $upsd=input('post.userpsd');      //密码
            $uphone=input('post.PhoneNumber');      //手机
            $email=input('post.usermail');      //邮箱
            $utime=date('y-m-d h:i:s',time());

            $nowuser=[
                'uname'=>$uname,
                'nickname'=>$uname,
                'upsd'=>md5($upsd),
                'uimg'=>'',
                'usex'=>'男',
                'uage'=>'',
                'uphone'=>$uphone,
                'uemail'=>$email,
                'umoney'=>0,
                'paypsd'=>'',
                'ustate'=>'正常',
                'buynum'=>0,
                'utime'=>$utime,
            ];

            $now_user=Db::table('t_user')->insert($nowuser);
            if($now_user==1) {
                $returnJson = [
                    'code' => 10005,
                    'msg' => '账号注册成功',
                    'data' => []
                ];
                return $returnJson;
            }
        }
    }
    /*判断用户是否已经注册*/
    public function userId(){
        $uid=input('post.userID');
        $class=Db::query("select * from t_user where uname='$uid'");
        return json($class);
    }
}