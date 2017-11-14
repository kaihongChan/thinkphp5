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
        if ($this->request->isPost()) {
            //前端参数传入
            $aoData = json_decode($_POST['aoData'], TRUE);
            foreach ($aoData as $key => $value) {
                $pkey = $key;
                $pval = $value;
                $param[$pkey] = $pval;
            }

            $pageStart = !empty($param['iDisplayStart']) ? $param['iDisplayStart'] : 0;   //default pageStart
            $pageSize = !empty($param['iDisplayLength']) ? $param['iDisplayLength'] : 10; //default pageSize
            $searchKey = $param['sSearch'];

            //检索条件
            $sqlWhere = [];
            empty($searchKey) ? $sqlWhere : $sqlWhere['name | display_name'] = ['like', "%$searchKey%"];

            $userList = User::all(function($query) use($sqlWhere, $pageStart, $pageSize){
                $query->where($sqlWhere)->limit($pageStart, $pageSize)->order('id', 'ASC');
            });
            $groupList = Group::all(['status' => 1]);

            $groupData = [];
            foreach ($groupList as $key => $group) {
                $groupData[$group['id']] = $group['name'];
            }

            foreach ($userList as $key => $user) {
                $user['status'] = ['<span class="label label-warning">禁用</span>', '<span class="label label-success">启用</span>'][$user['status']];
                $user['belong_to'] = '';
                $user_group = empty($user['group_list']) ? [] : json_decode($user['group_list'], true);
                foreach ($user_group as $value){
                    if(key_exists($value, $groupData)) {
                        $user['belong_to'] .= '<span class="label label-info">'.$groupData[$value].'</span>'. '&nbsp;';
                    }
                }
                $userList[$key] = $user;
            }
            $userCount = User::where($sqlWhere)->count();
            return json([
                'iTotalDisplayRecords' => !empty($userCount) ? $userCount : 0,
                'iTotalRecords' => $pageSize,
                'aaData' => $userList,
            ]);
        }
        return view();
    }

    /**
     * 添加用户
     */
    public function addUserAction()
    {
        if ($this->request->isPost()) {
            // 1. 生成密码
            $password = input('post.password');
            $passwordAndSalt = User::makePasswordAndSalt($password);
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
                'status' => intval(input('post.status')),
                'group_list' => is_array($group_ids) ? json_encode($group_ids, JSON_UNESCAPED_UNICODE): '',
            ];
            $userModel = User::create($data);

            if ($userModel->result) {
                $this->success('成功添加用户！');
            } else {
                $this->error('添加用户失败，请重试！');
            }
            exit;
        }

        $groupList = Group::all(['status' => 1]);
        $this->assign([
           'groupList' => $groupList,
           'isAdd' => true,
        ]);
        return view('user:addUser');
    }

    /**
     * 验证用户是否存在
     */
    public function checkUserAction()
    {
        $username = trim(input('post.username'));
        $uid = intval(input('post.uid'));

        $newInfo = User::get(['name' => $username]);
        $oldInfo = User::get(['id' => $uid]);

        if (!is_null($newInfo) && $oldInfo['id'] != $newInfo['id']) {
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
            //更新数据
            $uid = intval(input('post.uid'));
            $group_ids = isset($_POST['group']) ? $_POST['group'] : [];
            $data = [
                'name' => input('post.username'),
                'display_name' => input('post.display_name'),
                'remarks' => input('post.remarks'),
                'update_time' => time(),
                'status' => intval(input('post.status')),
                'group_list' => is_array($group_ids) ? json_encode($group_ids, JSON_UNESCAPED_UNICODE): '',
            ];
            // 生成密码
            $password = input('post.password');
            if (!empty($password)) {
                $passwordAndSalt = User::makePasswordAndSalt($password);
                $data['password'] = $passwordAndSalt['password'];
                $data['salt'] = $passwordAndSalt['salt'];
            }

            $userModel = User::update($data, ['id' => $uid]);
            if ($userModel->result) {
                $this->success('成功更新用户！');
            } else {
                $this->error('更新用户失败，请重试！');
            }
            exit;
        }

        $groupList = Group::all(['status' => 1]);
        $checkedGroupList = empty($userInfo['group_list']) ? [] : json_decode($userInfo['group_list'], true);

        $this->assign([
            'isAdd' => false,
            'groupList' => $groupList,
            'checkedGroupList' => $checkedGroupList,
            'userInfo' => $userInfo
        ]);
        return view('user:addUser');
    }

    /**
     * 删除用户
     */
    public function deleteUserAction()
    {
        $id = input('post.uid');

        if ($id == 1) {
            $this->error('超级管理员不可删除！');
        }
        $result = User::destroy(['id' => $id]);

        if($result){
            $this->success('成功删除用户！');
        }

        $this->error('删除用户失败，请重试！');
    }

}