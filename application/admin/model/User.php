<?php

namespace app\admin\model;

use think\Model;

class User extends Model
{
    // 设置当前模型对应的完整数据表名称
    protected $table = 'user';

    // 设置当前模型的数据库连接
//    protected $connection = 'db_config';

    /**
     * 返回是否查询到用户，true是查到用户，false是未查到用户
     * @param array $param 用户提交的账号和密码
     * @return array|bool
     */
     public static function login($param = [])
     {
         $user = User::where([
             'status' => 1,
             'user_code' => $param['user_code'],
             'password' => md5($param['password'])
         ])->find();

         if (empty($user)) {
             return false;
         }

         return $user->toArray();
     }
}
