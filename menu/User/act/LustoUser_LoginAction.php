<?php

/**
 * 用户登录登出画面
 * @author Kinsama
 * @version 2019-12-30
 */
class LustoUser_LoginAction extends ActionBase
{

    /**
     * 执行主程序
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     */
    public function doMainExecute(Controller $controller, User $user, Request $request)
    {
        if ($request->hasParameter('do_logout')) {
            $ret = $this->_doLogoutExecute($controller, $user, $request);
            if ($controller->isError($ret)) {
                $ret->setPos(__FILE__, __LINE__);
                return $ret;
            }
        } elseif ($request->isError()) {
            $ret = $this->_doErrorExecute($controller, $user, $request);
            if ($controller->isError($ret)) {
                $ret->setPos(__FILE__, __LINE__);
                return $ret;
            }
        } elseif ($request->hasParameter('do_login')) {
            $ret = $this->_doLoginExecute($controller, $user, $request);
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
        $admin_id = "0";
        $admin_name = "";
        if ($request->hasParameter("do_login")) {
            $admin_name = $request->getParameter("login_name");
            $login_password = $request->getParameter("login_password");
            $login_info = LustoAdminInfoDBI::getAdminInfoByAdminName($admin_name);
            if ($controller->isError($login_info)) {
                $login_info->setPos(__FILE__, __LINE__);
                return $login_info;
            }
            if (empty($login_info)) {
                $request->setError("login_name", "用户名不存在");
            } else {
                $salt_arr = Utility::transSalt($login_info["admin_salt"]);
                if ($login_info["admin_password"] != md5($salt_arr["salt1"] . $login_password . $salt_arr["salt2"])) {
                    $request->setError("login_password", "密码不正确");
                } else {
                    $admin_id = $login_info["admin_id"];
                }
            }
        }
        $request->setAttribute("admin_id", $admin_id);
        $request->setAttribute("admin_name", $admin_name);
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
    private function _doLoginExecute(Controller $controller, User $user, Request $request)
    {
        $admin_id = $request->getAttribute("admin_id");
        $admin_name = $request->getAttribute("admin_name");
        $admin_lvl = "0";
        $login_info = LustoAdminInfoDBI::getAdminInfo($admin_id);
        if ($controller->isError($login_info)) {
            $login_info->setPos(__FILE__, __LINE__);
            return $login_info;
        }
        if (isset($login_info[$admin_id]) && $login_info[$admin_id]["admin_auth_level"] == "2") {
            $admin_lvl = "1";
        }
        $user->setVariable("custom_id", $admin_id);
        $user->setVariable("custom_nick", $admin_name);
        $user->setVariable("admin_lvl", $admin_lvl);
        $redirect_url = "";
        if ($user->hasVariable(REDIRECT_URL)) {
            $redirect_url = $user->getVariable(REDIRECT_URL);
        }
        $controller->redirect($redirect_url);
        return VIEW_NONE;
    }

    /**
     * 执行登出命令
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     * @access private
     */
    private function _doLogoutExecute(Controller $controller, User $user, Request $request)
    {
        if (!$user->isLogin()) {
            $controller->redirect("?menu=user&act=login");
            return VIEW_NONE;
        }
        $user->setVariable("custom_id", "0");
        $user->setVariable("custom_nick", "");
        $user->setVariable("admin_lvl", "0");
        $controller->redirect();
        return VIEW_NONE;
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