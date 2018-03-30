<?php
namespace app\statement\controller;
use \think\Controller;

class Registuser extends Controller
{
    //显示注册用户统计页面
    public function showregistuser()
    {
       return  $this->fetch();
    }
}
