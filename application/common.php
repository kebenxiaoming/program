<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
//接口返回
function api_res($status,$msg,$data=[],$code=200,$head=[],$option=[]){
    $apiData=[
        'code'=>$status,
        'msg'=>$msg,
        'data'=>$data
    ];
    return json($apiData,$code,$head,$option);
}