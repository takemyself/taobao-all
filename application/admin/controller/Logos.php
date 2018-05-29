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

class Logos extends Common
{
    public function _initialize()
    {
        parent ::_initialize();
        $this->model=new \app\admin\model\Logos();
        $this->url=url('admin/logos/index',['id'=>1]);
    }

    public function index(Request $request)
    {
        $logosData=\app\admin\model\Logos::get(1)->toArray();
        if(!$logosData['pic']){
            $logosData['pic']=1;
        }
        if($request->isPost()){
            $data=$request->param();
            $this->return_res($this->model->store($data),$this->url);
        }
        $this->assign('logosData',$logosData);
        return view();
    }
    public function dellogos(Request $request){
        $data=['pic'=>'','id'=>1];
        $this->model->store($data);
    }
}