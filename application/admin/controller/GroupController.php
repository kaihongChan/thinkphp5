<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 17-11-6
 * Time: 上午7:03
 */

namespace app\admin\controller;


use app\admin\model\Functions;
use app\admin\model\Group;

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
    public function getGroupListAction()
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

        $groupList = Group::all(function($query) use($sqlWhere, $pageStart, $pageSize){
            $query->where($sqlWhere)->limit($pageStart, $pageSize)->order('id', 'ASC');
        });

        foreach ($groupList as $key => $group) {
            $group['status'] = ['<span class="label label-warning">禁用</span>', '<span class="label label-success">启用</span>'][$group['status']];
            $groupList[$key] = $group;
        }
        $groupCount = Group::where($sqlWhere)->count();
        echo json_encode([
            'iTotalDisplayRecords' => !empty($groupCount) ?  $groupCount : 0,
            'iTotalRecords' => $pageSize,
            'aaData' => $groupList,
        ]);
    }

    /**
     * 添加用户组
     */
    public function addGroupAction()
    {
        if ($this->request->isPost()) {
            var_dump($_POST);
            die;
            $data = [
                'name' => trim(input('post.group_name')),
                'sort' => intval(input('post.sort')),
                'description' => trim(input('post.description')),
                'status' => intval(input('post.status')),
                'add_time' => time(),
            ];
            $groupModel = Group::create($data);

            if ($groupModel->result) {
                $this->success('成功添加用户组！');
            } else {
                $this->error('添加用户组失败，请重试！');
            }
            exit;
        }

        //功能分组
        $categories = Functions::functionCategories();
        $functionList = Functions::all(['status' => 1]);
        $functionData = [];
        foreach ($functionList as $key => $value) {
            $category = strtolower($value['category']);
            if (in_array($category, array_keys($categories))) {
                $functionData[$categories[$category]][] = $value;
            } else {
                $functionData[$category][] = $value;
            }
        }

        $this->assign('functionData', $functionData);
        $this->assign('isAdd', true);
        echo $this->fetch('group:addGroup');
    }

    /**
     * 更新用户组
     */
    public function editGroupAction()
    {
        $gid = input('get.gid');

        if ($this->request->isPost()) {
            var_dump($_POST);
            die;
            $gid = intval(input('post.gid'));
            $data = [
                'name' => trim(input('post.group_name')),
                'sort' => intval(input('post.sort')),
                'description' => trim(input('post.description')),
                'status' => intval(input('post.status')),
                'update_time' => time(),
            ];

            $groupModel = Group::update($data, ['id' => $gid]);

            if ($groupModel->result) {
                $this->success('成功更新用户组！');
            } else {
                $this->error('更新用户组失败，请重试！');
            }
            exit;
        }

        //用户组信息
        $groupInfo = Group::get(['id' => $gid]);
        foreach ($groupInfo as $key => $group) {
            $group['powers'] = empty($group['powers']) ? [] : json_decode($group['powers'], true);
            $groupInfo[$key] = $group;
        }

        //功能分组
        $categories = Functions::functionCategories();
        $functionList = Functions::all(['status' => 1]);
        $functionData = [];
        foreach ($functionList as $key => $value) {
            $category = strtolower($value['category']);
            if (in_array($category, array_keys($categories))) {
                $functionData[$categories[$category]][] = $value;
            } else {
                $functionData[$category][] = $value;
            }
        }

        $this->assign('functionData', $functionData);
        $this->assign('groupInfo', $groupInfo);
        $this->assign('isAdd', false);
        $this->assign('groupInfo', $groupInfo);
        echo $this->fetch('group:addGroup');
    }

    /**
     * 删除用户组
     */
    public function deleteGroupAction()
    {
        $gid = input('post.gid');

        if ($gid == 1) {
            $this->error('超级管理员分组不可删除！');
        }

        $result = Group::destroy(['id' => $gid]);

        if ($result) {
            $this->success('成功删除用户组！');
        }

        $this->error('删除用户组失败，请重试！');
    }

    /**
     * 用户组权限分配
     */
    public function distributeAction()
    {

    }
}