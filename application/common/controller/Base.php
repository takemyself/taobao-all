<?php
/**
 * Created by PhpStorm.
 * User : Leopard
 * Date : 2018/1/5
 * Time : 15:07
 * Email: 417780879@qq.com
 */
namespace app\common\controller;
use app\admin\model\Banner;
use app\admin\model\Category;
use app\admin\model\Logos;
use think\Controller;

class Base extends Controller
{
    public function _initialize()
    {
        $cateData=Category::order('sort desc')->select();
        $banData=Banner::order('sort desc')->limit(3)->select()->toArray();
        $intData=Logos::get(1)->toArray();
        if(!$intData['pic']){
            !$intData['pic']=1;
        }
        $this->assign('intData',$intData);
        $this->assign('banData',$banData);
        $this->assign('cateData',$cateData);
    }
}