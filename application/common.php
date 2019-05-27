<?php

function getUser()
{
    return \Cache::store('array')->get('user');
}

function getPage(&$m, $where, $limit)
{
    $total = $m->where($where)->count();
    $page = ceil($total / $limit);

    return ['total' => $total, 'page' => $page];
}

function responseSuccess(Array $params = [], $msg = '成功', $code = 200)
{
    return json([
        'status_code' => $code,
        'msg' => $msg,
        'data' => $params
    ]);
}

function responseFail($msg = '', $code = 500)
{
    return json([
        'status_code' => $code,
        'msg' => $msg,
    ]);
}

function returnArr($msg = '', $code = 500)
{
    return ['status_code' => $code, 'msg' => $msg];
}

function saveToPublic()
{
    return '../public';
}

function getUrl(\think\Request $request)
{
    return $request->domain();
}