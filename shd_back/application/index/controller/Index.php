<?php
namespace app\index\controller;
use \think\Controller;
use think\Session;

class Index extends Controller
{
    //防止未登录直接进入首页
    public function _initialize()
    {
        //控制器初始化函数
        $flg =  Session::has('userLogin');
        if(empty($flg))
        {
            $this->success("请先登录",'index/login/login');
        }
    }
    //显示后台主页
    public function index()
    {
        //获取管理员登录信息
        $loginData = Session::get('userLogin');
        $rid = $loginData["roleid"];//角色id
        $loginname = $loginData["sname"];
        $data=["roleid" => $rid];
        //查询角色相关的权限
        $jurisdData = db('t_allotjuris')
            ->alias('a')
            ->join('t_jurisdiction b','a.jurisdid = b.jid')
            ->join('t_role c','a.roleid = c.rid')
            ->where($data)
            ->select();
           if(!empty($jurisdData))
           {
               foreach ($jurisdData as $key => &$value)
               {
                   $value['url'] = url($value['url']);
               }
           }
        $this->assign("loginname",$loginname);//员工昵称
        $this->assign("jurisdData",$jurisdData);
        return  $this->fetch();
    }
}

