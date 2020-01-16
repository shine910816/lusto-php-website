<?php

/**
 * 账目管理
 * @author Kinsama
 * @version 2020-01-15
 */
class LustoStatistics_DailyReportAction extends ActionBase
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
        return VIEW_DONE;
    }

    private function _doDefaultExecute(Controller $controller, User $user, Request $request)
    {
        $current_time = time();
        $date_list = array();
        $today_date = date("Ymd", $current_time);
        $yesterday_time = mktime(0, 0, 0, date("n", $current_time), date("j", $current_time) - 1, date("Y", $current_time));
        $yesterday_date = date("Ymd", $yesterday_time);
        $dbyest_time = mktime(0, 0, 0, date("n", $current_time), date("j", $current_time) - 2, date("Y", $current_time));
        $dbyest_date = date("Ymd", $dbyest_time);
        $date_list[$today_date] = "今日";
        $date_list[$yesterday_date] = "昨日";
        $date_list[$dbyest_date] = "前日";
        $amount_info = LustoStatisticsDBI::selectAmountByInterval($dbyest_date, $today_date);
        if ($controller->isError($amount_info)) {
            $amount_info->setPos(__FILE__, __LINE__);
            return $amount_info;
        }
        $amount_list = array();
        foreach ($date_list as $day_num => $day_tmp) {
            $amount_value = "0";
            if (isset($amount_info[$day_num])) {
                $amount_value = $amount_info[$day_num];
            }
            $amount_list[$day_num] = $amount_value;
        }
        $sales_info = LustoStatisticsDBI::selectSalesByInterval($dbyest_date, $today_date);
        if ($controller->isError($sales_info)) {
            $sales_info->setPos(__FILE__, __LINE__);
            return $sales_info;
        }
        $times_list = array();
        $predict_list = array();
        foreach ($date_list as $day_num => $day_tmp) {
            $times_value = "0";
            $predict_value = "0";
            if (isset($sales_info[$day_num])) {
                $times_value = $sales_info[$day_num]["times"];
                $predict_value = $sales_info[$day_num]["predict"];
            }
            $times_list[$day_num] = $times_value;
            $predict_list[$day_num] = $predict_value;
        }
        $request->setAttribute("today_date", $today_date);
        $request->setAttribute("date_list", $date_list);
        $request->setAttribute("amount_list", $amount_list);
        $request->setAttribute("times_list", $times_list);
        $request->setAttribute("predict_list", $predict_list);
        return VIEW_DONE;
    }
}
?>