<?php
namespace app\statement\controller;
use \think\Controller;

class Marketing extends Controller
{
    public function showmarketing()
    {
        //显示营销统计页面
        return  $this->fetch();
    }

}
