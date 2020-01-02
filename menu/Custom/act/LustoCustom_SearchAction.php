<?php

/**
 * 会员管理画面
 * @author Kinsama
 * @version 2020-01-02
 */
class LustoCustom_SearchAction extends ActionBase
{
    /**
     * 执行主程序
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     */
    public function doMainExecute(Controller $controller, User $user, Request $request)
    {
        if ($request->hasParameter("do_search")) {
            $ret = $this->_doSearchExecute($controller, $user, $request);
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
        $search_type_opt = array("1", "2", "3");
        $search_type = "1";
        $search_keyword = "";
        $search_flg = false;
        $search_result = array();
        if ($request->hasParameter("do_search")) {
            $search_flg = true;
            $search_type = $request->getParameter("search_type");
            $search_keyword = $request->getParameter("search_keyword");
            if (!Validate::checkAcceptParam($search_type, $search_type_opt)) {
                $err = $controller->raiseError();
                $err->setPos(__FILE__, __LINE__);
                return $err;
            }
            $search_result = LustoCustomInfoDBI::searchCustom($search_keyword, $search_type);
            if ($controller->isError($search_result)) {
                $search_result->setPos(__FILE__, __LINE__);
                return $search_result;
            }
        }
        $request->setAttribute("search_type", $search_type);
        $request->setAttribute("search_keyword", $search_keyword);
        $request->setAttribute("search_flg", $search_flg);
        $request->setAttribute("search_result", $search_result);
        return VIEW_DONE;
    }

    private function _doDefaultExecute(Controller $controller, User $user, Request $request)
    {
        return VIEW_DONE;
    }

    private function _doSearchExecute(Controller $controller, User $user, Request $request)
    {
        $vehicle_list = LustoCustomEntity::getVehicleTypeList();
        $region_list = LustoCustomEntity::getPlateRegionList();
        $request->setAttribute("vehicle_list", $vehicle_list);
        $request->setAttribute("region_list", $region_list);
        return VIEW_DONE;
    }
}
?>