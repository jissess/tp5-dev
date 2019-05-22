<?php

function responseSuccess($data = [])
{
    $merge = [];

    $merge = $data->merge_data ?? [];
    $data = [
        'data' => $data->items(),
        'page' => [
            'total' => $data->total(),
            'line' => $data->perPage(),
            'cur' => $data->currentPage(),
        ],
    ];

    $def = [
        'status_code' => 200,
    ];

    return response()->json(array_merge($def, $data, $merge));
}

function responseFail($msg = '', $code = 500)
{
    return response()->json([
        'status_code' => $code,
        'msg' => $msg,
    ]);
}