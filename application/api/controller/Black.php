<?php
/**
 * Created by nineton.
 * Description:黑名单列表
 * User: sunnier
 * Email: xiaoyao_xiao@126.com
 * Date: 2019-12-01
 * Time: 12:34
 */
namespace app\api\controller;

class Black extends Base
{
    protected $blackService;

    public function initialize()
    {
        parent::initialize();

        $this->blackService=app('app\common\service\BlackListService');
    }

    /**
     * Description:
     * User: sunnier
     * Email: xiaoyao_xiao@126.com
     * Date: 2019-12-01 13:24
     */
    public function index(){
        $postData=input('get.');
        if(!empty($postData['page'])) {
            $page = $postData['page'];
        }else{
            $page=1;
        }
        if(!empty($postData['per_page'])) {
            $listRow = $postData['per_page'];
        }else{
            $listRow=10;
        }
        $result=$this->blackService->getList([],$page,$listRow);
        return api_res($result['status'],$result['msg'],$result['data']);
    }
}