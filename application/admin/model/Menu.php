<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 17-11-7
 * Time: 上午7:53
 */

namespace app\admin\model;


class Menu extends Base
{
    protected $table = 'thinkphp_menu';

    /**
     * 生成树形列表
     * @param $menuList
     * @param $pid
     * @return array
     */
    public static function makeMenuTree($menuList, $pid = 0)
    {
        $tree = [];
        foreach ($menuList as $key => $menu) {
            if($menu['pid'] == $pid) {        //父亲找到儿子
                $menu['pid'] = self::makeMenuTree($menuList, $menu['id']);
                $tree[] = $menu;
            }
        }
        return $tree;
    }
}