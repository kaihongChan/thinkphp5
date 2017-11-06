<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2017/11/06
 * Time: 22:41
 */
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