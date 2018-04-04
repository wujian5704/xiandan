<?php
namespace app\index\controller;
use \think\Controller;
use \think\Db;
use \think\Request;
use \think\Session;
class Index extends Controller
{
    public function index(){
        //商品表
        $goodsData = Db::table('t_goods') ->select();
        //视图使用变量,绑定变量
        $this ->assign('goodsData',$goodsData);
        //轮播图中的分类菜单
        $goodstype = Db::table('t_goodstype') ->select();
        $this->assign('gtype',$goodstype);
        //品牌
        $goodbrand = Db::table('t_brand')->select();
        $this->assign('gbrand',$goodbrand);
        //规格
        $goodspec = Db::table('t_spec')->select();
        $this->assign('gspec',$goodspec);
        //获取当前的用户名
        $name =  Session::get('uname');
        $this ->assign('loginuname',$name);
       return  $this->fetch();
    }
    public function getTypeid(){
        $typeid = input('?post.typeid')?input('post.typeid'):'';
        $typeData = db('t_brand')->where('cid',$typeid)->select();
        return $typeData;
    }
}
