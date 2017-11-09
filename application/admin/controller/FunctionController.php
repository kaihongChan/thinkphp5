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
        return view();
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

        $functionList= Functions::all(function($query) use($sqlWhere, $pageStart, $pageSize){
            $query->where($sqlWhere)->limit($pageStart, $pageSize);
        });

        foreach ($functionList as $key => $function) {
            $function['status'] = ['<span class="label label-warning">禁用</span>', '<span class="label label-success">启用</span>'][$function['status']];
            $function['type'] = ['<span class="label label-info">普通</span>', '<span class="label label-success">菜单</span>'][$function['type']];
            $function['action_name'] = $function['action'];
            $functionList[$key] = $function;
        }
        $functionCount = Functions::where($sqlWhere)->count();
        return json([
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
        if ($this->request->isPost()) {
            $module = strtolower(trim(input('post.module')));
            $controller = strtolower(trim(input('post.controller')));
            $action = strtolower(trim(input('post.action')));
            $data = [
                'category' => $controller,
                'module' => $module,
                'controller' => $controller,
                'action' => $action,
                'name' => trim(input('post.function_name')),
                'description' => trim(input('post.description')),
                'status' => intval(input('post.status')),
                'type' => intval(input('post.type')),
                'add_time' => time(),
                'update_time' => time(),
            ];
            $functionModel = Functions::create($data);

            if ($functionModel->result) {
                $this->success('成功添加系统功能！');
            } else {
                $this->error('添加系统功能失败，请重试！');
            }
            exit;
        }
        $this->assign('isAdd', true);
        return view('function:addFunction');
    }

    /**
     * 更新系统功能
     */
    public function editFunctionAction()
    {
        if ($this->request->isPost()) {
            $id = intval(input('post.fid'));
            $module = strtolower(trim(input('post.module')));
            $controller = strtolower(trim(input('post.controller')));
            $action = strtolower(trim(input('post.action')));
            $data = [
                'category' => $controller,
                'module' => $module,
                'controller' => $controller,
                'action' => $action,
                'name' => trim(input('post.function_name')),
                'description' => trim(input('post.description')),
                'status' => intval(input('post.status')),
                'type' => intval(input('post.type')),
                'update_time' => time(),
            ];

            $functionModel = Functions::update($data, ['id' => $id]);

            if ($functionModel->result) {
                $this->success('成功更新系统功能！');
            } else {
                $this->error('更新系统功能失败，请重试！');
            }
            exit;
        }

        $id = intval(input('get.fid'));
        $functionInfo = Functions::get(['id' => $id]);
        $this->assign('functionInfo', $functionInfo);
        $this->assign('isAdd', false);
        return view('function:addFunction');
    }

    /**
     * 删除系统功能
     */
    public function deleteFunctionAction()
    {
        $id = input('post.fid');

        $result = Functions::destroy(['id' => $id]);

        if($result){
            $this->success('成功删除系统功能！');
        }

        $this->error('删除系统功能失败，请重试！');
    }
}