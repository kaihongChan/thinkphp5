<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 17-11-6
 * Time: 上午7:14
 */

namespace app\admin\model;


use think\Model;

class Base extends Model
{
    //程序模块
    const MODULE = 'admin';

    //操作结果
    public $result = null;

    /**
     * 重写Model插入方法（返回模型对象包含操作结果）
     * @param array $data
     * @param null $field
     * @return static
     */
    public static function create($data = [], $field = null)
    {
        $model = new static();
        if (!empty($field)) {
            $model->allowField($field);
        }
        $model->result = $model->isUpdate(false)->save($data, []);
        return $model;
    }

    /**
     * 重写Model更新方法（返回模型对象包含操作结果）
     * @param array $data
     * @param array $where
     * @param null $field
     * @return static
     */
    public static function update($data = [], $where = [], $field = null)
    {
        $model = new static();
        if (!empty($field)) {
            $model->allowField($field);
        }
        $model->result = $model->isUpdate(true)->save($data, $where);
        return $model;
    }
}