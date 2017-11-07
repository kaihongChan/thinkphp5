<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 17-11-7
 * Time: 上午7:22
 */

namespace app\admin\model;


class Functions extends Base
{
    protected $table = 'thinkphp_function';

    /**
     * 功能分组
     * @return array
     */
    public static function functionCategories()
    {
        return [
            'user' => '用户',
            'group' => '用户组',
            'function' => '系统功能',
            'menu' => '系统菜单',
        ];
    }
}