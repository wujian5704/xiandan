<?php

namespace app\goods\controller;
use think\Controller;
use think\Db;

class Goods extends Controller
{
//	商品详情
	public function goods()
	{
	  return $this->fetch('goods');
	}
	//查询商品数据
    public function goodsinfo(){
        $db = db('t_goods')->select();
        var_dump($db);
    }
}