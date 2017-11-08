<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 17-11-8
 * Time: 上午5:53
 */

namespace app\admin\controller;


use app\admin\model\Functions;
use app\admin\model\Menu;

class MenuController extends BaseController
{
    /**
     * 菜单列表页
     */
    public function indexAction()
    {
        //TODO：菜单列表 格式：array[id=>'', name=>'', sort=>'', icon=>'', function=>'', open:true/false, children=>array[id=>'', name=>'', sort=>'', icon=>'', function=>'']]
        //菜单列表
        $sqlWhere = [];
        Menu::all(function($query) use($sqlWhere){
            $query->where($sqlWhere)->order('sort', 'ASC');
        });
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
        return $this->fetch();
    }

    /**
     * 添加菜单
     */
    public function addMenuAction()
    {
        if ($this->request->isPost()) {
            $data = [
                'pid' => intval(input('post.pid', 0)),
                'title' => trim(input('post.menu_name')),
                'function' => trim(input('post.menu_function')),
                'sort' => intval(input('post.menu_sort', 0)),
                'status' => intval(input('post.menu_status', 1)),
                'icon' => trim(input('post.menu_icon'))
            ];
            $menuModel = Menu::create($data);
            if ($menuModel->result) {
                $this->success('成功添加系统菜单！');
            } else {
                $this->error('添加系统菜单失败，请重试！');
            }
        }
        $pid = intval(input('get.pid',0));
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
        $this->assign('isAdd', true);
        $this->assign('pid', $pid);
        $this->assign('functionData', $functionData);
        echo $this->fetch('menu:addMenu');
    }

    /**
     * 更新菜单
     */
    public function editMenuAction()
    {
        if ($this->request->isPost()) {
            $menu_id = intval(input('post.menu_id'));
            //TODO:名称与功能做判断
            var_dump($menu_id);
            die;
            $data = [
                'title' => trim(input('post.menu_name')),
//                'function' => trim(input('post.menu_function')),
                'sort' => intval(input('post.menu_sort', 0)),
                'status' => intval(input('post.menu_status', 1)),
//                'icon' => trim(input('post.menu_icon'))
            ];
            $menuModel = Menu::update($data, ['id' => $menu_id]);
            if ($menuModel->result) {
                $this->success('成功更新系统菜单！');
            } else {
                $this->error('更新系统菜单失败，请重试！');
            }

        }
    }

    /**
     * 删除菜单项
     */
    public function deleteMenuAction()
    {
        //TODO:删除
    }
}