<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 17-11-6
 * Time: 上午12:55
 */

namespace app\admin\controller;


use app\admin\model\User;

class loginController extends BaseController
{
    /**
     * 用户登录页
     */
    public function indexAction()
    {
        $errorMsg = '';
        $username = '';
        //判断是否登录
        if (User::isLogined()) {
            // 已登陆则跳转回首页
            $this->redirect('index/index');
            exit();
        }

        if ($this->request->isPost()) {
            $username = input('post.username');
            $password = input('post.password');

            $userInfo = User::get(['name' => $username]);

            if (is_null($userInfo)) {
                $username = '';
                $errorMsg = '用户不存在！';
            }

            if(!$this->verifyPassword($username, $password)) {
                $errorMsg = '密码错误，请重新输入！';
            }

            //登录成功记录session和cookie并跳转至主页
            $this->setCookieAndSession($userInfo);

            $this->redirect('index/index');
        }

        $this->assign('error', $errorMsg);
        $this->assign('username', $username);
        return $this->fetch();
    }

    /**
     * 登录密码校验
     * @param $username 用户名
     * @param $password 待校验密码
     * @return bool
     */
    public function verifyPassword($username, $password)
    {
        $userInfo = User::get(['name' => $username]);
        // 校验密码
        $password = $password . $userInfo['salt'];
        $hash = $userInfo['password'];
        if (!password_verify($password, $hash)) {
            return false;
        }

        return true;
    }

    /**
     * 登录成功后设置cookie、session
     * @param $accountInfo
     */
    public function setCookieAndSession($userInfo)
    {
        session('adm_uid', $userInfo['id']);
        session('adm_username', $userInfo['name']);
        cookie('adm_uid', $userInfo['id'], 3600 * 24 * 1);
    }

    protected $needLogin = false;
}