<?php
namespace app\common\exception;

use Exception;
use think\exception\Handle;
use think\exception\HttpException;
use think\facade\Log;

/**
 * Class ApiException
 * @package app\common\exception
 * Description:api错误处理类
 * User: sunnier
 * Email: xiaoyao_xiao@126.com
 * Date: 2019-08-20 19:07
 */
class ApiException extends Handle
{
    public function render(Exception $e)
    {
        // 请求异常
        if ($e instanceof HttpException && request()->isAjax()) {
            //return response($e->getMessage(), $e->getStatusCode());
            return api_res(-10000,$e->getMessage());
        }

        //TODO::开发者对异常的操作
        //可以在此交由系统处理
	    Log::error($e->getMessage().'，文件名：'.$e->getFile().'行号：'.$e->getTraceAsString());
        return api_res(-10000,$e->getMessage().'，文件名：'.$e->getFile().'行号：'.$e->getTraceAsString());
    }
}