<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 17-11-5
 * Time: 下午9:39
 */

return [
    // 扩展函数文件
    'extra_file_list' => [
        THINK_PATH . 'helper' . EXT,
        APP_PATH . 'admin' . DS .'common'. DS . 'functions' . EXT,
    ],
    // 视图输出字符串内容替换
    'view_replace_str' => [
        '__static__'=> dirname($_SERVER['SCRIPT_NAME']). 'static/admin',
    ],
];
