<?php

namespace app\goods\controller;
use think\Controller;
use think\Db;
use think\Session;

class Goods extends Controller
{
    public $orderinfo = [];
//	商品详情
	public function goods()
	{
        $id = input("?get.id") ? input("get.id"):'';
//        if(empty($id)){
//            echo "访问受限，即将返回！";
//        }else {
//      商品详情信息
            $join = [
                ['t_goods a', "b.usid = a.gsellerid"],
                ['t_goodstype c', "a.gtypeid = c.typeid"]
            ];
            $goodsinfo = Db::table('t_user')->alias('b')->join($join)->where("a.goodid=$id")->select();
            $this->assign('goodsList', $goodsinfo);
            $orderinfo = ['goodid'=>$goodsinfo[0]["goodid"],'gprice'=>$goodsinfo[0]["gprice"]];
            $order = Db::table('t_order')->select();
//            dump($order);
            Session::set('info',$orderinfo);
            return $this->fetch('goods');
//        }
	}
    //添加订单
    public function addorder(){
	    //登录时存的session 用户id
        $userid = Session::get('usid');
        $ordernum = time();
        $otime = date("Y-m-d H:i:s", time());
        $info = Session::get('info');
        Db::table('t_order')
            ->data(
                [
                    'orid' => '', 'ordernum' => $ordernum, 'ousid' => $userid, 'goodsid' => $info["goodid"],
                    'oprice' => $info["gprice"], 'otime' => $otime, 'osid' => 1, 'adrid' => 6
                ]
            )
            ->insert();
    }
    //议价价格
    public function bargaining(){
	    $price = input("?post.price")?input("post.price"):'';
	    $userPhone = input("?post.userPhone")?input("post.userPhone"):'';
    }

    //用vue获取首页商品数据
    public function goodsdatas(){
        $db = db('t_goods')->select();
        return $db;
    }
    //点击首页商品进行跳转商品详情
    public function getdatas(){
        $gid = $_GET['id'];
        $datas = db("t_goods")->where('goodid',$gid)->select();
        return $this->fetch('goods');
    }
}