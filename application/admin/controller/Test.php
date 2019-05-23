<?php
namespace app\admin\controller;

use think\Cache;

class Test
{
    public function index()
    {
        echo '这是后台的index方法';
    }

    public function test1()
    {
        $user = getUser();
        var_dump($user);
    }
}