<?php
namespace app\system\controller;
use \think\Controller;
use think\Session;

class Staffman extends Controller
{
    //显示后台员工管理页面
    public function showstaffman()
    {
        //获取员工列表
        $staffList = db('t_staff')
            ->alias('a')
            ->join('t_role b','a.roleid = b.rid')
            ->select();
        $this->assign('staffList',$staffList);
        return  $this->fetch();
    }
    //删除员工
    public function dele_staff()
    {
        $returnJson = [
            "code" => 10001,
            "msg" => config('StaffMsg')[ 'DELE_ERROR'],
            "data" => []
        ];
        $loginData = Session::get('userLogin');
        $loginsid = $loginData["sid"];//当前员工id
        $sid = input('?post.sid')?input('post.sid'):"";
        if($sid == $loginsid)
        {
            $returnJson = [
                "code" => 10003,
                "msg" => config('StaffMsg')[ 'NODELE'],
                "data" => []
            ];
            return $returnJson;
        }
        $result = db('t_staff')->where('sid',$sid)->delete();
        try
        {
            if($result == 1)
            {
                $returnJson = [
                    "code" => 10000,
                    "msg" => config('StaffMsg')[ 'DELE_SUCCESS'],
                    "data" => []
                ];
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
                "code" => 10002,
                "msg" => config('StaffMsg')[ 'SQL_ERROR'],
                "data" => []
            ];
            return $returnJson;
        }
    }
    //重置密码
    public function reset_pwd()
    {
        //当前在线员工
        $loginData = Session::get('userLogin');
        $loginsid = $loginData["sid"];//当前员工id
        $sid = input('?post.sid')?input('post.sid'):"";
        $returnJson = [
            "code" => 10001,
            "msg" => config('StaffMsg')[ 'RESET_ERROR'],
            "data" => []
        ];
        $new_pwd = md5('123456');
        $result = db('t_staff')->where('sid',$sid)->update(['password' => $new_pwd]);
        try
        {
            if($result == 1)
            {
                $returnJson = [
                    "code" => 10000,
                    "msg" => config('StaffMsg')[ 'RESET_SUCCESS'],
                    "data" => []
                ];
                if($sid == $loginsid)
                {
                    Session::delete('userLogin');//刷新页面，重新登录
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
                "code" => 10002,
                "msg" => config('StaffMsg')[ 'SQL_ERROR'],
                "data" => []
            ];
            return $returnJson;
        }
    }
}