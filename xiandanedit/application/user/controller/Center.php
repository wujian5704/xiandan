<?php
/**
 * Created by PhpStorm.
 * User: 小辉
 * Date: 2018/3/15
 * Time: 14:33
 */

namespace app\user\controller;

use think\Controller;

class Center extends Controller
{
	/*个人中心*/
	public function index()
	{
	  return $this->fetch('center');
	}

}