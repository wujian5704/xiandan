<?php
namespace app\index\controller;
use \think\Controller;
use think\Session;

class Login extends Controller
{
    //显示后台登录页面
    public function login()
    {
        return  $this->fetch();
    }
    //登录验证
    public function loginverify()
    {
        $userName = input('?post.username')?input('post.username'):"";
        $passWord = input('?post.password')?input('post.password'):"";
        $returnJson = [
            "code" => 10001,
            "msg" => config('LoginMsg')[ 'Login_ERROR'],
            "data" => []
        ];
        if(empty($userName) || empty($passWord))
        {
            $returnJson = [
                "code" => 10002,
                "msg" => config('LoginMsg')[ 'ACCOUNT_EMPTY'],
                "data" => []
            ];
            return $returnJson;
        }
        $pwdMd5 = md5($passWord);
        $data = [
            'sid' => $userName , 'password' => $pwdMd5
        ];
        $result =  db('t_staff')->where($data)->find();
        try
        {
            if(!empty($result))
            {
                if($result["state"] == "使用")
                {
                    //登录状态存到session，主页判断
                    Session::set('userLogin',$result);
                    $returnJson = [
                        "code" => 10000,
                        "msg" => config('LoginMsg')[ 'Login_SUCCESS'],
                        "data" => []
                    ];
                    return $returnJson;
                }
                if($result["state"] == "锁定")
                {
                    $returnJson = [
                        "code" => 10003,
                        "msg" => config('LoginMsg')[ 'LOCK'],
                        "data" => []
                    ];
                    return $returnJson;
                }
                return $returnJson;
            }
            else
            {
                return $returnJson;
            }
        }
        catch(\Exception $e)
        {
            $returnJson = [
                "code" => 10004,
                "msg" => config('RegistMsg')[ 'SQL_ERROR'],
                "data" => []
            ];
            return  $returnJson;
        }
    }
}
