<?php

/**
 * 会员一览
 * @author Kinsama
 * @version 2020-01-16
 */
class LustoStatistics_CustomListAction extends ActionBase
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
        $card_type_flg = false;
        if ($request->hasParameter("year_card")) {
            $card_type_flg = true;
        }
        $request->setAttribute("card_type_flg", $card_type_flg);
        return VIEW_DONE;
    }

    private function _doDefaultExecute(Controller $controller, User $user, Request $request)
    {
        $card_type_flg = $request->getAttribute("card_type_flg");
        $custom_list = LustoStatisticsDBI::selectCustomList($card_type_flg);
        if ($controller->isError($custom_list)) {
            $custom_list->setPos(__FILE__, __LINE__);
            return $custom_list;
        }
        
Utility::testVariable($custom_list);
        return VIEW_NONE;
    }
}
?>