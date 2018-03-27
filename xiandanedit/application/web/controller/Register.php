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
            $uid=input('post.userID');      //用户id
            $uname=input('post.username');      //用户名
            $upsd=input('post.userpsd');      //密码
            $uphone=input('post.PhoneNumber');      //手机
            $email=input('post.usermail');      //邮箱
            $utime=date('y-m-d h:i:s',time());

            $nowuser=[
                'uid'=>$uid,
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
                'buynumber'=>0,
                'utime'=>$utime,
            ];

            $now_user=Db::table('t_user')->insert($nowuser);
//            var_dump($now_user);
            if($now_user==1) {
                $returnJson = [
                    'code' => 10005,
                    'msg' => '账号注册成功',
                    'data' => []
                ];
                return $returnJson;
            }
        }
//        if($username){
//            /* $id     =input('post.id','',FILTER_VALIDATE_INT);*/
//
//            $userID         =input('post.userID');
//            $userpsd        =input('post.userpsd');
//            $username       =input('post.username');
//            $usermail       =input('post.usermail');
//            $mobile         =input('post.PhoneNumber');
//            $userTime       =date('y-m-d h:i:s',time());
//            $userimg        ="avator1.png";
//            $user=[
//                'userID'        =>$userID,
//                'userpsd'       => md5($userpsd),
//                'username'      => $username,
//                'usermail'      => $usermail,
//                'mobile'        => $mobile,
//                'userTime'      =>$userTime,
//                'userimg'       =>$userimg
//            ];
//
//
//            $sql="insert into t_user (";
//            $string='';
//            if(is_array($user)){
//                foreach($user as $key=>$val)
//                {
//                    $string.="{$key},";
//                }
//                $string=substr($string,0,-1);
//                $string.=')values(';
//                foreach($user as $key=>$val)
//                {
//                    $string.="'{$val}',";
//                }
//                $string=substr($string,0,-1);
//                $string.=');';
//            }
//            $sql.=$string;
//            $class=Db::execute("$sql");
//            echo $class;
//            if($class==false){
//                /*注册失败，做提示*/
//                $this->error('注册失败','web/register/register',3);
//            }else{
//                echo "<script>
//                            //通信
//                            //创建客户端socket
//                            var client=new WebSocket('ws://120.78.157.124:9527');
//                            //链接服务器
//                            client.onopen=function()
//                            {
//                                //发消息给服务器  存储socket
//                                client.send(JSON.stringify({
//                                    type:'addSocket',
//                                    sender:$userID,
//                                    reciver:'',
//                                    content:'',
//                                    date:''
//                                }));
//                            }
//                        </script>";
//                $this->success('注册成功','web/login/login',3);
//            }
//
//
//        }
    }
    /*判断用户是否已经注册*/
    public function userId(){
        $uid=input('post.userID');
        $class=Db::query("select * from t_user where uid='$uid'");
        return json($class);
    }
}