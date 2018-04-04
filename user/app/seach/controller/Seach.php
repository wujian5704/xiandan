<?php

namespace app\seach\controller;
use think\Controller;
use think\Db;

class Seach extends Controller
{
    //首页显示
	public function seach()
	{
        return $this->fetch('seach');
	}
    //	分页搜索商品
    public function seachgoods()
    {
        $goodsinfo =  db('t_user')
            ->alias('a')
            ->join('t_goods b','b.gsellerid = a.usid')
            ->select();
//        分类
        $type = Db::table('t_goodstype')->select();
//        品牌
        $brand = Db::table('t_brand')->select();
//        规格
        $spec = Db::table('t_spec')->select();
        $all = ['goods'=>$goodsinfo,'type'=>$type,'brand'=>$brand,'spec'=>$spec];
        return $all;
    }
	public function showgoods(){
        $page = input("?get.page") ? input("get.page"):'';
        if(empty($page)){
            $goodsinfo = $this->seachgoods();
            echo json_encode($goodsinfo);
        }else{
            if($page == 1){
                $goodsinfo =  db('t_user')
                    ->alias('a')
                    ->join('t_goods b','b.gsellerid = a.usid')
                    ->limit(0,5)
                    ->select();
                echo json_encode($goodsinfo);
            }else {
                $start = $page * 5;
                $goodsinfo = db('t_user')
                    ->alias('a')
                    ->join('t_goods b', 'b.gsellerid = a.usid')
                    ->limit($start, 5)
                    ->select();
                echo json_encode($goodsinfo);
            }
        }
    }
    //联动搜索
    public function goodstype(){
        $id = input("?get.id") ? input("get.id"):'';
        $type = substr($id,0,1);
        $typeid = substr($id,1);
        if($type == 't'){
            $goodsList = Db::table('t_goods')->where("gtypeid=$typeid")->select();
            echo json_encode($goodsList);
        }else if($type == 'b'){
            $goodsList = Db::table('t_goods')->where("gbrandid=$typeid")->select();
            echo json_encode($goodsList);
        }else if($type == 's'){
            $goodsList = Db::table('t_goods')->where("gspid=$typeid")->select();
            echo json_encode($goodsList);
        }
    }
//    测试
    public function test(){

    }
}