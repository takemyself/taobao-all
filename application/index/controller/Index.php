<?php
/**
 * Created by PhpStorm.
 * User : Leopard
 * Date : 2018/5/26
 * Time : 17:17
 * Email: 417780879@qq.com
 */
namespace app\index\controller;
use app\admin\model\Banner;
use app\admin\model\Goods;
use app\common\controller\Base;
use Predis\Client;
use think\Request;
use think\Session;

class Index extends Base
{
    protected $times;
    public function _initialize()
    {
        parent ::_initialize();
        $this -> times = date("Y-m-d",time());
        $bid = Session ::get('bid');
        $this -> assign('bid',$bid);
    }

    public function index()
    {
        $goodsData = $this->getGoodsData();
        $banData   = $this->getBannerData();
        $this -> assign('banData',$banData);
        $this -> assign('goodsData',$goodsData);
        return view();
    }

    protected function getBannerData(){
        $banData = unserialize($this -> redis -> get('banData'));
        if(!$banData) {
            $banData = Banner::order('sort desc')->limit(3)->select()->toArray();
            $this -> redis -> set('banData',serialize($banData));
        }
        return $banData;
    }

    protected function getGoodsData(){
        $goodsData = unserialize($this -> redis -> get('goodsData'));
        if(!$goodsData) {
            $goodsData = Goods ::where('lasttime','>',$this -> times) -> order('sta desc') -> select() -> toArray();
            $this -> redis -> set('goodsData',serialize($goodsData));
        }
        return $goodsData;
    }

    public function category(Request $request)
    {
        Session ::set('bid',2);
        $cid          = $request -> param('cid');
        $oldData=$this->getCategoryData();
        $goodsAllData = isset($oldData[$cid])?$oldData[$cid]:null;
        $this -> assign('cid',$cid);
        $this -> assign('goodsAllData',$goodsAllData);
        return view();
    }

    protected function getCategoryData()
    {
        $goodsData=$this->getGoodsData();
        $goodsAllData = unserialize($this -> redis -> get('goodsAllData'));
        if(!$goodsAllData){
            foreach($goodsData as $k=>$v){
                $goodsAllData[$v['cid']][]=$v;
            }
            $this -> redis -> set('goodsAllData',serialize($goodsAllData));
        }
        return $goodsAllData;
    }

    public function contents(Request $request)
    {
        Session ::set('bid',2);
        $id                  = $request -> param('id');
        $oldData=$this->getContentsData();
        $contents            = isset($oldData[$id])?$oldData[$id]:null;
        $contents['content'] = explode(',',$contents['content']);
        $this -> assign('contents',$contents);
        return view();
    }

    protected function getContentsData()
    {
        $goodsData=$this->getGoodsData();
        $contents = unserialize($this -> redis -> get('contents'));
        if(!$contents){
            foreach($goodsData as $k=>$v){
                $contents[$v['id']]=$v;
            }
            $this -> redis -> set('contents',serialize($contents));
        }
        return $contents;
    }

    public function aaa(Request $request)
    {
        $arr=[
          'a'=>1,
          'b'=>2,
        ];
        $this->redis->hmset('a',$arr);
        $a=$this->redis->hgetall('a');
        dump($a);
        return view();
    }
}