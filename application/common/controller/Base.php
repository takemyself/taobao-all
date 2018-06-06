<?php
/**
 * Created by PhpStorm.
 * User : Leopard
 * Date : 2018/1/5
 * Time : 15:07
 * Email: 417780879@qq.com
 */
namespace app\common\controller;
use app\admin\model\Category;
use app\admin\model\Logos;
use Predis\Client;
use think\Controller;

class Base extends Controller
{
    public $redis;
    public function _initialize()
    {
        $this->redis=new Client();

        $cateData=$this->getCate();
        $intData=$this->getInt();
        if(!$intData['pic']){
            !$intData['pic']=1;
        }
        $this->assign('intData',$intData);
        $this->assign('cateData',$cateData);
    }

    protected function getCate(){
        $cateData = unserialize($this -> redis -> get('cateData'));
        if(!$cateData) {
            $cateData = Category::order('sort desc')->select();
            $this -> redis -> set('cateData',serialize($cateData));
        }
        return $cateData;
    }

    protected function getInt(){
        $intData = unserialize($this -> redis -> get('intData'));
        if(!$intData) {
            $intData = Logos::get(1)->toArray();
            $this -> redis -> set('intData',serialize($intData));
        }
        return $intData;
    }
}