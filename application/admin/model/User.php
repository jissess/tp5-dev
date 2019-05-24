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

    /**
     * @param array $cond   查询条件，例如['status' => 1, 'user_code' => ?]
     * @param array $field  返回的列,例如['id', 'user_code']
     * @param array $order  排序，例如['id'=>'desc']
     * @param int $limit    每页显示条数
     * @param int $page     当前页
     * @return array        返回数据
     */
    public static function getUsers($cond = [], $field = [], $order = [], $limit = 10, $page = 1)
    {
        $user = new User();
        $where1 = array('status' => 1);
        $where = array_merge($cond, $where1);

        if (!empty($field)) {
            $user = $user->field($field);
        }
        if (!empty($order)) {
            $user = $user->order($order);
        }

        $pages = getPage($user, $where, $limit);

        $data = [];
        $data['total'] = $pages['total'];
        $data['page'] = $pages['page'];

        $users = $user->where($where)->page($page, $limit)->select()->toArray();

        $data['list'] = $users;

        if (empty($users)) {
            return $data;
        }

        return $data;
    }
}
