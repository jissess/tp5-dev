<?php

namespace app\admin\controller;

use app\model\account\User;

class Test
{
    public function test()
    {
        $user = getUser();
        $users = User::getUsers([], [], ['id' => 'desc']);

        return responseSuccess($users);
    }
}