<?php
namespace app\index\controller;

use app\admin\model\Actions;
use app\admin\model\Advertising;
use app\admin\model\Banner;
use app\admin\model\News;
use app\admin\model\Category;
use app\admin\model\Videos;

class Index extends Base
{
    public function _initialize()
    {
        parent ::_initialize();
        $this->assign('ac',$this->active);
    }

    public function index()
    {
        $bannerData=Banner::order('sort desc')->limit(3)->select();
        $newsData=News::order('create_time desc')->limit(3)->select();
        $oldnewscategoryData=Category::all()->toArray();
        $newscategoryData=[];
        foreach($oldnewscategoryData as $k=>$v){
            $newscategoryData[$v['cid']]=$v['cname'];
        }
        $actionsData=Actions::order('create_time desc')->limit(4)->select();
        $videosData=Videos::order('create_time desc')->limit(5)->select();
        $adData=Advertising::order('sort desc')->limit(4)->select();
        $this->assign('newscategoryData',$newscategoryData);
        $this->assign('bannerData',$bannerData);
        $this->assign('newsData',$newsData);
        $this->assign('actionsData',$actionsData);
        $this->assign('videosData',$videosData);
        $this->assign('adData',$adData);
        return view();
    }
}
