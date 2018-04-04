<?php
/**
 * Created by PhpStorm.
 * User: 小辉
 * Date: 2018/3/15
 * Time: 14:33
 */

namespace app\user\controller;
use think\Request;
use base\Base;
use think\Session;
//载入ucpass类短信验证

class Center extends Base
{
	/*显示个人中心页面*/
	public function index()
	{
        $uname = Session::has('uname')?Session::get('uname'):'xd1234';

        $this->assign('uname',$uname);

        return $this->fetch('center');
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
            {// 上传失败获取错误信息
                return $file->getError();
            }
        }
    }
    //保存头像路径
    public function saveUrl()
    {
        $uname = Session::has('uname')?Session::get('uname'):'xd1234';
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
	//绑定手机
    public function boundPhone()
    {
        $realCode = Session::has('verifiNum')?Session::get('verifiNum'):"";
        $code = input('?post.code')?input('post.code'):"";
        $phone = input('?post.phone')?input('post.phone'):"";
        $pwd = input('?post.pwd')?input('post.pwd'):"";
        $uname = Session::has('uname')?Session::get('uname'):'xd1234';
        if(!empty($phone) && !empty($pwd) && $realCode == $code)
        {
            try
            {
                $pwdMd5 = md5($pwd);
                $data = ["uphone"=>$phone];
                $result = db("user")->where("upsd",$pwdMd5)->where("uname",$uname)->update($data);
                if($result == 1)
                {
                    return $this->reminder(10000,'Center','boundSuccess');
                }
                else
                {
                    return $this->reminder(10001,'Center','boundError');
                }
            }
            catch (\Exception $e)
            {
                return $this->reminder(10002,'Center','SqlError');
            }
        }
        else
        {
            return $this->reminder(10001,'Center','boundError');
        }
    }
	//短信验证接口
    public function  phoneVerif()
    {
        require_once('../extend/lib/Ucpaas.php');
        $options['accountsid']='16d0a4f1d9a6efe57367165c3d3dcb4a';
        $options['token']='7da368fdec60e177c9859b25ddaafb4d';
        $ucpass = new \Ucpaas($options);
        $appid = "1c55900ace734a32bd5528dc727384a8";
        $templateid = "302777";
        $param = substr(strval(mt_rand(10000,19999)),1,4);//随机4位数字验证码
        Session::set('verifiNum',$param);//将验证码存起来校验
        $mobile = input('?post.phone')?input('post.phone'):"";//手机号码
        $ucpass->SendSms($appid,$templateid,$param,$mobile,"");
    }
    //清除短信验证session
    public function deleVerifiNum()
    {
        Session::delete('verifiNum');
    }
    //修改用户登录密码
    public function upPassWord()
    {
        $uname = Session::has('uname')?Session::get('uname'):'xd1234';
        $oldPwd = input('?post.oldPwd')?input('post.oldPwd'):"";
        $newPwd = input('?post.newPwd')?input('post.newPwd'):"";
        $newPwdAga = input('?post.newPwdAga')?input('post.newPwdAga'):"";
        $lg = strlen($newPwd);
        if(!empty($oldPwd) && $newPwd == $newPwdAga && $lg >= 5)
        {
            $oldMd5 = md5($oldPwd);
            $newMd5 = md5($newPwd);
            $data = ['upsd' => $newMd5];
            try
            {
                $result = db("user")->where("upsd",$oldMd5)->where("uname",$uname)->update($data);
                if($result == 1)
                {
                    Session::delete('uname');//退出登录，删除session
                    return $this->reminder(10000,'Center','UpPwdSuccess');
                }
                else
                {
                    return $this->reminder(10002,'Center','UpPwdError');
                }
            }
           catch(\Exception $e)
           {
               return $this->reminder(10002,'Center','SqlError');
           }
        }
        else
        {
            return $this->reminder(10003,'Center','UpPwdError');
        }
    }
    //修改用户基本信息
    public function upUserinfo()
    {
        $uname = Session::has('uname')?Session::get('uname'):'xd1234';//用户名
        $nickname = input('?post.nickname')?input('post.nickname'):"未设置";
        $usex = input('?post.usex')?input('post.usex'):"男";
        $region = input('?post.region')?input('post.region'):"未设置";
        $uage = input('?post.uage')?input('post.uage'):"未设置";
        try
        {
            $data = [
                'nickname' => $nickname,
                'usex' => $usex,
                'region' => $region,
                'uage' => $uage
            ];
            $result = db("user")->where("uname",$uname)->update($data);
            if($result == 1)
            {
                return $this->reminder(10000,'Center','UpInfoSuccess');
            }
            else
            {
                return $this->reminder(10001,'Center','UpInfoError');
            }
        }
        catch(\Exception $e)
        {
            return $this->reminder(10002,'Center','SqlError');
        }
    }
	/*获取用户信息*/
    public function getInfo()
    {
        $uname = Session::has('uname')?Session::get('uname'):'xd1234';//用户名

        $arr = ['uname'=>$uname];

        $data = db('user')->where($arr)->find();

        return $data;
    }
    //获取用户的所有收货地址
    public function getAllSite()
    {
        $usid = Session::has('usid')?Session::get('usid'):'1';//用户名
        $addressData =  db('address')
            ->alias('a')
            ->join('pro b','a.provid = b.prid')
            ->join('city c','a.cityid = c.cid')
            ->join('area d','a.townid = d.tid')
            ->where("a.userid",$usid)
            ->select();
        return $addressData;
    }
    //获取地址信息（省、市、县区）
    public function getSite()
    {
        $pid = input('?post.pid')?input('post.pid'):null;//省份id
        $cid = input('?post.cid')?input('post.cid'):null;//城市id
        $proData =  db("pro")->select();//省份
        if(!empty($pid) && $pid != 0)
        {
            $cityData =  db("city")->where('pid',$pid)->select();//城市
        }
        else
        {
            $cityData =  db("city")->select();//城市
        }
        if(!empty($cid) && $cid != 0)
        {
            $areaData =  db("area")->where('cid',$cid)->select();//县区
        }
        else
        {
            $areaData =  db("area")->select();//县区
        }

        $siteData = [$proData,$cityData,$areaData];

        return $siteData;
    }
    //添加收货地址
    public function addSite()
    {
        $uid = Session::has('usid')?Session::get('usid'):1;//用户id
        $pid = input('?post.pid')?input('post.pid'):null;//省份id
        $cid = input('?post.cid')?input('post.cid'):null;//城市id
        $tid = input('?post.tid')?input('post.tid'):null;//县区id
        $consignee = input('?post.consignee')?input('post.consignee'):null;//收货人姓名
        $phone = input('?post.phone')?input('post.phone'):null;//收货人电话
        $detadress = input('?post.detadress')?input('post.detadress'):null;//详细地址
        $data = [
            'provid' => $pid,
            'cityid' => $cid,
            'townid' => $tid ,
            'detadrs' => $detadress,
            'aphone' => $phone,
            'consignee' => $consignee,
            'userid' => $uid
        ];
        try{
            $result = db('address')->insert($data);
            if($result == 1)
            {
                return $this->reminder(10000,'Center','addSiteSuccess');
            }
            else
            {
                return $this->reminder(10001,'Center','addSiteError');
            }
        }
        catch(\Exception $e)
        {
                return $this->reminder(10002,'Center','SqlError');
        }
    }
}