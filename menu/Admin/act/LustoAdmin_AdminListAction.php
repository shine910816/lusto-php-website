<?php

/**
 * 成员管理画面
 * @author Kinsama
 * @version 2019-12-30
 */
class LustoAdmin_AdminListAction extends ActionBase
{

    /**
     * 执行主程序
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     */
    public function doMainExecute(Controller $controller, User $user, Request $request)
    {
        if ($request->hasParameter("do_reset")) {
            $ret = $this->_doResetExecute($controller, $user, $request);
            if ($controller->isError($ret)) {
                $ret->setPos(__FILE__, __LINE__);
                return $ret;
            }
        } elseif ($request->hasParameter("do_activity")) {
            $ret = $this->_doActivityExecute($controller, $user, $request);
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
        $admin_list = LustoAdminInfoDBI::getNormalAdminInfo();
        if ($controller->isError($admin_list)) {
            $admin_list->setPos(__FILE__, __LINE__);
            return $admin_list;
        }
        $request->setAttribute("admin_list", $admin_list);
        return VIEW_DONE;
    }

    private function _doDefaultExecute(Controller $controller, User $user, Request $request)
    {
        return VIEW_DONE;
    }

    private function _doActivityExecute(Controller $controller, User $user, Request $request)
    {
        $target_admin_id = $request->getParameter("do_activity");
        $admin_list = $request->getAttribute("admin_list");
        if (!isset($admin_list[$target_admin_id])) {
            $err = $controller->raiseError();
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        $update_data = array();
        if ($admin_list[$target_admin_id]["admin_activity"]) {
            $update_data["admin_activity"] = "0";
        } else {
            $update_data["admin_activity"] = "1";
        }
        $update_res = LustoAdminInfoDBI::updateAdminInfo($update_data, $target_admin_id);
        if ($controller->isError($update_res)) {
            $update_res->setPos(__FILE__, __LINE__);
            return $update_res;
        }
        $controller->redirect("?menu=admin&act=admin_list");
        return VIEW_NONE;
    }

    private function _doResetExecute(Controller $controller, User $user, Request $request)
    {
        $target_admin_id = $request->getParameter("do_reset");
        $admin_list = $request->getAttribute("admin_list");
        if (!isset($admin_list[$target_admin_id])) {
            $err = $controller->raiseError();
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        $update_data = array();
        $salt_arr = Utility::transSalt();
        $update_data["admin_password"] = md5($salt_arr["salt1"] . "123456" . $salt_arr["salt2"]);
        $update_data["admin_salt"] = $salt_arr["code"];
        $update_res = LustoAdminInfoDBI::updateAdminInfo($update_data, $target_admin_id);
        if ($controller->isError($update_res)) {
            $update_res->setPos(__FILE__, __LINE__);
            return $update_res;
        }
        $controller->redirect("?menu=admin&act=admin_list");
        return VIEW_NONE;
    }
}
?>