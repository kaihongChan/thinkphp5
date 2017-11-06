<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 17-11-7
 * Time: 上午7:12
 */

namespace app\admin\controller;


use app\admin\model\Functions;

class FunctionController extends BaseController
{
    /**
     * 系统功能列表
     */
    public function indexAction()
    {
        return $this->fetch();
    }

    /**
     * 获取系统功能列表
     */
    public function getFunctionListAction()
    {
        //前端参数传入
        $aoData = json_decode($_POST['aoData'], TRUE);
        foreach ($aoData as $key => $value) {
            $pkey = $key;
            $pval = $value;
            $param[$pkey] = $pval;
        }

        $pageStart = !empty($param['iDisplayStart']) ? $param['iDisplayStart'] : 0;   //default pageStart
        $pageSize = !empty($param['iDisplayLength']) ? $param['iDisplayLength'] : 10; //default pageSize

        //检索条件
        $sqlWhere = [
//            'status' => 1,
        ];
        $functionList= Functions::where($sqlWhere)->limit($pageStart, $pageSize)->select();

        foreach ($functionList as $key => $function) {
            $function['status'] = ['<span class="label label-warning">禁用</span>', '<span class="label label-success">启用</span>'][$function['status']];
            $function['type'] = ['<span class="label label-info">普通</span>', '<span class="label label-success">菜单</span>'][$function['type']];
            $function['action_name'] = $function['action'];
            $functionList[$key] = $function;
        }
        $functionCount = Functions::where($sqlWhere)->count();
        echo json_encode([
            'iTotalDisplayRecords' => !empty($functionCount) ? $functionCount : 0,
            'iTotalRecords' => $pageSize,
            'aaData' => $functionList,
        ]);
    }

    /**
     * 添加系统功能
     */
    public function addFunctionAction()
    {
        echo $this->fetch('function:addFunction');
    }

    /**
     * 更新系统功能
     */
    public function editFunctionAction()
    {
        echo $this->fetch('function:addFunction');
    }

    /**
     * 删除系统功能
     */
    public function deleteFunctionAction()
    {
        $identification = input('post.identification');

        $result = Functions::destroy(['identification' => $identification]);

        if($result){
            $this->success('成功删除系统功能！');
        }

        $this->error('删除系统功能失败，请重试！');
    }
}