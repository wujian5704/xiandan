<?php
namespace app\index\controller;
use \think\Controller;

class Auction extends Controller
{
    public function auction()
    {
       return  $this->fetch();
    }
}
