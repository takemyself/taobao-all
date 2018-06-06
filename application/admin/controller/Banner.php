<?php
/**
 * Created by PhpStorm.
 * User : Leopard
 * Date : 2018/2/2
 * Time : 13:43
 * Email: 417780879@qq.com
 */
namespace app\admin\controller;
use app\common\controller\Common;
use think\Request;

class Banner extends Common
{
    public function _initialize()
    {
        parent ::_initialize();
        $this->redis->del('banData');
        $this->model=new \app\admin\model\Banner();
        $this->url=url('admin/banner/index');
    }

    public function index()
    {
        $banaerData=$this->model->order('sort desc')->select()->toArray();
        $cids=\app\admin\model\Category::all()->toArray();
        $cidData=[];
        $cidArr=[];
        foreach($cids as $k=>$v){
            $cidData[$v['cid']]=$v;
            $cidArr[]=$v['cid'];
        }
        foreach($banaerData as $i=>$m){
            if($m['gid']>0){
                $banaerData[$i]['name']=\app\admin\model\Goods::where('id',$m['gid'])->value('name');
            }else{
                if(in_array($m['cid'],$cidArr)){
                    $banaerData[$i]['cname']=$cidData[$m['cid']]['cname'];
                }else{
                    $banaerData[$i]['cname']='全部';
                }
            }
        }
        $this->assign('bannerData',$banaerData);
        return view();
    }

    public function addbanner(Request $request)
    {
        if($request->isPost()){
            $data=$request->param();
            $this->return_res($this->model->store($data),$this->url);
        }
        return view();
    }

    public function editbanner(Request $request)
    {
        $id=$request->param('id');
        $cateData=\app\admin\model\Category::all()->toArray();
        $oldData=\app\admin\model\Banner::get($id);
        $goodsData=\app\admin\model\Goods::field('id,name')->select()->toArray();
        if($request->isPost()){
            $data=$request->param();
            $this->return_res($this->model->store($data),$this->url);
        }
        $this->assign('goodsData',$goodsData);
        $this->assign('cateData',$cateData);
        $this->assign('oldData',$oldData);
        return view();
    }

    public function ajaxEditSort(Request $request)
    {
        if($request->isAjax()){
            return $this ->model -> editsort($request -> param());
        }
    }

    public function delbanner(Request $request)
    {
        if($request->isGet()){
            $id=$request->param('id');
            $data=$this->model->get($id);
            $picflie=ROOT_PATH . 'public' . DS . 'uploads'.DS.$data['pic'];
            $num=$this->model->destroy($id);
            $this->return_del($num,$this->url,$picflie);
        }
    }
}