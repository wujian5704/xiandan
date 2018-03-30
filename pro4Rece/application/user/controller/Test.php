<?php
/**
 * Created by PhpStorm.
 * User: 小辉
 * Date: 2018/3/25
 * Time: 21:59
 */

namespace app\user\controller;

use think\Controller;

class Test extends Controller
{
    public function index()
    {
       return $this->fetch('test');
    }
}