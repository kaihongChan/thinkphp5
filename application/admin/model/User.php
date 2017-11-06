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


}