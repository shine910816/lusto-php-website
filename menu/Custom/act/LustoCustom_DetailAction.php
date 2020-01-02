<?php
	
/**
 * 会员详细画面
 * @author Kinsama
 * @version 2020-01-02
 */
class LustoCustom_DetailAction extends ActionBase
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
        $create_old_mode = false;
        if ($request->hasParameter("old")) {
            $create_old_mode = true;
        }
        $edit_mode = false;
        $custom_id = "0";
        $custom_card_info = array();
        if ($request->hasParameter("edit")) {
            $edit_mode = true;
            $custom_id = $request->getParameter("edit");
            $custom_card_info = LustoCustomInfoDBI::selectCustomCardInfo($custom_id);
            if ($controller->isError($custom_card_info)) {
                $custom_card_info->setPos(__FILE__, __LINE__);
                return $custom_card_info;
            }
            if (!isset($custom_card_info[$custom_id])) {
                $err = $controller->raiseError();
                $err->setPos(__FILE__, __LINE__);
                return $err;
            }
            $custom_card_info = $custom_card_info[$custom_id];
        } else {
            $custom_card_info["custom_name"] = "";
            $custom_card_info["card_id"] = "";
            $custom_card_info["custom_mobile"] = "";
            $custom_card_info["custom_plate_region"] = "12";
            $custom_card_info["custom_plate"] = "";
            $custom_card_info["custom_vehicle_type"] = "1";
            if ($create_old_mode) {
                $custom_card_info["card_package"] = "0";
                $custom_card_info["card_usable_infinity_flg"] = "0";
                $custom_card_info["card_usable_count"] = "0";
                $custom_card_info["card_expire"] = date("Y-m-d H:i:s");
            } else {
                $custom_card_info["card_package"] = "3001";
                $custom_card_info["card_usable_infinity_flg"] = "1";
                $custom_card_info["card_usable_count"] = "0";
                $custom_card_info["card_expire"] = date("Y-m-d H:i:s", mktime(0, 0, -1, date("m"), date("d"), date("Y") + 1));
            }
        }
        $request->setAttribute("edit_mode", $edit_mode);
        $request->setAttribute("create_old_mode", $create_old_mode);
        $request->setAttribute("custom_id", $custom_id);
        $request->setAttribute("custom_card_info", $custom_card_info);
        return VIEW_DONE;
    }

    private function _doDefaultExecute(Controller $controller, User $user, Request $request)
    {
        $request->setAttribute("vehicle_type_list", LustoCustomEntity::getVehicleTypeList());
        $request->setAttribute("plate_region_list", LustoCustomEntity::getPlateRegionList());
//Utility::testVariable($request->getAttributes());
        return VIEW_DONE;
    }

    private function _doSubmitExecute(Controller $controller, User $user, Request $request)
    {
        return VIEW_DONE;
    }

    private function _doErrorExecute(Controller $controller, User $user, Request $request)
    {
        return VIEW_DONE;
    }
}
?>