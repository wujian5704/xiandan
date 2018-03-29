<?php
namespace app\system\controller;
use \think\Controller;
class Userman extends Controller
{
    //显示前台用户信息页面
    public function showuserman()
    {
       return  $this->fetch();
    }
}
