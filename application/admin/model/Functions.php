<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 17-11-7
 * Time: 上午7:22
 */

namespace app\admin\model;

use ReflectionClass;
use ReflectionMethod;

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
            'index' => '系统主页',
            'user' => '用户',
            'group' => '用户组',
            'function' => '系统功能',
            'menu' => '系统菜单',
        ];
    }

    /**
     * 获取程序所有controller文件名
     */
    public static function getControllerNameList()
    {
        $controllerDir = APP_PATH.'admin/controller';
        $fileNameList = scandir($controllerDir);
        $controllerNameList = [];
        foreach ($fileNameList as $key => $fileName) {
            if (strlen($fileName) > 10) {
                $controllerNameList[] = substr($fileName, 0, -4);
            }
        }
        return $controllerNameList;
    }

    /**
     * 过滤controller
     */
    public static function filterControllerNameList()
    {
        $controllerNameList = self::getControllerNameList();
        foreach ($controllerNameList as $controllerName) {
            $controller = sprintf('app\\admin\\controller\\%s', $controllerName);
            $ReflectionClass = new ReflectionClass($controller);
            $parentClass = $ReflectionClass->getParentClass()->getName();

            if ($parentClass == 'app\admin\controller\BaseController') {
                $controller = strtolower(substr($ReflectionClass->getShortName(), 0, -10));
                $filter[] = $controller;
            }

        }
        return $filter;
    }

    /**
     * @param $controller
     * 获取controller下action
     * @return array
     */
    public static function getFunctionListByController($controller)
    {
        $action = [];
        $controllerName = sprintf('app\\admin\\controller\\%sController', ucfirst($controller));
        $ReflectionClass = new ReflectionClass($controllerName);

        foreach ($ReflectionClass->getMethods(ReflectionMethod::IS_PUBLIC) as $rM) {
            if (6 < strlen($rM->getName()) && 'action' == strtolower(substr($rM->getName(), -6))) {
                $action[] = strtolower(substr($rM->getName(), 0, -6));
            }
        }


        return $action;
    }
}