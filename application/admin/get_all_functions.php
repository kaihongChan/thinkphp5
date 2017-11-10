<?php
/**
 * 获取所有函数
 */
$controllers = [
    "Index",
    "Login",
    "Group",
    "Menu",
    "Function",
    "User",
];

require_once '../vendor/autoload.php';

define("FUNCTIONS_FILE", __DIR__ . "/functions.txt");
define('APP_PATH', __DIR__ . '/application/');


$fp = fopen(FUNCTIONS_FILE, "w");

foreach ($controllers as $c) {
    $name = sprintf("admin\\controller\\%sController", $c);
    $rC = new ReflectionClass($name);

    foreach ($rC->getMethods(ReflectionMethod::IS_PUBLIC) as $rM) {
        if (6 < strlen($rM->getName()) && 'action' == strtolower(substr($rM->getName(), -6))) {
            $controller = strtolower(substr($rC->getShortName(), 0, -10));
            $action = strtolower(substr($rM->getName(), 0, -6));
            $label = sprintf("%s_%s", $controller, $action);
            $category = $controller;

            $insertSql = sprintf("INSERT INTO `thinkphp_function`(`category`,`module`,`controller`,`action`) VALUES('%s', '%s', '%s', '%s');\n",
                $category, 'admin', $controller, $action);
            fwrite($fp, $insertSql);
        }
    }
}
fclose($fp);