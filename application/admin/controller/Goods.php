<?php
/**
 * Created by PhpStorm.
 * User : Leopard
 * Date : 2018/5/26
 * Time : 14:56
 * Email: 417780879@qq.com
 */
namespace app\admin\controller;
use app\common\controller\Common;
use think\Db;
use think\Request;

class Goods extends Common
{
    public function _initialize()
    {
        parent ::_initialize();
        $this->url=url('admin/goods/index');
        $this->modelTwo=new \app\admin\model\Category();
        $this->model=new \app\admin\model\Goods();
    }

    public function index(){
        $data=Db::table('res_goods')->alias('g')
            ->join('res_category c','g.cid=c.cid')
            ->order('g.sta desc,id desc')
            ->select();
        $this->assign('data',$data);
        return view();
    }

    public function addgoods(Request $request){
        $cateDate=$this->modelTwo->all();
        if($request->isPost()){
            $data=$request->param();
            if(!isset($data['pic'])){
                echo "<script>alert('图片未上传');history.go(-1);</script>";
                exit;
            }
            $data['content']=implode(',',$data['content']);
            $this->return_res($this->model->store($data),$this->url);
        }
        $this->assign('cateDate',$cateDate);
        return view();
    }

    public function editgoods(Request $request){
        $cateDate=$this->modelTwo->all();
        $oldData=$this->model->find($request->param('id'))->toArray();
        $oldData['content']=explode(',',$oldData['content']);
        if($request->isPost()){
            $data=$request->param();
            if(!isset($data['pic'])){
                echo "<script>alert('图片未上传');history.go(-1);</script>";
                exit;
            }
            $data['content']=implode(',',$data['content']);
            $this->return_res($this->model->store($data),$this->url);
        }
        $this->assign('oldData',$oldData);
        $this->assign('cateDate',$cateDate);
        return view();
    }

    public function delgoods(Request $request){
        if($request->isGet()){
            $id=$request->param('id');
            $num=$this->model->destroy($id);
            $this->return_del($num,$this->url);
        }
    }

    public function ajaxEditSort(Request $request)
    {
        if($request->isAjax()){
            return $this ->model -> editsort($request -> param());
        }
    }
}