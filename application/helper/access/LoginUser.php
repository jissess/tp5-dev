<?php
namespace app\helper\access;

use app\admin\model\User;

class LoginUser
{
    protected $user;
    protected $userModel;

    public function __construct(User $user)
    {
        $this->userModel = $user;
    }

    public function __get($name)
    {
        return $this->user[$name] ?? null;
    }

    public function userModel()
    {
        return $this->userModel;
    }

    public function toArray()
    {
        return $this->user;
    }
}