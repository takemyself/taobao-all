<?php
/**
 * Created by PhpStorm.
 * User : Leopard
 * Date : 2018/3/22
 * Time : 15:44
 * Email: 417780879@qq.com
 */
namespace app\index\controller;
class Actives extends Base
{
    protected $model;
    public function _initialize()
    {
        parent ::_initialize();
        $this->active=2;
        $this->assign('ac',$this->active);
    }

}