<?php
require_once SRC_PATH . "/menu/Custom/lib/LustoCustomValidate.php";

/**
 * 会员详细画面
 * @author Kinsama
 * @version 2020-01-02
 */
class LustoCustom_InputAction extends ActionBase
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
        $edit_mode = false;
        $custom_id = "0";
        if ($request->hasParameter("edit")) {
            $edit_mode = true;
            $custom_id = $request->getParameter("edit");
        }
        if ($edit_mode) {
            $request->setAttribute("page_titles", array(
                '<a href="./?menu=custom&act=detail&custom_id=' . $custom_id . '" data-ajax="false">会员详细</a>',
                "会员信息编辑"
            ));
        } else {
            $request->setAttribute("page_titles", "会员信息录入");
            $usable_package_list = LustoPackageInfoDBI::selectUsablePackageList();
            if ($controller->isError($usable_package_list)) {
                $usable_package_list->setPos(__FILE__, __LINE__);
                return $usable_package_list;
            }
            $request->setAttribute("usable_package_list", $usable_package_list);
        }
        $request->setAttribute("edit_mode", $edit_mode);
        $request->setAttribute("custom_id", $custom_id);
        $request->setAttribute("vehicle_type_list", LustoCustomEntity::getVehicleTypeList());
        $request->setAttribute("plate_region_list", LustoCustomEntity::getPlateRegionList());
        if ($request->hasParameter("do_submit")) {
            $ret = $this->_doSubmitValidate($controller, $user, $request);
            if ($controller->isError($ret)) {
                $ret->setPos(__FILE__, __LINE__);
                return $ret;
            }
        } else {
            $ret = $this->_doDefaultValidate($controller, $user, $request);
            if ($controller->isError($ret)) {
                $ret->setPos(__FILE__, __LINE__);
                return $ret;
            }
        }
        return $ret;
    }

    private function _doDefaultValidate(Controller $controller, User $user, Request $request)
    {
        $edit_mode = $request->getAttribute("edit_mode");
        $custom_id = $request->getAttribute("custom_id");
        $custom_card_info = array();
        if ($edit_mode) {
            $custom_card_info = LustoCustomInfoDBI::selectCustom($custom_id);
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
            $custom_card_info["card_package"] = "3001";
            $usable_package_list = LustoPackageInfoDBI::selectUsablePackageList();
            if ($controller->isError($usable_package_list)) {
                $usable_package_list->setPos(__FILE__, __LINE__);
                return $usable_package_list;
            }
            $request->setAttribute("usable_package_list", $usable_package_list);
        }
        $request->setAttribute("custom_card_info", $custom_card_info);
        return VIEW_DONE;
    }

    private function _doSubmitValidate(Controller $controller, User $user, Request $request)
    {
        $edit_mode = $request->getAttribute("edit_mode");
        $vehicle_type_list = $request->getAttribute("vehicle_type_list");
        $plate_region_list = $request->getAttribute("plate_region_list");
        $custom_card_info = $request->getParameter("custom_info");
        if (!LustoCustomValidate::checkCustomName($custom_card_info["custom_name"])) {
            $request->setError("custom_name", "会员名有误");
        }
        if (!LustoCustomValidate::checkCardId($custom_card_info["card_id"])) {
            $request->setError("card_id", "会员卡号有误");
        }
        $card_id_count = LustoCustomInfoDBI::selectCardIdCount($custom_card_info["card_id"]);
        if ($controller->isError($card_id_count)) {
            $card_id_count->setPos(__FILE__, __LINE__);
            return $card_id_count;
        }
        if (!$edit_mode && $card_id_count) {
            $request->setError("card_id", "会员卡号已被绑定");
        }
        if (!LustoCustomValidate::checkCustomMobile($custom_card_info["custom_mobile"])) {
            $request->setError("custom_mobile", "手机号码有误");
        }
        if (!Validate::checkAcceptParam($custom_card_info["custom_plate_region"], array_keys($plate_region_list))) {
            $err = $controller->raiseError();
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        if (!LustoCustomValidate::checkPlateNumber($custom_card_info["custom_plate"])) {
            $request->setError("custom_plate", "车牌号码有误");
        }
        if (!Validate::checkAcceptParam($custom_card_info["custom_vehicle_type"], array_keys($vehicle_type_list))) {
            $err = $controller->raiseError();
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        if (!$edit_mode) {
            $package_info = $request->getParameter("package_info");
            $custom_card_info["card_package"] = $package_info[$custom_card_info["custom_vehicle_type"]];
        }
        $request->setAttribute("custom_card_info", $custom_card_info);
        return VIEW_DONE;
    }

    private function _doDefaultExecute(Controller $controller, User $user, Request $request)
    {
        return VIEW_DONE;
    }

    private function _doSubmitExecute(Controller $controller, User $user, Request $request)
    {
        $edit_mode = $request->getAttribute("edit_mode");
        $custom_card_info = $request->getAttribute("custom_card_info");
        $plate_region_list = $request->getAttribute("plate_region_list");
        $custom_id = "0";
        $operator_id = $user->getCustomId();
        $dbi = Database::getInstance();
//Utility::testVariable($request->getAttributes());
        if ($edit_mode) {
            $custom_id = $request->getAttribute("custom_id");
            $current_custom_info = LustoCustomInfoDBI::selectCustom($custom_id);
            if ($controller->isError($current_custom_info)) {
                $current_custom_info->setPos(__FILE__, __LINE__);
                return $current_custom_info;
            }
            if (!isset($current_custom_info[$custom_id])) {
                $err = $controller->raiseError();
                $err->setPos(__FILE__, __LINE__);
                return $err;
            }
            $current_custom_info = $current_custom_info[$custom_id];
            $custom_update = array();
            $history_insert = array();
            if ($custom_card_info["card_id"] != $current_custom_info["card_id"]) {
                $custom_update["card_id"] = $custom_card_info["card_id"];
                $history_insert[LustoCustomChangeHistoryEntity::CHANGE_TYPE_CARD_ID] = array(
                    "change_from" => $current_custom_info["card_id"],
                    "change_to" => $custom_card_info["card_id"]
                );
            }
            if ($custom_card_info["custom_mobile"] != $current_custom_info["custom_mobile"]) {
                $custom_update["custom_mobile"] = $custom_card_info["custom_mobile"];
                $history_insert[LustoCustomChangeHistoryEntity::CHANGE_TYPE_MOBILE] = array(
                    "change_from" => $current_custom_info["custom_mobile"],
                    "change_to" => $custom_card_info["custom_mobile"]
                );
            }
            if ((!$current_custom_info["custom_plate"] && $custom_card_info["custom_plate"]) ||
                ($current_custom_info["custom_plate"] && ($custom_card_info["custom_plate"] != $current_custom_info["custom_plate"] ||
                $custom_card_info["custom_plate_region"] != $current_custom_info["custom_plate_region"]))) {
                $custom_update["custom_plate_region"] = $custom_card_info["custom_plate_region"];
                $custom_update["custom_plate"] = strtoupper($custom_card_info["custom_plate"]);
                $plate_change_from = "";
                if ($current_custom_info["custom_plate"]) {
                    $plate_change_from = $plate_region_list[$current_custom_info["custom_plate_region"]] . strtoupper($current_custom_info["custom_plate"]);
                }
                $history_insert[LustoCustomChangeHistoryEntity::CHANGE_TYPE_PLATE] = array(
                    "change_from" => $plate_change_from,
                    "change_to" => $plate_region_list[$custom_card_info["custom_plate_region"]] . strtoupper($custom_card_info["custom_plate"])
                );
            }
            if ($custom_card_info["custom_name"] != $current_custom_info["custom_name"]) {
                $custom_update["custom_name"] = $custom_card_info["custom_name"];
                $history_insert[LustoCustomChangeHistoryEntity::CHANGE_TYPE_NAME] = array(
                    "change_from" => $current_custom_info["custom_name"],
                    "change_to" => $custom_card_info["custom_name"]
                );
            }
            if (!empty($custom_update)) {
                $begin_res = $dbi->begin();
                if ($controller->isError($begin_res)) {
                    $dbi->rollback();
                    $begin_res->setPos(__FILE__, __LINE__);
                    return $begin_res;
                }
                $update_res = LustoCustomInfoDBI::updateCustom($custom_update, $custom_id);
                if ($controller->isError($update_res)) {
                    $dbi->rollback();
                    $update_res->setPos(__FILE__, __LINE__);
                    return $update_res;
                }
                foreach ($history_insert as $change_type => $history_insert) {
                    $history_insert["custom_id"] = $custom_id;
                    $history_insert["change_type"] = $change_type;
                    $history_insert["operator_id"] = $operator_id;
                    $insert_res = LustoCustomChangeHistoryDBI::insertCustomPackage($history_insert);
                    if ($controller->isError($insert_res)) {
                        $dbi->rollback();
                        $insert_res->setPos(__FILE__, __LINE__);
                        return $insert_res;
                    }
                }
                $commit_res = $dbi->commit();
                if ($controller->isError($commit_res)) {
                    $dbi->rollback();
                    $commit_res->setPos(__FILE__, __LINE__);
                    return $commit_res;
                }
            }
        } else {
            $usable_package_list = $request->getAttribute("usable_package_list");
            $package_info = $usable_package_list[$custom_card_info["custom_vehicle_type"]][$custom_card_info["card_package"]];
            $custom_insert = array(
                "custom_mobile" => $custom_card_info["custom_mobile"],
                "custom_plate_region" => $custom_card_info["custom_plate_region"],
                "custom_plate" => strtoupper($custom_card_info["custom_plate"]),
                "custom_name" => $custom_card_info["custom_name"],
                "custom_vehicle_type" => $custom_card_info["custom_vehicle_type"],
                "card_id" => $custom_card_info["card_id"],
                "card_usable_infinity_flg" => $package_info["p_infinity_flg"]
            );
            $package_insert = array();
            $package_insert["card_order_id"] = "1";
            $package_insert["card_package"] = $package_info["p_id"];
            $package_insert["card_price"] = $package_info["p_price"];
            $package_insert["card_usable_infinity_flg"] = $package_info["p_infinity_flg"];
            $package_insert["operator_id"] = $operator_id;
            $package_insert["create_y"] = date("Y");
            $package_insert["create_m"] = date("Ym");
            $package_insert["create_w"] = Utility::getDateWeek(date("Y-m-d H:i:s"));
            $package_insert["create_d"] = date("Ymd");
            if ($package_info["p_infinity_flg"]) {
                $package_insert["card_usable_count"] = "0";
                $package_insert["card_current_count"] = "0";
                $package_insert["card_expire"] = date("Y-m-d H:i:s", mktime(0, 0, -1, date("m"), date("d"), date("Y") + 1));
                $package_insert["card_predict_amount"] = "0";
            } else {
                $package_insert["card_usable_count"] = $package_info["p_times"];
                $package_insert["card_current_count"] = $package_info["p_times"];
                $package_insert["card_expire"] = "0000-00-00 00:00:00";
                $package_insert["card_predict_amount"] = $package_info["p_predict_price"];
            }
            $begin_res = $dbi->begin();
            if ($controller->isError($begin_res)) {
                $dbi->rollback();
                $begin_res->setPos(__FILE__, __LINE__);
                return $begin_res;
            }
            $custom_id = LustoCustomInfoDBI::insertCustom($custom_insert);
            if ($controller->isError($custom_id)) {
                $dbi->rollback();
                $custom_id->setPos(__FILE__, __LINE__);
                return $custom_id;
            }
            $package_insert["custom_id"] = $custom_id;
            $insert_res = LustoCustomPackageInfoDBI::insertCustomPackage($package_insert);
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
        }
        $controller->redirect("?menu=custom&act=detail&custom_id=" . $custom_id);
        return VIEW_DONE;
    }

    private function _doErrorExecute(Controller $controller, User $user, Request $request)
    {
        return VIEW_DONE;
    }
}
?>