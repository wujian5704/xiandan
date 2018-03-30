<?php
namespace app\chat\controller;
use \think\Controller;
class Chat extends Controller
{
    //显示客服聊天页面
    public function showchat()
    {
       return  $this->fetch();
    }
}
