<?php
/**
 * Created by PhpStorm.
 * Description:miss路由位置
 * Author: sunnier
 * Email: xiaoyao_xiao@126.com
 * Date: 2019/8/5
 * Time: 10:20
 */
namespace app\api\controller;

class Miss extends Base
{
    /**
     * Description:未找到路由的公共位置
     * Author: sunnier
     * Email: xiaoyao_xiao@126.com
     * Date: 2019/8/5
     * Time: 10:20
     */
    public function index(){
        return api_res(-1000,'未找到路由');
    }
}