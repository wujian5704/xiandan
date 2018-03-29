<?php
namespace app\order\controller;
use \think\Controller;

class Undoneorder extends Controller
{
    //显示未完成二手订单
    public function showundoneorder()
    {
        return  $this->fetch();
    }

}
