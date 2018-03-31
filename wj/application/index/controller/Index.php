<?php
namespace app\index\controller;
use \think\Controller;
use \think\Db;
class Index extends Controller
{
    public function index()
    {
        $goodsData = Db::table('t_goods') ->select();


        //视图使用变量,绑定变量
        $this ->assign('goodsData',$goodsData);
//        var_dump($goodsData);
//        var_dump($goodsData['gdegree'][1]);
       return  $this->fetch();
    }
}
