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