<?php
/**
 * Created by PhpStorm.
 * User : Leopard
 * Date : 2018/3/23
 * Time : 15:27
 * Email: 417780879@qq.com
 */
namespace app\index\validate;
use think\Validate;

class Messages extends Validate
{
    protected $rule = [
        'name'  =>  'require|max:50',
        'email' =>  'require|email',
        'phone' =>  'require|number|max:11|min:8',
        'messages' =>  'require',
    ];
    protected $message  =   [
        'name.require' => 'Name cannot be empty',
        'name.max'     => 'The name cannot exceed 50 characters',
        'email.require'   => 'Email cannot be empty',
        'email.email'  => 'Wrong mailbox format',
        'phone.require'  => 'Phone number cannot be empty',
        'phone.number'  => 'Phone number must a number',
        'phone.max'  => 'The phone number cannot exceed 11 characters',
        'phone.min'  => 'The phone number cannot less than 11 characters',
        'messages.require'  => 'Message cannot be empty',
    ];
}