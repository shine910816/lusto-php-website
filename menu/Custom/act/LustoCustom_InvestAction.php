<?php

/**
 * 会员管理画面
 * @author Kinsama
 * @version 2020-01-02
 */
class LustoCustom_InvestAction extends ActionBase
{
    /**
     * 执行主程序
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     */
    public function doMainExecute(Controller $controller, User $user, Request $request)
    {
        if ($request->hasParameter("get_data")) {
            $result = $this->_doDataExecute($controller, $user, $request);
            echo json_encode($result);
            $ret = VIEW_NONE;
        } elseif ($request->hasParameter("do_invest")) {
            $ret = $this->_doInvestExecute($controller, $user, $request);
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
        return VIEW_DONE;
    }

    private function _doDefaultExecute(Controller $controller, User $user, Request $request)
    {
        return VIEW_DONE;
    }

    private function _doDataExecute(Controller $controller, User $user, Request $request)
    {
        $result = array(
            "error" => "0",
            "err_msg" => "",
            "result" =>array()
        );
        $card_id = "0";
        if ($request->hasParameter("get_data")) {
            $card_id = $request->getParameter("get_data");
        }
        $search_result = LustoCustomInfoDBI::searchCustom($card_id);
        if ($controller->isError($search_result)) {
            $search_result->setPos(__FILE__, __LINE__);
            $result["error"] = "1";
            $result["err_msg"] = "数据库异常";
            return $result;
        }
        if (count($search_result) != 1) {
            $result["error"] = "1";
            $result["err_msg"] = "数据库异常";
            return $result;
        }
        $custom_id_list = array_keys($search_result);
        $custom_id = $custom_id_list[0];
        $custom_info = $search_result[$custom_id];
        $result["result"]["custom_id"] = $custom_id;
        $result["result"]["card_type"] = $custom_info["card_usable_infinity_flg"] ? "年卡" : "次卡";
        $result["result"]["custom_name"] = $custom_info["custom_name"];
        $result["result"]["custom_mobile"] = $custom_info["custom_mobile"];
        $custom_plate = "";
        if ($custom_info["custom_plate"]) {
            $region_list = LustoCustomEntity::getPlateRegionList();
            $custom_plate = $region_list[$custom_info["custom_plate_region"]] . $custom_info["custom_plate"];
        }
        $result["result"]["custom_plate"] = $custom_plate;
        $vehicle_list = LustoCustomEntity::getVehicleTypeList();
        $result["result"]["custom_vehicle_type"] = $vehicle_list[$custom_info["custom_vehicle_type"]];
        $package_list = array();
        $usable_package_list = LustoPackageInfoDBI::selectUsablePackageList();
        if ($controller->isError($usable_package_list)) {
            $usable_package_list->setPos(__FILE__, __LINE__);
            $result["error"] = "1";
            $result["err_msg"] = "数据库异常";
        }
        foreach ($usable_package_list[$custom_info["custom_vehicle_type"]] as $package_id => $package_item) {
            if ($custom_info["card_usable_infinity_flg"]) {
                if ($package_item["p_infinity_flg"]) {
                    $package_name = sprintf("%d", $package_item["p_price"]) . "元/无限次";
                    if ($package_item["p_special_flg"]) {
                        $package_name .= "(优惠活动)";
                    }
                    $package_list[$package_id] = $package_name;
                }
            } else {
                if (!$package_item["p_infinity_flg"]) {
                    $package_name = sprintf("%d", $package_item["p_price"]) . "元/";
                    $package_name .= $package_item["p_times"] . "次";
                    $package_list[$package_id] = $package_name;
                }
            }
        }
        $result["result"]["list"] = $package_list;
        return $result;
    }

    private function _doInvestExecute(Controller $controller, User $user, Request $request)
    {
        if (!$request->hasParameter("custom_id")) {
            $err = $controller->raiseError();
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        if (!$request->hasParameter("package_id")) {
            $err = $controller->raiseError();
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        $custom_id = $request->getParameter("custom_id");
        $package_id = $request->getParameter("package_id");
        $custom_info = LustoCustomInfoDBI::selectCustom($custom_id);
        if ($controller->isError($custom_info)) {
            $custom_info->setPos(__FILE__, __LINE__);
            return $custom_info;
        }
        if (!isset($custom_info[$custom_id])) {
            $err = $controller->raiseError();
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        $custom_info = $custom_info[$custom_id];
        $package_info = LustoPackageInfoDBI::selectPackage($package_id);
        if ($controller->isError($package_info)) {
            $package_info->setPos(__FILE__, __LINE__);
            return $package_info;
        }
        if (!isset($package_info[$package_id])) {
            $err = $controller->raiseError();
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        $package_info = $package_info[$package_id];
        if ($package_info["p_infinity_flg"] != $custom_info["card_usable_infinity_flg"] ||
            ($package_info["p_vehicle_type"] && $package_info["p_vehicle_type"] != $custom_info["custom_vehicle_type"])) {
            $err = $controller->raiseError();
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        $card_count = LustoCustomPackageInfoDBI::selectCardCount($custom_id);
        if ($controller->isError($card_count)) {
            $card_count->setPos(__FILE__, __LINE__);
            return $card_count;
        }
        if ($card_count === false) {
            $err = $controller->raiseError();
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        $insert_data = array();
        $insert_data["custom_id"] = $custom_id;
        $insert_data["card_order_id"] = $card_count + 1;
        $insert_data["card_package"] = $package_id;
        $insert_data["card_price"] = $package_info["p_price"];
        $insert_data["card_usable_infinity_flg"] = $package_info["p_infinity_flg"];
        $insert_data["card_usable_count"] = $package_info["p_times"];
        $insert_data["card_current_count"] = $package_info["p_times"];
        if ($package_info["p_infinity_flg"]) {
            $insert_data["card_expire"] = date("Y-m-d H:i:s", mktime(0, 0, -1, date("m"), date("d"), date("Y") + 1));
        } else {
            $insert_data["card_expire"] = "0000-00-00 00:00:00";
        }
        $insert_data["card_predict_amount"] = $package_info["p_predict_price"];
        $insert_data["operator_id"] = $user->getCustomId();
        $insert_data["create_y"] = date("Y");
        $insert_data["create_m"] = date("Ym");
        $insert_data["create_w"] = Utility::getDateWeek(date("Y-m-d H:i:s"));
        $insert_data["create_d"] = date("Ymd");
        $insert_res = LustoCustomPackageInfoDBI::insertCustomPackage($insert_data);
        if ($controller->isError($insert_res)) {
            $insert_res->setPos(__FILE__, __LINE__);
            return $insert_res;
        }
        $controller->redirect("?menu=custom&act=detail&custom_id=" . $custom_id);
        return VIEW_NONE;
    }
}
?>