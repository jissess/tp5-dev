<?php

namespace app\admin\validate;

use think\Validate;

class StoreUserValidate extends Validate
{
	protected $rule = [
	    'user_code' => 'require|unique:user,status=1',
	    'user_name' => 'require',
	    'gender' => 'require',
    ];

    protected $message = [
        'user_code.require' => '登录名不能为空',
        'user_code.unique' => '登录名已存在',
        'user_name.require' => '用户名不能为空',
        'gender.require' => '性别不能为空',
    ];
}
