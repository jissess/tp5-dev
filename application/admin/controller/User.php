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
        $users = Users::getUsers(['user_name' => $input['user_name'] ?? ''], [], ['id' => 'desc'], $input['limit'] ?? 10, $input['page'] ?? 1);

        foreach ($users['list'] as $key => $val) {
            if (!empty($val['photo'])) {
                $users['list'][$key]['photo'] = getUrl($request) . $val['photo'];
            }
        }

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

    public function read(Request $request, $id)
    {
        $res = Users::getUser($id);
        (!empty($res['photo'])) ? $res['photo'] = getUrl($request) . $res['photo'] : '';

        return responseSuccess($res);
    }

    public function upload(Request $request)
    {
        $file = request()->file('image');
        $dir = 'upload/user_img';
        $info = $file->validate(['size' => 5242880, 'ext' => 'jpg,png,gif'])->move(saveToPublic() . '/' . $dir);
        if ($info) {
            $res = Users::savePhoto(getUser()->id, '/' . $dir . '/' . $info->getSaveName());
            if (!$res) {
                return responseFail('图片保存失败');
            } else {
                return responseSuccess(['save_path' => $info->getSaveName()]);
            }
        } else {
            return responseFail("{$file->getError()}");
        }
    }
}
