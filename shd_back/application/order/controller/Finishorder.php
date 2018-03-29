<?php
namespace app\order\controller;
use \think\Controller;

class Finishorder extends Controller
{
    //显示已完成二手订单
    public function showfinishorder()
    {
        return  $this->fetch();
    }

}
