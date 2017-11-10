<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 17-11-6
 * Time: 上午1:32
 */

namespace app\admin\model;



class User extends Base
{
    protected $table = 'thinkphp_user';

    /**
     * 判断用户是否登录
     * @return bool
     */
    public static function isLogined()
    {
        $c_uid = cookie('adm_uid');
        $s_uid = session('adm_uid');
        $s_name = session('adm_username');

        return !is_null($c_uid) && !is_null($s_uid) && !is_null($s_name);
    }

    /**
     * 生成盐值和密码
     * @param $password
     * @return array
     */
    public static function makePasswordAndSalt($password)
    {
        $salt = null;
        $salt = is_null($salt) ? random_string(5) : $salt;
        $password = $password . $salt;
        $password = password_hash($password, PASSWORD_DEFAULT, ['cost' => 10]);
        return [
            'salt' => $salt,
            'password' => $password
        ];
    }

    /**
     * @param $username
     * @param $password
     * @param string $error 错误信息
     * @return bool
     */
    public static function userLogin($username, $password, &$error = '')
    {
        $userInfo = self::get(['name' => $username]);

        if (is_null($userInfo)) {
            $error = '用户不存在！';
            return false;
        }

        if ($userInfo['status'] == 0) {
            $error = '用户已被禁用！';
            return false;
        }

        // 校验密码
        $password = $password . $userInfo['salt'];
        $hash = $userInfo['password'];
        if(!password_verify($password, $hash)) {
            $error = '密码错误，请重新输入！';
            return false;
        }

        //更新用户最后登录时间、ip
        $update_data = [
            'last_login_time' => time(),
            'last_login_ip' => get_client_ip(),
        ];
        self::update($update_data, ['name' => $username]);
        self::setCookieAndSession($userInfo);
        return true;
    }

    /**
     * 登录成功后设置cookie、session
     * @param $userInfo
     */
    private static function setCookieAndSession($userInfo)
    {
        $userGroup = json_decode($userInfo['group_list'], true);
        //用户所有用户组
        $userGroups = Group::all([ 'id' => ['IN', $userGroup], 'status' => 1]);
        $tempArr = [];
        $groupNameStr = '';
        foreach ($userGroups as $key => $uGroup) {
            $tempArr = array_merge($tempArr, json_decode($uGroup['powers'], true));//合并用户组权限
            $groupNameStr .= $uGroup['name'].',';
        }
        $userPowerIds = array_unique($tempArr);
        //获取用户组权限
        $functionList = Functions::all(['id' => ['IN', $userPowerIds], 'status' => 1]);
        $powerFuncMca = [];
        $powerFuncList = [];
        foreach ($functionList as $fkey => $function) {
            $powerFuncMca[$function['id']] = strtolower(sprintf('/%s/%s/%s',
                $function['module'], $function['controller'], $function['action']));

            $powerFuncList[$function['id']] = strtolower(sprintf('%s:%s:%s',
                $function['module'], $function['controller'], $function['action']));
        }
        //获取菜单项
        $allMenuList = Menu::all(['status' => 1]);
        $powerMenuList = [];
        //过滤掉没有权限的菜单项
        foreach ($allMenuList as $mkey => $allMenu) {
            if ($allMenu['function'] == '#' && $allMenu['pid'] == 0) {
                $allMenu['mca'] = '#';
            } elseif (in_array($allMenu['function'], array_keys($powerFuncMca))) {
                $allMenu['mca'] = $powerFuncMca[$allMenu['function']];
            } else {
                continue;
            }
            $powerMenuList[$allMenu['id']] = $allMenu->toArray();
        }
        //设置会话
        session('adm_power_menu', $powerMenuList);
        session('adm_power_func', $powerFuncList);
        session('adm_uid', $userInfo['id']);
        session('adm_username', $userInfo['name']);
        session('adm_group', substr($groupNameStr, 0, -1));
        cookie('adm_uid', $userInfo['id'], 3600 * 24 * 1);
    }

    /**
     * 获取用户有权限的功能列表（session）
     * @return mixed
     */
    private static function getPowerFunctions()
    {
        return session('adm_power_func');
    }

    /**
     * @param $mca module:controller:action
     * @return bool
     */
    public static function hasPowerFunc($mca)
    {
        $powerFuncs = self::getPowerFunctions();

        return in_array($mca, $powerFuncs);
    }

    /**
     * 获取权限菜单
     */
    public static function getPowerMenuList()
    {
        return session('adm_power_menu');
    }


}