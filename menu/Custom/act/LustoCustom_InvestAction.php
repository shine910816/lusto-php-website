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
//Utility::testVariable($result);
        return VIEW_NONE;
    }
}
?>