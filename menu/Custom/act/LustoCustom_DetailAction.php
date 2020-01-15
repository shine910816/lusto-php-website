<?php

/**
 * 会员详细画面
 * @author Kinsama
 * @version 2020-01-07
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
        $ret = $this->_doDefaultExecute($controller, $user, $request);
        if ($controller->isError($ret)) {
            $ret->setPos(__FILE__, __LINE__);
            return $ret;
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
        if (empty($custom_info)) {
            $err = $controller->raiseError();
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        $request->setAttribute("custom_id", $custom_id);
        $request->setAttribute("custom_info", $custom_info[$custom_id]);
        $request->setAttribute("vehicle_type_list", LustoCustomEntity::getVehicleTypeList());
        $request->setAttribute("plate_region_list", LustoCustomEntity::getPlateRegionList());
        return VIEW_DONE;
    }

    private function _doDefaultExecute(Controller $controller, User $user, Request $request)
    {
        $custom_id = $request->getAttribute("custom_id");
        $custom_info = $request->getAttribute("custom_info");
        $card_infinity_flg = $custom_info["card_usable_infinity_flg"];
        $surplus_text = "";
        if ($card_infinity_flg) {
            $card_expire = LustoCustomPackageInfoDBI::selectCurrentYearCardExpire($custom_id);
            if ($controller->isError($card_expire)) {
                $card_expire->setPos(__FILE__, __LINE__);
                return $card_expire;
            }
            if ($card_expire === false) {
                $err = $controller->raiseError(ERROR_CODE_DATABASE_DISACCEPT);
                $err->setPos(__FILE__, __LINE__);
                return $err;
            }
            $card_expire_ts = strtotime($card_expire);
            $surplus_text = date("Y", $card_expire_ts) . "年" . date("n", $card_expire_ts) . "月" . date("j", $card_expire_ts) . "日";
        } else {
            $card_times = LustoCustomPackageInfoDBI::selectTimesCardTotal($custom_id);
            if ($controller->isError($card_times)) {
                $card_times->setPos(__FILE__, __LINE__);
                return $card_times;
            }
            if ($card_times === false) {
                $err = $controller->raiseError(ERROR_CODE_DATABASE_DISACCEPT);
                $err->setPos(__FILE__, __LINE__);
                return $err;
            }
            $surplus_text = $card_times . "次";
        }
        $sale_info = LustoCustomSaleHistoryDBI::selectSaleHistory($custom_id);
        if ($controller->isError($sale_info)) {
            $sale_info->setPos(__FILE__, __LINE__);
            return $sale_info;
        }
        $invest_info = LustoCustomPackageInfoDBI::selectCardPackage($custom_id, $card_infinity_flg);
        if ($controller->isError($invest_info)) {
            $invest_info->setPos(__FILE__, __LINE__);
            return $invest_info;
        }
        $change_history = LustoCustomChangeHistoryDBI::searchCustomChangeHistory($custom_id);
        if ($controller->isError($change_history)) {
            $change_history->setPos(__FILE__, __LINE__);
            return $change_history;
        }
        $admin_name_list = LustoAdminInfoDBI::selectAdminNameList();
        if ($controller->isError($admin_name_list)) {
            $admin_name_list->setPos(__FILE__, __LINE__);
            return $admin_name_list;
        }
        $request->setAttribute("surplus_text", $surplus_text);
        $request->setAttribute("sale_info", $sale_info);
        $request->setAttribute("invest_info", $invest_info);
        $request->setAttribute("change_history", $change_history);
        $request->setAttribute("admin_name_list", $admin_name_list);
        $request->setAttribute("change_type_list", LustoCustomChangeHistoryEntity::getChangeTypeList());
        return VIEW_DONE;
    }
}
?>