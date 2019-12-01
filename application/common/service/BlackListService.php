<?php
/**
 * Created by nineton.
 * Description:黑名单服务类
 * User: sunnier
 * Email: xiaoyao_xiao@126.com
 * Date: 2019-12-01 12:46
 */
namespace app\common\service;

class BlackListService extends BaseService
{
    protected $blackListModel;

    public function __construct()
    {
        parent::__construct();
        $this->blackListModel=model('common/Blacklist');
    }

    /**
     * @param array $where
     * @param int $page
     * @param string $order
     * @param int $listRow
     * @return array
     * Description:获取列表
     * User: sunnier
     * Email: xiaoyao_xiao@126.com
     * Date: time
     */
    public function getList($where=[],$page=1,$listRow=10,$order='sort_num DESC,id DESC'){
        $count=$this->blackListModel->where($where)->where('status',1)->count();
        if($count>0){
            $list=$this->blackListModel->field('id,title,description,name,url')->where($where)->where('status',1)->order($order)->page($page,$listRow)->select();
            return [
                'status'=>1,
                'msg'=>'获取成功！',
                'data'=>$list
            ];
        }else{
            $list=[];
            return [
                'status'=>1,
                'msg'=>'没数据了',
                'data'=>$list
            ];
        }
    }
}