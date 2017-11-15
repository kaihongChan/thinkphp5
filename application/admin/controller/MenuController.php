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
use function PHPSTORM_META\elementType;

class MenuController extends BaseController
{
    /**
     * 菜单列表页
     */
    public function indexAction()
    {
        //菜单列表
        $sqlWhere = [];
        $menuList = Menu::all(function($query) use($sqlWhere){
            $query->where($sqlWhere)->order('sort', 'ASC');
        });
        $data = [];
        foreach ($menuList as $record) {
            $data[$record['id']] = [
                'id' => intval($record['id']),
                'pid' => intval($record['pid']),
                'name' => trim($record['title']),
                'function' => trim($record['function']),
                'sort' => intval($record['sort']),
                'ico' => trim($record['icon']),
                'status' => intval($record['status'])
            ];
        }
        //功能分组
        $categories = Functions::functionCategories();
        $functionList = Functions::all(['status' => 1, 'type' => 1]);
        $functionData = [];
        foreach ($functionList as $key => $value) {
            $category = strtolower(trim($value['category']));
            if (in_array($category, array_keys($categories))) {
                $functionData[$categories[$category]][] = $value->toArray();
            } else {
                $functionData[$category][] = $value->toArray();
            }
        }
//        dump(collection($functionList)->toArray());
        $this->assign([
//            'functionData' => $functionData,
            'menuList' => array_values($data)
        ]);
        return view();
    }

    /**
     * 添加菜单
     */
    public function addMenuAction()
    {
        if ($this->request->isPost()) {
            $function = input('post.menu_function');
            $data = [
                'pid' => intval(input('post.pid', 0)),
                'title' => trim(input('post.menu_name')),
                'function' => $function == '#' ? trim($function) : intval($function),
                'sort' => intval(input('post.menu_sort', 0)),
                'status' => intval(input('post.menu_status', 1)),
                'icon' => trim(input('post.menu_icon')),
                'add_time' => time(),
                'update_time' => time()
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
                $functionData[$categories[$category]][] = $value->toArray();
            } else {
                $functionData[$category][] = $value->toArray();
            }
        }

        $this->assign([
            'isAdd' => true,
            'pid' => $pid,
            'functionData' => $functionData
        ]);
        return view('menu:addMenu');
    }

    /**
     * 更新菜单
     */
    public function editMenuAction()
    {
        if ($this->request->isPost()) {
            $menu_id = intval(input('post.menu_id'));
            $function = input('post.menu_function');
            $data = [
                'title' => trim(input('post.menu_name')),
                'function' => $function == '#' ? trim($function) : intval($function),
                'sort' => intval(input('post.menu_sort', 0)),
                'status' => intval(input('post.menu_status', 1)),
                'icon' => trim(input('post.menu_icon')),
                'update_time' => time()
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
        $mid = intval(input('post.id'));

        $result = Menu::destroy(['id' => $mid]);

        if ($result) {
            $this->success('成功删除菜单项！');
        }

        $this->error('删除菜单项失败，请重试！');
    }

    /**
     * 刷新菜单配置信息功能下拉框
     */
    public function refreshMenuFunctionAction()
    {
        $functionId = intval(input('post.functionId'));
        //功能分组
        $categories = Functions::functionCategories();
        $functionList = Functions::all(['status' => 1, 'type' => 1]);
        $functionData = [];
        foreach ($functionList as $key => $value) {
            $category = strtolower(trim($value['category']));
            $value['is_selected'] = false;
            if ($value['id'] == $functionId) {
                $value['is_selected'] = true;
            }
            if (in_array($category, array_keys($categories))) {
                $functionData[$categories[$category]][] = $value->toArray();
            } else {
                $functionData[$category][] = $value->toArray();
            }
        }

        if (!empty($functionData)) {
            return json([
                'code' => 1,
                'data' => $functionData,
                'msg' => ''
            ]);
        } else {
            return json([
                'code' => 0,
                'functionData' => [],
                'msg' => '系统功能获取错误！'
            ]);
        }
    }


}