<?php
namespace app\index\controller;
use app\admin\model\Category;
use think\Request;

class News extends Actives
{
    protected $newcategory;
    protected $cid;
    public function _initialize()
    {
        parent ::_initialize();
        $this->newcategory=Category::all();
        $this->cid=input('param.cid/d');
        if(!$this->cid){
            $this->cid=$this->newcategory['0']['cid'];
        }
        $this->assign('cid',$this->cid);
        $this->assign('newcategory',$this->newcategory);
    }

    public function index(Request $request)
    {
        $list = \app\admin\model\News::where('cid',$this->cid)->paginate(4);
        // 获取分页显示
        $page = $list->render();
        // 模板变量赋值
        $this->assign('list', $list);
        $this->assign('page', $page);
        return view();
    }

    public function newscontent(Request $request){
        $nid=$request->param('nid/d');
        $data=\app\admin\model\News::get($nid);
        $this->assign('data',$data);
        return view();
    }
}
