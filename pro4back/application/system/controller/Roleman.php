<?php
namespace app\system\controller;
use \think\Controller;

class Roleman extends Controller
{
    //显示角色管理页面
    public function showroleman()
    {
        return  $this->fetch();
    }
}
