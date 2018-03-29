<?php
namespace app\order\controller;
use \think\Controller;

class Allorder extends Controller
{
    //显示全部二手商品订单页面
    public function showallorder()
    {
       return  $this->fetch();
    }
}
