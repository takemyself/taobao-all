<?php
/**
 * Created by PhpStorm.
 * User : Leopard
 * Date : 2018/5/26
 * Time : 17:17
 * Email: 417780879@qq.com
 */
namespace app\index\controller;
use app\admin\model\Goods;
use app\common\controller\Base;
use think\Request;

class Index extends Base
{
    public function index(){
        $goodsData=Goods::order('sta desc')->limit(4)->select()->toArray();
        $this->assign('goodsData',$goodsData);
        return view();
    }
    public function category(Request $request){
        $cid=$request->param('cid');
        if($cid==9999){
            $goodsAllData=Goods::order('sta desc')->select()->toArray();
        }else{
            $goodsAllData=Goods::where('cid',$cid)->order('sta desc')->select()->toArray();
        }
        $this->assign('cid',$cid);
        $this->assign('goodsAllData',$goodsAllData);
        return view();
    }

    public function contents(Request $request){
        $id=$request->param('id');
        $contents=Goods::get($id)->toArray();
        $contents['content']=explode(',',$contents['content']);
        $this->assign('contents',$contents);
        return view();
    }
}