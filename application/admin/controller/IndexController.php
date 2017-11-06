<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 17-11-5
 * Time: 下午9:50
 */

namespace app\admin\controller;


class IndexController extends BaseController
{
    /**
     * 系统布局
     */
    public function indexAction()
    {
        $this->assign('test', 'what the fuck!');
        return $this->fetch();
    }

    /**
     * 系统首页
     */
    public function contentAction()
    {
        $this->assign('test', 'what the fuck!');
        return $this->fetch();
    }
}