<?php
/**
 * Created by nineton.
 * Description:
 * User: sunnier
 * Email: xiaoyao_xiao@126.com
 * Date: 2019-12-01
 * Time: 12:36
 */
namespace app\api\controller;

use think\Controller;
use think\facade\Request;
class Base extends Controller
{
    protected $request;

    public function initialize()
    {
        parent::initialize();

        $this->request=Request::instance();
    }
}