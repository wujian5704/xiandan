<?php
/**
 * Created by PhpStorm.
 * User: 小辉
 * Date: 2018/3/15
 * Time: 14:33
 */

namespace app\user\controller;

use think\Controller;
use think\Session;

class Center extends Controller
{
	/*显示个人中心页面*/
	public function index()
	{
	   return $this->fetch('center');
	}

	/*获取用户信息*/
    public function getInfo()
    {
        $uid = Session::get('usid')?Session::get('usid'):1;

        $arr = ['usid'=>$uid];

        $data = db('user')->where($arr)->select();

        return $data;
    }
}