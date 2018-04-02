<?php
/**
 * Created by PhpStorm.
 * User: 小辉
 * Date: 2018/3/15
 * Time: 14:33
 */

namespace app\user\controller;

use think\Controller;
use think\Request;
use think\Session;

class Center extends Controller
{
	/*显示个人中心页面*/
	public function index()
	{
        $uname = Session::get('usid')?Session::get('usid'):'xianduan';

        $this->assign('uname',$uname);

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

    public function upImg(Request $request)
    {
        $file = $request->file('file');

        if($file)
        {
            $info = $file->move(ROOT_PATH . 'public/static' . DS . 'uploads');

            if ($info)
            {

                 return $info->getSaveName();
            }
            else
             {
                // 上传失败获取错误信息
                return $file->getError();
            }
        }
    }
}