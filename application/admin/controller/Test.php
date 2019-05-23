<?php

namespace app\admin\controller;

class Test
{
    public function test()
    {
        $user = getUser();
        var_dump($user);
    }
}