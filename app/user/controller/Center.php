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
        $uname = Session::get('uname')?Session::get('uname'):'xd1234';

        $this->assign('uname',$uname);

        return $this->fetch('center');

	}

	/*获取用户信息*/
    public function getInfo()
    {
        $uname = Session::get('usid')?Session::get('usid'):'xd1234';

        $arr = ['uname'=>$uname];

        $data = db('user')->where($arr)->find();

        return $data;
    }

    //修改头像
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

    //保存头像路径
    public function saveUrl()
    {
        $uname = Session::get('uname')?Session::get('uname'):'xd1234';

        $url = input('?post.url')?input('post.url'):'';

        try{

            $re = db('user')->where('uname',$uname)->update(['uimg'=>$url]);

            if($re)
            {
                return 1;
            }
            else
            {
                return 0;
            }
        }
        catch (\Exception $e)
        {
            return -1;
        }

    }
}