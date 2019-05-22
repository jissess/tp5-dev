<?php
namespace app\helper\account;

use app\admin\model\User;

class AuthHelper
{
    static public function setLoginUser(User $user)
    {

        $loginUser = new LoginUser($user);
        \Cache::store('array')->put('user', $loginUser, 1);

    }
}