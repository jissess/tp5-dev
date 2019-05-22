<?php
namespace app\admin\controller;

use app\admin\model\User;
use Firebase\JWT\JWT;
use think\Request;

class Login
{
    protected $timestamp;

    public function __construct()
    {
        $this->timestamp = time();
    }

    /**
     * 登录成功返回令牌
     * @param string user_code 用户登录code
     * @param string pwd       密码
     * @return string token    返回令牌
     */
    public function login(Request $request)
    {
        $input = $request->post();
        $user = User::checkUser($input);
        if (!$user) {
            return responseFail('not find user');
        }
        $token = $this->createJwtToken($user);

        return responseSuccess([$token]);
    }

    /**
     * 生成jwt令牌
     * @param $userInfo 用户信息
     * @return string token 返回令牌
     */
    protected function createJwtToken($userInfo)
    {
        $key = "example_key";
        $alg = 'HS256';
        $payload  = [
            'iss'=>'tp5.iss',
            'aud'=>'tp5.aud',
            'exp'=>$this->timestamp + 600,
            'iat'=>$this->timestamp,
            'sub' => [
                "id" => $userInfo['id'] ?? '',
                "user_code" => $userInfo['user_code'] ?? '',
                "user_name" => $userInfo['user_name'] ?? '',
                "token" => $userInfo['token'] ?? '',
                "photo" => $userInfo['photo'] ?? '',
                "gender" => $userInfo['gender'] ?? '',
                "status" => $userInfo['status'] ?? '',
            ]
        ];

        $token = JWT::encode($payload, $key, $alg);

        return $token;
    }

    /**
     * 退出接口
     * @return \think\response\Json
     */
    public function logout()
    {
//        var_dump(\Cache::store('array')->get('user'));exit();
        return responseSuccess([]);
    }
}