<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 17-11-6
 * Time: 上午2:39
 */

namespace app\admin\controller;


use app\admin\model\Group;
use app\admin\model\User;

class UserController extends BaseController
{
    /**
     * 用户列表页
     */
    public function indexAction()
    {
        return $this->fetch();
    }

    /**
     * 获取用户分页列表
     */
    public function getUserListAction()
    {
        //前端参数传入
        $aoData = json_decode($_POST['aoData'], TRUE);
        foreach ($aoData as $key => $value) {
            $pkey = $key;
            $pval = $value;
            $param[$pkey] = $pval;
        }

        $pageStart = !empty($param['iDisplayStart']) ? $param['iDisplayStart'] : 0;   //default pageStart
        $pageSize = !empty($param['iDisplayLength']) ? $param['iDisplayLength'] : 10; //default pageSize

        //检索条件
        $sqlWhere = [
            'status' => 1,
        ];
        $userList = User::where($sqlWhere)->limit($pageStart, $pageSize)->select();

        foreach ($userList as $key => $user) {
            $user['belong_to'] = '-';
            $userList[$key] = $user;
        }

        $userCount = User::where($sqlWhere)->count();
        echo json_encode([
            'iTotalDisplayRecords' => !empty($userCount) ? $userCount : 0,
            'iTotalRecords' => $pageSize,
            'aaData' => $userList,
        ]);
    }

    /**
     * 添加用户
     */
    public function addUserAction()
    {
        if ($this->request->isPost()) {
            var_dump($_POST);
            die;
            // 1. 生成密码
            $password = input('post.password');
            $passwordAndSalt = self::makePassword($password);
            // 2. 用户组
            $group_ids = isset($_POST['group']) ? $_POST['group'] : [];
            // 3. 构建插入数据
            $data = [
                'name' => input('post.username'),
                'display_name' => input('post.display_name'),
                'password' => $passwordAndSalt['password'],
                'salt' => $passwordAndSalt['salt'],
                'remarks' => input('post.remarks'),
                'add_time' => time(),
                'update_time' => time(),
                'status' => 1,
                'group_list' => is_array($group_ids) ? json_encode($group_ids, JSON_UNESCAPED_UNICODE): '',

            ];
            $result = User::create($data);

            if ($result) {
                $this->success('成功添加用户！');
            } else {
                $this->error('添加用户失败，请重试！');
            }
            exit;
        }
        $groupList = Group::all(['status' => 1]);
        $this->assign('groupList', $groupList);
        $this->assign('isAdd', true);
        echo $this->fetch('user:addUser');
    }

    /**
     * 验证用户是否存在
     */
    public function checkUserAction()
    {
        $username = input('post.username');

        $userInfo = User::get(['name' => $username]);

        if (!is_null($userInfo)) {
            return true;
        }

        return false;
    }

    /**
     * 编辑用户
     */
    public function editUserAction()
    {
        $uid = input('get.uid');
        $userInfo = User::get(['id' => $uid]);

        if ($this->request->isPost()) {
            var_dump($_POST);
            die;
            //更新数据
            $group_ids = isset($_POST['group']) ? $_POST['group'] : [];
            $data = [
                'name' => input('post.username'),
                'display_name' => input('post.display_name'),
                'remarks' => input('post.remarks'),
                'update_time' => time(),
                'status' => 1,
                'group_list' => is_array($group_ids) ? json_encode($group_ids, JSON_UNESCAPED_UNICODE): '',

            ];
            // 生成密码
            $password = input('post.password');
            if (!empty($password)) {
                $passwordAndSalt = self::makePassword($password);
                $data['password'] = $passwordAndSalt['password'];
                $data['salt'] = $passwordAndSalt['salt'];
            }

            $result = User::update($data, ['id' => $uid]);
            if ($result) {
                $this->success('成功更新用户！');
            } else {
                $this->error('更新用户失败，请重试！');
            }
            exit;
        }

        $groupList = Group::all(['status' => 1]);
        $checkedGroupList = empty($userInfo['group_list']) ? [] : json_decode($userInfo['group_list'], true);

        $this->assign('isAdd', false);
        $this->assign('groupList', $groupList);
        $this->assign('checkedGroupList', $checkedGroupList);
        $this->assign('userInfo', $userInfo);
        echo $this->fetch('user:addUser');
    }

    /**
     * 生成密码
     */
    public function makePassword($password)
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