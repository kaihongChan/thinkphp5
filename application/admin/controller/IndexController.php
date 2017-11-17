<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 17-11-5
 * Time: 下午9:50
 */

namespace app\admin\controller;


use app\admin\model\Functions;
use app\admin\model\Menu;
use app\admin\model\User;

class IndexController extends BaseController
{
    /**
     * 系统布局
     */
    public function indexAction()
    {
        $menuList = User::getPowerMenuList();
        $navigation = Menu::makeMenuTree($menuList);
        $this->assign([
            'navigation' => $navigation,
            'adm_name' => session('adm_username'),
            'adm_group' => session('adm_group'),
        ]);
        return view();
    }

    /**
     * 系统首页
     */
    public function contentAction()
    {
//        $menuList = User::getPowerMenuList();
//        $navigation = Menu::makeMenuTree($menuList);
//        dump($menuList);
        return view();
    }
}