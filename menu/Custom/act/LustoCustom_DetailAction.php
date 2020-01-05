<?php
require_once SRC_PATH . "/menu/Custom/lib/LustoCustomValidate.php";

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
        $edit_mode = false;
        $custom_id = "0";
        if ($request->hasParameter("edit")) {
            $edit_mode = true;
            $custom_id = $request->getParameter("edit");
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
        $package_info = array();
        if ($edit_mode) {
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
            if ($custom_card_info["card_package"]) {
                $package_info = LustoPackageInfoDBI::selectPackage($custom_card_info["card_package"]);
                if ($controller->isError($package_info)) {
                    $package_info->setPos(__FILE__, __LINE__);
                    return $package_info;
                }
                if (!isset($package_info[$custom_card_info["card_package"]])) {
                    $err = $controller->raiseError();
                    $err->setPos(__FILE__, __LINE__);
                    return $err;
                }
                $package_info = $package_info[$custom_card_info["card_package"]];
            }
        } else {
            $custom_card_info["custom_name"] = "";
            $custom_card_info["card_id"] = "";
            $custom_card_info["custom_mobile"] = "";
            $custom_card_info["custom_plate_region"] = "12";
            $custom_card_info["custom_plate"] = "";
            $custom_card_info["custom_vehicle_type"] = "1";
            $custom_card_info["card_package"] = "3001";
            //$custom_card_info["card_usable_infinity_flg"] = "1";
            //$custom_card_info["card_usable_count"] = "0";
            //$custom_card_info["card_expire"] = date("Y-m-d H:i:s", mktime(0, 0, -1, date("m"), date("d"), date("Y") + 1));
            $normal_usable_package_list = LustoPackageInfoDBI::selectUsablePackageList();
            if ($controller->isError($normal_usable_package_list)) {
                $normal_usable_package_list->setPos(__FILE__, __LINE__);
                return $normal_usable_package_list;
            }
            $suv_usable_package_list = LustoPackageInfoDBI::selectUsablePackageList(LustoPackageEntity::VEHICLE_TYPE_SUV);
            if ($controller->isError($suv_usable_package_list)) {
                $suv_usable_package_list->setPos(__FILE__, __LINE__);
                return $suv_usable_package_list;
            }
            $request->setAttribute("normal_usable_package_list", $normal_usable_package_list);
            $request->setAttribute("suv_usable_package_list", $suv_usable_package_list);
            $request->setAttribute("vehicle_type_list", LustoCustomEntity::getVehicleTypeList());
            $request->setAttribute("plate_region_list", LustoCustomEntity::getPlateRegionList());
        }
        $request->setAttribute("custom_card_info", $custom_card_info);
        $request->setAttribute("package_info", $package_info);
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
        if (!LustoCustomValidate::checkCustomMobile($custom_card_info["custom_mobile"])) {
            $request->setError("custom_mobile", "手机号码有误");
        }
        // TODO 检证是否注册
        if (!Validate::checkAcceptParam($custom_card_info["custom_plate_region"], array_keys($plate_region_list))) {
            $err = $controller->raiseError();
            $err->setPos(__FILE__, __LINE__);
            return $err;
        }
        if (!LustoCustomValidate::checkPlateNumber($custom_card_info["custom_plate"])) {
            $request->setError("custom_plate", "车牌号码有误");
        }
        // TODO 检证是否注册
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
        $edit_mode = $request->getAttribute("edit_mode");
        $create_old_mode = $request->getAttribute("create_old_mode");
        if (!$edit_mode && !$create_old_mode) {
            $normal_usable_package_list = LustoPackageInfoDBI::selectUsablePackageList();
            if ($controller->isError($normal_usable_package_list)) {
                $normal_usable_package_list->setPos(__FILE__, __LINE__);
                return $normal_usable_package_list;
            }
            $suv_usable_package_list = LustoPackageInfoDBI::selectUsablePackageList(LustoPackageEntity::VEHICLE_TYPE_SUV);
            if ($controller->isError($suv_usable_package_list)) {
                $suv_usable_package_list->setPos(__FILE__, __LINE__);
                return $suv_usable_package_list;
            }
            $request->setAttribute("normal_usable_package_list", $normal_usable_package_list);
            $request->setAttribute("suv_usable_package_list", $suv_usable_package_list);
        }
        return VIEW_DONE;
    }

    private function _doSubmitExecute(Controller $controller, User $user, Request $request)
    {
Utility::testVariable($request->getAttributes());
        return VIEW_DONE;
    }

    private function _doErrorExecute(Controller $controller, User $user, Request $request)
    {
        $edit_mode = $request->getAttribute("edit_mode");
        $custom_card_info = $request->getAttribute("custom_card_info");
        if ($edit_mode) {
            if ($custom_card_info["card_package"]) {
                $package_info = LustoPackageInfoDBI::selectPackage($custom_card_info["card_package"]);
                if ($controller->isError($package_info)) {
                    $package_info->setPos(__FILE__, __LINE__);
                    return $package_info;
                }
                if (!isset($package_info[$custom_card_info["card_package"]])) {
                    $err = $controller->raiseError();
                    $err->setPos(__FILE__, __LINE__);
                    return $err;
                }
                $package_info = $package_info[$custom_card_info["card_package"]];
                $request->setAttribute("package_info", $package_info);
            }
        } else {
            $normal_usable_package_list = LustoPackageInfoDBI::selectUsablePackageList();
            if ($controller->isError($normal_usable_package_list)) {
                $normal_usable_package_list->setPos(__FILE__, __LINE__);
                return $normal_usable_package_list;
            }
            $suv_usable_package_list = LustoPackageInfoDBI::selectUsablePackageList(LustoPackageEntity::VEHICLE_TYPE_SUV);
            if ($controller->isError($suv_usable_package_list)) {
                $suv_usable_package_list->setPos(__FILE__, __LINE__);
                return $suv_usable_package_list;
            }
            $request->setAttribute("normal_usable_package_list", $normal_usable_package_list);
            $request->setAttribute("suv_usable_package_list", $suv_usable_package_list);
        }
        return VIEW_DONE;
    }
}
?>