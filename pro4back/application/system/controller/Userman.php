<?php
namespace app\system\controller;
use \think\Controller;
use \think\Db;
class Userman extends Controller
{
    //显示前台用户信息页面
    public function showuserman()
    {
        $userList=Db::table('t_user')->select();
        $this->assign('userList',$userList);
        return  $this->fetch();
    }
//    重置密码
    public function modifyPwd()
    {
        $uname = input('?post.uname')?input('post.uname'):"";
        $new_pwd = md5('123456');
        $result = db('t_user')->where('uname',$uname)->update(['upsd' => $new_pwd]);
        try
        {
            if($result == 1)
            {
                $returnJson = [
                    "code" => 10000,
                    "msg" => config('UserMsg')[ 'RESET_SUCCESS'],
                    "data" => []
                ];
                return $returnJson;
            }
            else
            {
                $returnJson = [
                    "code" => 10001,
                    "msg" => config('UserMsg')[ 'RESET_ERROR'],
                    "data" => []
                ];
                return $returnJson;
            }
        }
        catch(\Exception $e)
        {
            $returnJson = [
                "code" => 10002,
                "msg" => config('UserMsg')[ 'SQL_ERROR'],
                "data" => []
            ];
            return $returnJson;
        }
    }


    //    显示详情
    public function detailed(){
        $uname=input('post.uname')?input('post.uname'):'';
        $userInformation=Db::table('t_user')->where('uname',$uname)->select();
        return $userInformation;
    }

    //搜索
    public function search(){
        $content=input('post.content')?input('post.content'):'';

        if(!empty($content)){
            $keywordArr = explode(' ',$content);
            $keyword = '';
            for($i=0;$i<count($keywordArr);$i++)
            {
                $keyword.=" and uname like '%$keywordArr[$i]%'";
                $userdetailed=Db::query('select * from t_user where 1=1 '.$keyword);
                $this->assign('userdetailed',$userdetailed);
                return $userdetailed;
            }
        }else{
            $userdetailed=Db::table('t_user')->select();
            $this->assign('userdetailed',$userdetailed);
            return $userdetailed;
        }
    }

//解锁
    public function unlock(){
        $uname=input('post.uname')?input('post.uname'):'';
        $unlock=Db::table('t_user')->where('uname',$uname)->field('ustate')->select();

        foreach($unlock as $x=>$x_value) {
            if($x_value['ustate']=='锁定'){
                Db::table('t_user')->where('uname',$uname)->update(['ustate' => '正常']);
                $returnJson = [
                    "code" => 10001,
                    "msg" => '修改成功',
                    "data" => []
                ];
                return $returnJson;
            }else{
                $returnJson = [
                    "code" => 10002,
                    "msg" => '用户已经是正常状态',
                    "data" => []
                ];
                return $returnJson;
            }
        }
    }

//锁定
    public function locking(){
        $uname=input('post.uname')?input('post.uname'):'';
        $unlock=Db::table('t_user')->where('uname',$uname)->field('ustate')->select();

        foreach($unlock as $x=>$x_value) {
            if($x_value['ustate']=='正常'){
                Db::table('t_user')->where('uname',$uname)->update(['ustate' => '锁定']);
                $returnJson = [
                    "code" => 10001,
                    "msg" => '修改成功',
                    "data" => []
                ];
                return $returnJson;
            }else{
                $returnJson = [
                    "code" => 10002,
                    "msg" => '用户已经是锁定状态',
                    "data" => []
                ];
                return $returnJson;
            }
        }
    }
}
