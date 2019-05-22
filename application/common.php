<?php

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