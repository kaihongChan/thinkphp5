<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 17-11-6
 * Time: 上午7:03
 */

namespace app\admin\controller;


class GroupController extends BaseController
{
    /**
     * 用户组列表页
     */
    public function indexAction()
    {
        return $this->fetch();
    }

    /**
     * 获取用户组分页列表
     */
    public function getGroupList()
    {
        //前端参数传入
        $aoData = json_decode($_POST['aoData'],TRUE);
        foreach ($aoData as $key => $value) {
            $pkey = $key;
            $pval = $value;
            $param[$pkey] = $pval;
        }

        $pageStart = !empty($param['iDisplayStart']) ? $param['iDisplayStart'] : 0;   //default pageStart
        $pageSize = !empty($param['iDisplayLength']) ? $param['iDisplayLength'] : 10; //default pageSize
        $searchKey = !empty($param['sSearch']) ? $param['sSearch'] : '';

        //检索条件
        $sqlWhere = empty($searchKey) ? [] : [ 'id | name' => ['like', '%'.$searchKey.'%']];
        $groupModel = $this->initModel('Group');
        $groupList = $groupModel->getList($pageStart, $pageSize, $sqlWhere);
        foreach ($groupList as $key => $group) {
            $group['status'] = ['<span class="label label-warning">禁用</span>', '<span class="label label-success">启用</span>'][$group['status']];
            $groupList[$key] = $group;
        }
        $groupCount = $groupModel->getListCount($sqlWhere);
        echo json_encode([
            'iTotalDisplayRecords' => !empty($groupCount) ?  $groupCount : 0,
            'iTotalRecords' => $pageSize,
            'aaData' => $groupList,
        ]);
    }
}