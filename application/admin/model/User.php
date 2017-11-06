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

    public static function isLogined()
    {
        $c_uid = cookie('adm_uid');
        $s_uid = session('adm_uid');
        $s_name = session('adm_username');

        return !is_null($c_uid) && !is_null($s_uid) && !is_null($s_name);
    }
}