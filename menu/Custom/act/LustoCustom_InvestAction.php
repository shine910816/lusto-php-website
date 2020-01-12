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
        return VIEW_NONE;
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
            return $search_result;
        }
        return VIEW_NONE;
    }

    private function _doInvestExecute(Controller $controller, User $user, Request $request)
    {
        return VIEW_NONE;
    }
}
?>