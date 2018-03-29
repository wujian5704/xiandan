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
            ->paginate(5);
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
        $loginrid =  $loginData["roleid"];//当前在线角色id
        $sid = input('?post.sid')?input('post.sid'):"";
        $roleid = input('?post.roleid')?input('post.roleid'):"";
        //查询要删的角色是否拥有员工管理权限
        $data = ['roleid'=>$roleid,'jurisdid'=> 6];
        try
        {
            $res = db('t_allotjuris')->where($data)->find();
            if($loginrid != 1 && !empty($res))
            {
                $returnJson = [
                    "code" => 10003,
                    "msg" => config('StaffMsg')[ 'NODELE'],
                    "data" => []
                ];
                return $returnJson;
            }
            else
            {
                $result = db('t_staff')->where('sid',$sid)->delete();
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
    //解锁
    public function deblock()
    {
        $loginData = Session::get('userLogin');
        $loginsid = $loginData["sid"];//当前员工id
        $lockArr = input('?post.arr')?input('post.arr/a'):"";
        $returnJson = [
            "code" => 10001,
            "msg" => config('StaffMsg')[ 'SQL_ERROR'],
            "data" => []
        ];
        try
        {
            foreach ($lockArr as $key=>$val)
            {
                if($loginsid != $val)
                {
                    db('t_staff')->where('sid',$val)->update(['state' => "使用"]);
                }
            }
            $returnJson = [
                "code" => 10000,
                "msg" => config('StaffMsg')[ 'BLOCK_SUCCESS'],
                "data" => []
            ];
            return $returnJson;
        }
        catch(\Exception $e)
        {
            return $returnJson;
        }
    }
    //锁定
    public function lock()
    {
        $loginData = Session::get('userLogin');
        $loginsid = $loginData["sid"];//当前员工id
        $lockArr = input('?post.arr')?input('post.arr/a'):"";
        $returnJson = [
            "code" => 10001,
            "msg" => config('StaffMsg')[ 'SQL_ERROR'],
            "data" => []
        ];
        try
        {
            foreach ($lockArr as $key=>$val)
            {
                if($loginsid != $val)
                {
                    db('t_staff')->where('sid',$val)->update(['state' => "锁定"]);
                }
            }
            $returnJson = [
                "code" => 10000,
                "msg" => config('StaffMsg')[ 'LOCK_SUCCESS'],
                "data" => []
            ];
            return $returnJson;
        }
        catch(\Exception $e)
        {
            return $returnJson;
        }
    }
    //获取员工信息
    public function get_staff()
    {
        $sid = input('?post.sid')?input('post.sid'):"";
        //获取员工的信息
        $staff_info =  db('t_staff')
            ->alias('a')
            ->join('t_role b','a.roleid = b.rid')
            ->where('sid',$sid)
            ->find();
        $returnjson = json_encode($staff_info);
        echo $returnjson;
    }
    //获取角色列表
    public function get_rolelist()
    {
        //获取所有的角色列表
        $role_list = db('t_role')->select();
        echo json_encode($role_list);
    }
    //添加员工
    public function add_staff()
    {
        $loginData = Session::get('userLogin');
        $loginrid =  $loginData["roleid"];//当前在线角色id
        $newSname = input('?post.newSname')?input('post.newSname'):"";//新用户名
        $newSnick = input('?post.newSnick')?input('post.newSnick'):"";//新用户名称
        $newRoleid = input('?post.newRoleId')?input('post.newRoleId'):"";//新添加角色id
        $snlg = strlen($newSname);
        $md5pwd = md5('12345');
        $returnJson = [
            "code" => 10001,
            "msg" => config('StaffMsg')[ 'ADDSTAFF_ERROR'],
            "data" => []
        ];
        //同名验证
        $res = db('t_staff')->where('sid',$newSname)->find();
        if(!empty($res))
        {
            $returnJson = [
                "code" => 10002,
                "msg" => config('StaffMsg')[ 'USER_EXIST'],
                "data" => []
            ];
            return $returnJson;
        }
        if($snlg == 4 && !empty($newSnick) && !empty($newRoleid))
        {
            try
            {
                //查询要删的角色是否拥有员工管理权限$newRoleid != 1 && $newRoleid != $loginrid
                $data = ['roleid'=>$newRoleid,'jurisdid'=> 6];
                $res = db('t_allotjuris')->where($data)->find();
                if($loginrid == 1 || (empty( $res)))
                {
                    $data = ['sid' => $newSname, 'sname' => $newSnick,'roleid'=> $newRoleid,'password'=>$md5pwd,'state'=>'使用'];
                    $result = db('t_staff')->insert($data);
                    if($result == 1)
                    {
                        $returnJson = [
                            "code" => 10000,
                            "msg" => config('StaffMsg')[ 'ADDSTAFF_SUCCESS'],
                            "data" => []
                        ];
                        return $returnJson;
                    }
                    else
                    {
                        return $returnJson;
                    }
                }
                else
                {
                    $returnJson = [
                        "code" => 10003,
                        "msg" => config('StaffMsg')[ 'ADD_NOJUR'],
                        "data" => []
                    ];
                    return $returnJson;
                }
            }
            catch(\Exception $e)
            {
                $returnJson = [
                    "code" => 10004,
                    "msg" => config('StaffMsg')[ 'SQL_ERROR'],
                    "data" => []
                ];
                return $returnJson;
            }
        }
        else
        {
            return $returnJson;
        }
    }
    //修改员工信息
    public function up_staff()
    {
        $loginData = Session::get('userLogin');
        $loginrid =  $loginData["roleid"];//当前在线角色id
        $loginsid = $loginData["sid"];//当前在线用户id
        $sid = input('?post.sid')?input('post.sid'):"";
        //先查询要修改的员工原来是什么角色
        $up_staffInfo = db('t_staff')->where('sid',$sid)->find();
        $up_rid = $up_staffInfo["roleid"];//原先角色id
        $nickname = input('?post.nickname')?input('post.nickname'):"";
        $roleid = input('?post.roleid')?input('post.roleid'):"";//要修改的角色id
        $returnJson = [
            "code" => 10001,
            "msg" => config('StaffMsg')[ 'UP_ERROR'],
            "data" => []
        ];
        try
        {
            if($loginsid == $sid )//经理对自己，只能修改用户名称
            {
                if($loginrid != $roleid)
                {
                    $returnJson = [
                        "code" => 10005,
                        "msg" => config('StaffMsg')[ 'CANNOT'],
                        "data" => []
                    ];
                    return $returnJson;
                }
                $result = db('t_staff')->where('sid',$sid)->update(['sname' =>  $nickname]);
                if($result == 1)
                {
                    $returnJson = [
                        "code" => 10000,
                        "msg" => config('StaffMsg')[ 'UP_SUCCESS'],
                        "data" => []
                    ];
                    return $returnJson;
                }
                else
                {
                    return $returnJson;
                }
            }
            else if($loginrid != 1)//经理级别权限
            {
                $data = ['roleid'=>$up_rid,'jurisdid'=> 6];
                $res = db('t_allotjuris')->where($data)->find();
                if(empty( $res))
                {
                    $data1 = ['roleid'=>$roleid,'jurisdid'=> 6];
                    $flg = db('t_allotjuris')->where($data1)->find();
                    if(empty( $flg))
                    {
                        $result = db('t_staff')->where('sid',$sid)->update(['sname' =>  $nickname,'roleid'=>$roleid]);
                        if($result == 1)
                        {
                            $returnJson = [
                                "code" => 10000,
                                "msg" => config('StaffMsg')[ 'UP_SUCCESS'],
                                "data" => []
                            ];
                            return $returnJson;
                        }
                        else
                        {
                            return $returnJson;
                        }
                    }
                    else
                    {
                        $returnJson = [
                            "code" => 10003,
                            "msg" => config('StaffMsg')[ 'NOJUR'],
                            "data" => []
                        ];
                        return $returnJson;
                    }
                }
                else
                {
                    $returnJson = [
                        "code" => 10003,
                        "msg" => config('StaffMsg')[ 'NOJUR'],
                        "data" => []
                    ];
                    return $returnJson;
                }
            }
            else //超管权限
            {
                $result = db('t_staff')->where('sid',$sid)->update(['sname' =>  $nickname,'roleid'=>$roleid]);
                if($result == 1)
                {
                    $returnJson = [
                        "code" => 10000,
                        "msg" => config('StaffMsg')[ 'UP_SUCCESS'],
                        "data" => []
                    ];
                    return $returnJson;
                }
                else
                {
                    return $returnJson;
                }
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