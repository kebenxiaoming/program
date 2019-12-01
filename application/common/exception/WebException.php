<?php
/**
 * User: zhang 270938250@qq.com
 * Date: 2019/1/25
 * Time: 10:22
 */

namespace app\common\exception;

use Exception;
use think\exception\Handle;
use think\facade\Request;
use think\facade\Response;
use think\facade\Log;

class WebException extends Handle
{
    /**
     * @param Exception $exception
     * @return \think\Response|\think\response\Json
     * Description:处理异常
     * User: sunnier
     * Email: xiaoyao_xiao@126.com
     * Date: 2019-08-13 18:09
     */
    protected function convertExceptionToResponse(Exception $exception)
    {
        $url = Request::url(true);
        // 收集异常数据
        if (config('app_debug')) {
            $template = config('exception_tmpl');
            // 调试模式，获取详细的错误信息
            $data = [
                'name' => get_class($exception),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
                'message' => $this->getMessage($exception),
                'trace' => $exception->getTrace(),
                'code' => $this->getCode($exception),
                'source' => $this->getSourceCode($exception),
                'datas' => $this->getExtendData($exception),
                'tables' => [
                    'GET Data' => $_GET,
                    'POST Data' => $_POST,
                    'Files' => $_FILES,
                    'Cookies' => $_COOKIE,
                    'Session' => isset($_SESSION) ? $_SESSION : [],
                    'Server/Request Data' => $_SERVER,
                    'Environment Variables' => $_ENV,
                ],
            ];
        } else {
            $template = \config('custom_tmpl');
            // 部署模式仅显示 Code 和 Message
            $data = [
                'name' => get_class($exception),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
                'message' => $this->getMessage($exception),
                'trace' => $exception->getTrace(),
                'code' => $this->getCode($exception),
                'source' => $this->getSourceCode($exception),
                'datas' => $this->getExtendData($exception),
                'tables' => [
                    'GET Data' => $_GET,
                    'POST Data' => $_POST,
                    'Files' => $_FILES,
                    'Cookies' => $_COOKIE,
                    'Session' => isset($_SESSION) ? $_SESSION : [],
                    'Server/Request Data' => $_SERVER,
                    'Environment Variables' => $_ENV,
                ],
            ];
            if (!config('app.show_error_msg')) {
                // 不显示详细错误信息
                $data['message'] = '你的页面错误了！';
            }
        }
        Log::error('请求地址：' . $url . PHP_EOL . '文件名：' . $exception->getFile() . PHP_EOL . '行数' . $exception->getLine() . PHP_EOL . '消息：' . $exception->getMessage() . PHP_EOL . 'trace:' . $exception->getTraceAsString() . PHP_EOL . '全：' . json_encode($exception));
        if (request()->isAjax()) {
            return $this->returnJson($data['message'], $data['code']);
        } else {
            //保留一层
            while (ob_get_level() > 1) {
                ob_end_clean();
            }
            $data['echo'] = ob_get_clean();
            ob_start();
            extract($data);

            include $template;

            // 获取并清空缓存
            $content = ob_get_clean();
            $response = Response::content($content);

            if ($exception instanceof \think\exception\HttpException) {
                $statusCode = $exception->getStatusCode();
                $response->header($exception->getHeaders());
            }
            if (!isset($statusCode)) {
                $statusCode = 500;
            }
            $response->code($statusCode);
            return $response;
        }
    }

    public function render(\Exception $exception)
    {
        return $this->convertExceptionToResponse($exception);
    }

    /**
     * 设置json返回值
     * @param $msg
     * @param $status 1成功，0没获取到信息，11,错误
     * @param array $myData
     * @param int $code
     * @param array $header
     * @return \think\response\Json
     */
    public function returnJson($msg, $status, $myData = array(), $code = 200, $header = array('Access-Control-Allow-Origin' => '*', 'Access-Control-Allow-Headers' => 'content-type,token'))
    {
        $data = array(
            'data' => $myData,
            'msg' => $msg,
            'code' => $status,
        );
        return json($data, $code, $header);
    }
}