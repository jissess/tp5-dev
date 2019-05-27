<?php

namespace app\model\account;

use app\admin\validate\LoginValidate;
use app\admin\validate\StoreUserValidate;
use think\Model;

class Users extends Model
{
    const STATUS_NORMAL = 1;
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
        $validate = new LoginValidate();
        if (!$validate->check($param)) {
            return returnArr("{$validate->getError()}");
        }
        $user = self::where([
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
        $user = new Users();
        $where1 = array('status' => 1);
        $where = array_merge($cond, $where1);

        if (!empty($field)) {
            $user = $user->field($field);
        }
        if (!empty($order)) {
            $user = $user->order($order);
        }
        if (isset($where['user_name'])) {
            $user = $user->where('user_name', 'like', "{$where['user_name']}%");
            unset($where['user_name']);
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

    public static function saveData($param = [])
    {
        $validate = new StoreUserValidate();
        if (!$validate->check($param)) {
            return returnArr("{$validate->getError()}");
        }

        $user = new Users([
            'user_code'  =>  $param['user_code'],
            'password' =>  md5('123456'),
            'user_name' =>  $param['user_name'],
            'gender' =>  $param['gender'],
            'status' =>  self::STATUS_NORMAL,
        ]);
        $res = $user->save();
        if (!$res) {
            return false;
        }

        return true;
    }

    public static function getUser($id)
    {
        return self::where(['id' => $id])->find()->toArray();
    }

    public static function savePhoto($id, $path)
    {
        $user = new Users();
        $res = $user->save([
            'photo'  =>  $path,
        ],['id' => $id]);
        if (!$res) {
            return false;
        }

        return true;
    }
}
