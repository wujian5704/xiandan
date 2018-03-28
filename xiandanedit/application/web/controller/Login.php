<?php
namespace app\web\controller;

use think\Controller;
use think\Request;
use think\Session;
use think\Db;

define('APPID',"");
define('APPKEY',"");
class Login extends Controller
{
    public function login()
    {

        $loginUrl=url('index/index/index');
        $this->assign('login_url',$loginUrl);

        $register=url('web/register/register');
        $this->assign('register_url',$register);
        return $this->fetch();
    }
//    public function log(){
//        /*通过Authorization Code获取Access Token*/
//        $a=input("get.code");
//        $url="https://graph.qq.com/oauth2.0/token?grant_type=authorization_code&client_id=".APPID."&client_secret=".APPKEY."&code=$a&redirect_uri=https://www.wc007.xin/web/login/log.html";
//
//        $ASSCETOKEN=$this->curlHttp($url,"GET",[]);
//
//        //var_dump($ASSCETOKEN);
//        $j=explode("&",$ASSCETOKEN);
//        $x=explode("=",$j[0]);
//        //var_dump($x[1]);
//
//        /*获取到用户OpenID*/
//        $Open="https://graph.qq.com/oauth2.0/me?access_token=$x[1]";
//        /*var_dump($Open);*/
//        $OpenID=$this->curlHttp($Open,"GET",[]);
//        //var_dump($OpenID);
//        $q=explode("\"",$OpenID);
//        $ID         =$q[7];
//        //var_dump($q[7]);
//        /*调用OpenAPI接口*/
//        $info="https://graph.qq.com/user/get_user_info?access_token=$x[1]&oauth_consumer_key=101420354&openid=$ID";
//        $nameID=$this->curlHttp($info,"GET",[]);
//        $k=explode("\"",$nameID);
//        //var_dump($k);
//        //$username=$k[11];
//        //$userimg=$k[76];
//        //var_dump($k[47]);
//        $q=explode("/",$k[47]);
//        /*var_dump($q);*/
//        $m='';
//        foreach ($q as $value) {
//            $m.=$value;
//        }
//        /*var_dump($m);*/
//        /*exit;*/
//        /*查一下QQ登录的用户以前登录过了没有*/
//        $where=[
//            'userID'    => $ID
//        ];
//        $userInfo=model('user')->where($where)->limit(1)->find();
//        if($userInfo){
//            /*数据查询有结果，做提示*/
//            Session::set('nowuserid',$userInfo['userID']);         /*ID*/
//            Session::set('username',$userInfo['username']);     /*用户名字*/
//            Session::set('userimg',$userInfo['userimg']);       /*头像*/
//            Session::set('qq_openid','openid');       /*是否用QQ登录*/
//            $this->success('登录成功','web/home/home',3);
//            exit;
//        }
//        $userID         =$ID;
//        $userpsd        =123456;
//        $username       =$k[11];
//        $userTime       =date('y-m-d h:i:s',time());
//        $qq_penid        =$ID;
//        $user=[
//            'userID'        =>$qq_penid,
//            'userpsd'       => md5($userpsd),
//            'username'      => $username,
//            'userTime'      =>$userTime,
//            'userimg'       =>$m,
//            'qq_openid'     =>$qq_penid
//        ];
//
//        $sql="insert into t_user (";
//        $string='';
//        if(is_array($user)){
//            foreach($user as $key=>$val)
//            {
//                $string.="{$key},";
//            }
//            $string=substr($string,0,-1);
//            $string.=')values(';
//            foreach($user as $key=>$val)
//            {
//                $string.="'{$val}',";
//            }
//            $string=substr($string,0,-1);
//            $string.=');';
//        }
//        $sql.=$string;
//        $class=Db::execute("$sql");
//        echo $class;
//        if($class==false){
//            /*注册失败，做提示*/
//            $this->error('注册失败','web/register/register',3);
//        }else{
//            echo "<script>
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
//
//            Session::set('nowuserid',$userID);         /*ID*/
//            Session::set('username',$username);     /*用户名字*/
//            Session::set('userimg',$m);       /*头像*/
//            Session::set('qq_openid','openid');       /*是否用QQ登录*/
//            $this->success('登录成功','web/home/home',3);
//        }
//    }


//    function curlHttp($url,$method,$data){
//        /*
//            使用php 自带的curl扩展，来模拟一个标准的http请求
//
//            使用步骤
//
//                1、先初始化curl ，赋值给一个变量
//
//                2、设置http请求的一些头部选项
//
//                3、设置好选项后，执行发送请求
//
//                4、关闭curl资源
//        */
//
//        $curl = curl_init();
//
//        /*
//            设置常用选项一：请求的url
//        */
//        curl_setopt($curl, CURLOPT_URL,$url );  // == ajax  -> url
//
//        /*
//            设置常用选项二：请求的类型
//        */
//        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method); //  == ajax -> type
//
//        /*
//            设置常用选项三：请求的数据体结构
//        */
//        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
//
//        /*
//            设置常用选项四：将请求的结果原样返回，而不是返回一个true / false
//        */
//
//        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
//
//
//        /*
//            设置常用选项五：让对方接口地址不要严格要求我的网址一定要是https的地址
//        */
//        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);//这个是重点。
//
//
//        $result = curl_exec($curl);
//
//        curl_close($curl);
//
//        return $result;
//
//    }


    /*处理登录提交*/
    public function doLogin(){
        /*接收页面传递（post）的值*/
        /*检查数据是否有这个变量是否提交*/
        $username=Request::instance()->has('id','post');
        if($username==true){
            $id=input('post.id');      //用户id
            $pwd=input('post.pwd');      //用户名
            $code=input('post.code');      //密码
        }

        $where=[
            'uname'=>$id,
            'upsd'=>md5($pwd)
        ];

        /* 查询当前信息用户*/
        $userInfo=Db::table('t_user')->where($where)->select();

        /*非空校验*/
        if(empty($id) || empty($pwd)){
            $returnJson=[
                'code'=>10001,
                'msg'=>'账号或密码不能为空，请重新输入',
                'data'=>[]
            ];
            return $returnJson;
        }

        /*账号防注入*/
        if(!preg_match("/^[0-9]*$/",$id,$matches)){
            $returnJson=[
                'code'=>10002,
                'msg'=>'账号输入不合法，请重新输入',
                'data'=>[]
            ];
            return $returnJson;
        }


        if(empty($userInfo)){
            $returnJson=[
                'code'=>10003,
                'msg'=>'账号或密码输入错误，请重新输入',
                'data'=>[]
            ];
            return $returnJson;
        }

        /*验证码校验*/
        if(!captcha_check($code)){
            $returnJson=[
                'code'=>10004,
                'msg'=>'验证码错误，请重新输入',
                'data'=>[]
            ];
            return $returnJson;
        }


        if(!empty($userInfo)){
            foreach ($userInfo as $key=>$val){
                Session::set('userId',$val['uid']);             /*ID*/
                Session::set('username',$val['nickname']);     /*用户名字*/
                Session::set('userimg',$val['uimg']);           /*头像*/
            }

            $returnJson=[
                'code'=>10000,
                'msg'=>'登录成功',
                'data'=>[]
            ];
            return $returnJson;
        }
    }
}