<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
if (!function_exists('random_string')) {
    /**
     * 生成随机字符串
     * @param int $length
     * @param string $collection
     * @return string
     */
    function random_string($length = 7, $collection = 'ABCDEFGHIJKLMNPQRSTUVWXYZ23456789abcdefghijkmnpqrstuvwxyz')
    {
        $result = '';
        $min = 0;
        $max = strlen($collection) - 1;

        for ($i = 0; $i < $length; ++$i) {
            $result .= $collection[mt_rand($min, $max)];
        }

        return $result;
    }
}

if (!function_exists('get_client_ip')) {
    /**
     * 获取客户端IP
     */
    function get_client_ip()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $cip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER["HTTP_X_FORWARDED_FOR"])) {
            $cip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        } elseif (!empty($_SERVER["REMOTE_ADDR"])) {
            $cip = $_SERVER["REMOTE_ADDR"];
        } else {
            $cip = "";
        }

        return is_ip($cip) ? $cip : '';
    }
}

if (!function_exists('is_ip')) {
    /**
     * 是否IP地址
     * @param string $ip
     * @return  boolean
     */
    function is_ip($ip) {
        $filtered_data = filter_var($ip, FILTER_VALIDATE_IP);
        return $filtered_data !== false && $filtered_data == $ip;
    }
}