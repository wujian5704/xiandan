<?php
namespace app\commodity\controller;
use \think\Controller;

class Auction extends Controller
{
    //显示拍卖商品信息
    public function showauction()
    {
        return  $this->fetch();
    }
}