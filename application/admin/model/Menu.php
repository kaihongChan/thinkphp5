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
     */
    public static function makeMenuTree()
    {

    }
}