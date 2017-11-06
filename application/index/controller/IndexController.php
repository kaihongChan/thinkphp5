<?php
namespace app\index\controller;

use think\Controller;

class IndexController extends Controller
{
    public function indexAction()
    {
        $this->assign('test', 'what the fuck!');
        return $this->fetch();
    }
}