<?php
/**
 * Created by PhpStorm.
 * User: 小剑
 * Date: 2018/3/29
 * Time: 11:01
 */

namespace app\index\controller;


use think\Controller;

class Auctdetail extends Controller
{
    public function auctdetail(){
        return $this ->fetch();
    }

}