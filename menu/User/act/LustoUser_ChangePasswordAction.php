<?php

/**
 * 用户修改密码画面
 * @author Kinsama
 * @version 2019-12-30
 */
class LustoUser_ChangePasswordAction extends ActionBase
{

    /**
     * 执行主程序
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     */
    public function doMainExecute(Controller $controller, User $user, Request $request)
    {
        if ($request->isError()) {
            $ret = $this->_doErrorExecute($controller, $user, $request);
            if ($controller->isError($ret)) {
                $ret->setPos(__FILE__, __LINE__);
                return $ret;
            }
        } elseif ($request->hasParameter('do_change')) {
            $ret = $this->_doChangeExecute($controller, $user, $request);
            if ($controller->isError($ret)) {
                $ret->setPos(__FILE__, __LINE__);
                return $ret;
            }
        } else {
            $ret = $this->_doDefaultExecute($controller, $user, $request);
            if ($controller->isError($ret)) {
                $ret->setPos(__FILE__, __LINE__);
                return $ret;
            }
        }
        return $ret;
    }

    /**
     * 执行参数检测
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     */
    public function doMainValidate(Controller $controller, User $user, Request $request)
    {
        $admin_id = $user->getCustomId();
        $new_password = "";
        if ($request->hasParameter("do_change")) {
            $login_password = $request->getParameter("login_password");
            $admin_info = LustoAdminInfoDBI::getAdminInfo($admin_id);
            if ($controller->isError($admin_info)) {
                $admin_info->setPos(__FILE__, __LINE__);
                return $admin_info;
            }
            if (!isset($admin_info[$admin_id])) {
                $err = $controller->raiseError();
                $err->setPos(__FILE__, __LINE__);
                return $err;
            }
            $salt_arr = Utility::transSalt($admin_info[$admin_id]["admin_salt"]);
            if ($admin_info[$admin_id]["admin_password"] != md5($salt_arr["salt1"] . $login_password . $salt_arr["salt2"])) {
                $request->setError("old_password", "密码不正确");
            } else {
                if ($request->getParameter("new_password") != $request->getParameter("new_password_2")) {
                    $request->setError("new_password", "两次密码不一致");
                } else {
                    $new_password = $request->getParameter("new_password");
                }
            }
        }
        $request->setAttribute("admin_id", $admin_id);
        $request->setAttribute("new_password", $new_password);
        return VIEW_DONE;
    }

    /**
     * 执行默认命令
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     * @access private
     */
    private function _doDefaultExecute(Controller $controller, User $user, Request $request)
    {
        return VIEW_DONE;
    }

    /**
     * 执行登录命令
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     * @access private
     */
    private function _doChangeExecute(Controller $controller, User $user, Request $request)
    {
        $admin_id = $request->getAttribute("admin_id");
        $new_password = $request->getAttribute("new_password");
        $update_data = array();
        $salt_arr = Utility::transSalt();
        $update_data["admin_password"] = md5($salt_arr["salt1"] . $new_password . $salt_arr["salt2"]);
        $update_data["admin_salt"] = $salt_arr["code"];
        $update_res = LustoAdminInfoDBI::updateAdminInfo($update_data, $admin_id);
        if ($controller->isError($update_res)) {
            $update_res->setPos(__FILE__, __LINE__);
            return $update_res;
        }
        $controller->redirect("?menu=user&act=login&do_logout=1");
        return VIEW_DONE;
    }

    /**
     * 执行登录错误命令
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     * @access private
     */
    private function _doErrorExecute(Controller $controller, User $user, Request $request)
    {
        return VIEW_DONE;
    }
}
?>