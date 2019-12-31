<?php

/**
 * 创建用户画面
 * @author Kinsama
 * @version 2019-12-30
 */
class LustoAdmin_AdminCreateAction extends ActionBase
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
        } elseif ($request->hasParameter("do_submit")) {
            $ret = $this->_doSubmitExecute($controller, $user, $request);
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
        $edit_mode = "0";
        if ($request->hasParameter("admin_id")) {
            $edit_mode = "1";
        }
        $admin_id = "0";
        $admin_name = "e" . sprintf("%04d", count($admin_list) + 1);
        $admin_note = "";
        if ($edit_mode) {
            $admin_id = $request->getParameter("admin_id");
            if (!isset($admin_list[$admin_id])) {
                $err = $controller->raiseError();
                $err->setPos(__FILE__, __LINE__);
                return $err;
            }
            $admin_name = $admin_list[$admin_id]["admin_name"];
            $admin_note = $admin_list[$admin_id]["admin_note"];
        }
        if ($request->hasParameter("do_submit")) {
            if (!$edit_mode) {
                $admin_name = $request->getParameter("admin_name");
                $admin_info = LustoAdminInfoDBI::getAdminInfoByAdminName($admin_name);
                if ($controller->isError($admin_info)) {
                    $admin_info->setPos(__FILE__, __LINE__);
                    return $admin_info;
                }
                if (!empty($admin_info)) {
                    $request->setError("admin_name", "重复的用户名");
                }
            }
            $admin_note = $request->getParameter("admin_note");
        }
        $request->setAttribute("admin_count", count($admin_list));
        $request->setAttribute("edit_mode", $edit_mode);
        $request->setAttribute("admin_id", $admin_id);
        $request->setAttribute("admin_name", $admin_name);
        $request->setAttribute("admin_note", $admin_note);
        return VIEW_DONE;
    }

    private function _doDefaultExecute(Controller $controller, User $user, Request $request)
    {
        return VIEW_DONE;
    }

    private function _doSubmitExecute(Controller $controller, User $user, Request $request)
    {
        $edit_mode = $request->getAttribute("edit_mode");
        if ($edit_mode) {
            $admin_id = $request->getAttribute("admin_id");
            $admin_info = array();
            $admin_info["admin_note"] = $request->getAttribute("admin_note");
            $update_res = LustoAdminInfoDBI::updateAdminInfo($admin_info, $admin_id);
            if ($controller->isError($update_res)) {
                $update_res->setPos(__FILE__, __LINE__);
                return $update_res;
            }
        } else {
            $admin_count = $request->getAttribute("admin_count");
            $admin_info = array();
            $admin_info["admin_id"] = $admin_count + 101;
            $admin_info["admin_name"] = $request->getAttribute("admin_name");
            $admin_info["admin_note"] = $request->getAttribute("admin_note");
            $salt_arr = Utility::transSalt();
            $admin_info["admin_password"] = md5($salt_arr["salt1"] . "123456" . $salt_arr["salt2"]);
            $admin_info["admin_salt"] = $salt_arr["code"];
            $admin_info["admin_auth_level"] = "1";
            $admin_info["admin_activity"] = "0";
            $insert_res = LustoAdminInfoDBI::insertAdminInfo($admin_info);
            if ($controller->isError($insert_res)) {
                $insert_res->setPos(__FILE__, __LINE__);
                return $insert_res;
            }
        }
        $controller->redirect("?menu=admin&act=admin_list");
        return VIEW_NONE;
    }

    private function _doErrorExecute(Controller $controller, User $user, Request $request)
    {
        return VIEW_DONE;
    }
}
?>