<?php
/**
 * Created by PhpStorm.
 * User: 小剑
 * Date: 2018/3/31
 * Time: 11:51
 */

namespace app\index\controller;


use think\Controller;

class Tests extends Controller
{
    public function tests(){
        return  $this->fetch();
    }

}