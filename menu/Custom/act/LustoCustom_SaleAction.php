<?php

/**
 * 会员管理画面
 * @author Kinsama
 * @version 2020-01-14
 */
class LustoCustom_SaleAction extends ActionBase
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
        } elseif ($request->hasParameter("do_sale")) {
            $ret = $this->_doSaleExecute($controller, $user, $request);
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
        $card_infinity_flg = $custom_info["card_usable_infinity_flg"];
        $surplus_column_name = "";
        $surplus_text = "";
        $usable_flg = "0";
        if ($custom_info["card_usable_infinity_flg"]) {
            $surplus_column_name = "有效期限";
            $card_expire = LustoCustomPackageInfoDBI::selectCurrentYearCardExpire($custom_id);
            if ($controller->isError($card_expire)) {
                $result["error"] = "1";
                $result["err_msg"] = "数据库异常";
                return $result;
            }
            if ($card_expire === false) {
                $result["error"] = "1";
                $result["err_msg"] = "数据库异常";
                return $result;
            }
            $card_expire_ts = strtotime($card_expire);
            if ($card_expire_ts > time()) {
                $usable_flg = "1";
            }
            $surplus_text = date("Y", $card_expire_ts) . "年" . date("n", $card_expire_ts) . "月" . date("j", $card_expire_ts) . "日";
        } else {
            $surplus_column_name = "剩余次数";
            $card_times = LustoCustomPackageInfoDBI::selectTimesCardTotal($custom_id);
            if ($controller->isError($card_times)) {
                $result["error"] = "1";
                $result["err_msg"] = "数据库异常";
                return $result;
            }
            if ($card_times === false) {
                $result["error"] = "1";
                $result["err_msg"] = "数据库异常";
                return $result;
            }
            if ($card_times > 0) {
                $usable_flg = "1";
            }
            $surplus_text = $card_times . "次";
        }
        $result["result"]["surplus_key"] = $surplus_column_name;
        $result["result"]["surplus_value"] = $surplus_text;
        $result["result"]["card_usable"] = $usable_flg;
        return $result;
    }

    private function _doSaleExecute(Controller $controller, User $user, Request $request)
    {
        if (!$request->hasParameter("custom_id")) {
            $err = $controller->raiseError();
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        $custom_id = $request->getParameter("custom_id");
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
        $usable_flg = false;
        if ($custom_info["card_usable_infinity_flg"]) {
            $card_expire = LustoCustomPackageInfoDBI::selectCurrentYearCardExpire($custom_id);
            if ($controller->isError($card_expire)) {
                $card_expire->setPos(__FILE__, __LINE__);
                return $card_expire;
            }
            if ($card_expire === false) {
                $err = $controller->raiseError();
                $err->setPos(__FILE__, __LINE__);
                return $err;
            }
            $card_expire_ts = strtotime($card_expire);
            if ($card_expire_ts > time()) {
                $usable_flg = true;
            }
        } else {
            $card_times = LustoCustomPackageInfoDBI::selectTimesCardTotal($custom_id);
            if ($controller->isError($card_times)) {
                $card_times->setPos(__FILE__, __LINE__);
                return $card_times;
            }
            if ($card_times === false) {
                $err = $controller->raiseError();
                $err->setPos(__FILE__, __LINE__);
                return $err;
            }
            if ($card_times > 0) {
                $usable_flg = true;
            }
        }
        if (!$usable_flg) {
            $err = $controller->raiseError();
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        $insert_data = array(
            "custom_id" => $custom_id,
            "card_usable_infinity_flg" => $custom_info["card_usable_infinity_flg"],
            "operator_id" => $user->getCustomId(),
            "create_y" => date("Y"),
            "create_m" => date("Ym"),
            "create_w" => Utility::getDateWeek(date("Y-m-d H:i:s")),
            "create_d" => date("Ymd")
        );
        $update_data = array();
        $update_card_order_id = "0";
        if (!$custom_info["card_usable_infinity_flg"]) {
            $card_package_list = LustoCustomPackageInfoDBI::selectCardPackage($custom_id);
            if ($controller->isError($card_package_list)) {
                $dbi->rollback();
                $card_package_list->setPos(__FILE__, __LINE__);
                return $card_package_list;
            }
            foreach ($card_package_list as $card_order_id => $card_info) {
                if ($card_info["card_current_count"] > 0) {
                    $update_data["card_current_count"] = $card_info["card_current_count"] - 1;
                    $update_card_order_id = $card_order_id;
                    $insert_data["card_predict_amount"] = $card_info["card_predict_amount"];
                    break;
                } else {
                    continue;
                }
            }
        } else {
            $insert_data["card_predict_amount"] = "0";
        }
        $dbi = Database::getInstance();
        $begin_res = $dbi->begin();
        if ($controller->isError($begin_res)) {
            $dbi->rollback();
            $begin_res->setPos(__FILE__, __LINE__);
            return $begin_res;
        }
        if (!empty($update_data)) {
            $update_res = LustoCustomPackageInfoDBI::updateCustomPackage($update_data, $custom_id, $update_card_order_id);
            if ($controller->isError($update_res)) {
                $dbi->rollback();
                $update_res->setPos(__FILE__, __LINE__);
                return $update_res;
            }
        }
        $insert_res = LustoCustomSaleHistoryDBI::insertCustomSaleHistory($insert_data);
        if ($controller->isError($insert_res)) {
            $dbi->rollback();
            $insert_res->setPos(__FILE__, __LINE__);
            return $insert_res;
        }
        $commit_res = $dbi->commit();
        if ($controller->isError($commit_res)) {
            $dbi->rollback();
            $commit_res->setPos(__FILE__, __LINE__);
            return $commit_res;
        }
        $controller->redirect("?menu=custom&act=detail&custom_id=" . $custom_id);
        return VIEW_NONE;
    }
}
?>