<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 17-11-5
 * Time: 下午9:52
 */

namespace app\admin\controller;


use app\admin\model\User;
use think\Controller;

class BaseController extends Controller
{
    CONST MODULE = 'admin';

    public function _initialize()
    {
        $isLogined = User::isLogined();
        if ($this->needLogin && !$isLogined) {
            $this->redirect('login/index');
            exit();
        }

        $adm_uid = session('adm_uid');

        if($adm_uid == 1) {
            return true;
        }

        $module = $this->request->module();
        $controller = $this->request->controller();
        $action = $this->request->action();

        $mca = sprintf('%s:%s:%s', strtolower($module), strtolower($controller), strtolower($action));
        if (!User::hasPowerFunc($mca)) {
            ?>
                <?php echo $this->fetch('public:error');?>
            <?php
            exit;
        }
    }

    protected $needLogin = true;
}