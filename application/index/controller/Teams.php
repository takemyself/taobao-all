<?php
namespace app\index\controller;
use app\admin\model\Teamcategory;
use think\Request;

class Teams extends Actives
{
    protected $teamscategory;
    protected $cid;
    public function _initialize()
    {
        parent ::_initialize();
        $this->teamscategory=Teamcategory::all();
        $this->cid=input('param.cid/d');
        if(!$this->cid){
            $this->cid=$this->teamscategory['0']['cid'];
        }
        $this->assign('teamscategory',$this->teamscategory);
        $this->assign('cid',$this->cid);
    }

    public function index(Request $request)
    {

        $list = \app\admin\model\Teams::where('cid',$this->cid)->paginate(2);
        $page = $list->render();
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
