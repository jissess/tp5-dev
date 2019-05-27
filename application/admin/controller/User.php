<?php

namespace app\admin\controller;

use app\model\account\Users;
use think\Controller;
use think\Request;

class User extends Controller
{
    public function home(Request $request)
    {
        $input = $request->get();
        $users = Users::getUsers(['user_name' => $input['user_name']], [], ['id' => 'desc'], $input['limit'], $input['page']);

        return responseSuccess($users);
    }

    public function save(Request $request)
    {
        $input = $request->post();
        $res = Users::saveData($input);

        if (!empty($res['status_code']) && isset($res['status_code'])) {
            return responseFail($res['msg']);
        }

        if (!$res) {
            return responseFail('保存失败！');
        }
        return responseSuccess();
    }
}
