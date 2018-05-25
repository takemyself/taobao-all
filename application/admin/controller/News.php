<?php
/**
 * Created by PhpStorm.
 * User : Leopard
 * Date : 2018/1/4
 * Time : 16:02
 * Email: 417780879@qq.com
 */
namespace app\admin\controller;
use app\common\controller\Common;
use think\Request;

class News extends Common
{
    public function _initialize()
    {
        parent ::_initialize();
        $this->model=new \app\admin\model\News();
        $this->url=url('admin/news/index');
        $this->modelTwo=new \app\admin\model\Category();
    }
    public function index(){
        $newsData=$this->model->all()->toArray();
        $oldnewscategoryData=$this->modelTwo->all()->toArray();
        $newscategoryData=[];
        foreach($oldnewscategoryData as $k=>$v){
            $newscategoryData[$v['cid']]=$v['cname'];
        }
        $this->assign('newscategoryData',$newscategoryData);
        $this->assign('newsData',$newsData);
        return view();
    }

    public function addnews(Request $request){
        $newscategoryData=$this->modelTwo->all();
        if($request->isPost()){
            $this->return_res($this->model->store($request->param()),$this->url);
        }
        $this->assign('newscategoryData',$newscategoryData);
        return view();
    }

    public function editnews(Request $request){
        $oldData=$this->model->get($request->param('nid'));
        $newscategoryData=$this->modelTwo->all()->toArray();
        if($request->isPost()){
            $this->return_res($this->model->store($request->param()),$this->url);
        }
        $this->assign('newscategoryData',$newscategoryData);
        $this->assign('oldData',$oldData);
        return view();
    }

    public function delnews(Request $request){
        if($request->isGet()){
            $id=$request->param('id');
            $num=$this->model->destroy($id);
            $this->return_del($num,$this->url);
        }
    }
}