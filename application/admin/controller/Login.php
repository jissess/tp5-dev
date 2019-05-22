<?php
namespace app\admin\controller;

use think\Request;

class Login
{
    public function login(Request $request)
    {
        $code = $request->post();
        var_dump($code['user_code']);exit();
    }
}