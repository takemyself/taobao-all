<?php
/**
 * Created by PhpStorm.
 * User : Leopard
 * Date : 2018/1/3
 * Time : 10:08
 * Email: 417780879@qq.com
 */
namespace app\index\model;
use app\common\model\Common;
use think\Model;

class Messages extends Common
{
    protected $table='res_messages';
    protected $pk='id';
}