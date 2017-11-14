<?php
/**
 * 用户登录相关
 * Created by PhpStorm.
 * User: chen
 * Date: 17-11-6
 * Time: 上午12:55
 */

namespace app\admin\controller;


use app\admin\model\User;
use think\Controller;

class loginController extends Controller
{
    /**
     * 用户登录页
     */
    public function indexAction()
    {
        //判断是否登录
        if (User::isLogined()) {
            // 已登陆则跳转首页
            $this->redirect('index/index');
            exit();
        }

        if ($this->request->isPost()) {
            $username = input('post.username');
            $password = input('post.password');
            $error = '';
            $success = User::userLogin($username, $password, $error);
            if ($success) {
                $this->redirect('index/index');
                exit;
            }
            $this->assign([
                'error' => $error,
                'username' => $username
            ]);
        }

        return view();
    }

    /**
     * 注销登录
     */
    public function logoutAction()
    {
        session(null);
        cookie(null);
        $this->redirect('login/index');
        return true;
    }

    protected $needLogin = false;
}