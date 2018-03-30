<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/25
 * Time: 17:42
 */

namespace app\commodity\controller;
use \think\Controller;

class Commodityinfo extends Controller
{
    //显示普通二手商品信息页面
    public function showcomdityinfo()
    {
        return  $this->fetch();
    }

}