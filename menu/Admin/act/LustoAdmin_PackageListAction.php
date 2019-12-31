<?php

/**
 * 套餐管理画面
 * @author Kinsama
 * @version 2019-12-31
 */
class LustoAdmin_PackageListAction extends ActionBase
{

    /**
     * 执行主程序
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     */
    public function doMainExecute(Controller $controller, User $user, Request $request)
    {
        //if ($request->hasParameter("do_reset")) {
        //    $ret = $this->_doResetExecute($controller, $user, $request);
        //    if ($controller->isError($ret)) {
        //        $ret->setPos(__FILE__, __LINE__);
        //        return $ret;
        //    }
        //} elseif ($request->hasParameter("do_activity")) {
        //    $ret = $this->_doActivityExecute($controller, $user, $request);
        //    if ($controller->isError($ret)) {
        //        $ret->setPos(__FILE__, __LINE__);
        //        return $ret;
        //    }
        //} else {
            $ret = $this->_doDefaultExecute($controller, $user, $request);
            if ($controller->isError($ret)) {
                $ret->setPos(__FILE__, __LINE__);
                return $ret;
            }
        //}
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
        $special_flg = false;
        if ($request->hasParameter("special")) {
            $special_flg = true;
        }
        $package_list = LustoPackageInfoDBI::selectPackageList($special_flg);
        if ($controller->isError($package_list)) {
            $package_list->setPos(__FILE__, __LINE__);
            return $package_list;
        }
        $request->setAttribute("special_flg", $special_flg);
        $request->setAttribute("package_list", $package_list);
        return VIEW_DONE;
    }

    private function _doDefaultExecute(Controller $controller, User $user, Request $request)
    {
        $vehicle_list = LustoPackageEntity::getVehicleTypeList();
        $request->setAttribute("vehicle_list", $vehicle_list);
        return VIEW_DONE;
    }
}
?>