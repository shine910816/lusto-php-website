<?php
require_once SRC_PATH . "/menu/Statistics/lib/LustoStatisticsBaseAction.php";

/**
 * 月度账目
 * @author Kinsama
 * @version 2020-01-16
 */
class LustoStatistics_YearlyReportAction extends LustoStatisticsBaseAction
{
    protected $_stat_interval = "3";

    /**
     * 执行主程序
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     */
    public function doMainExecute(Controller $controller, User $user, Request $request)
    {
        $this->_doSelfValidate($controller, $user, $request);
        if ($request->hasParameter("week")) {
            $ret = $this->_doWeeklyExecute($controller, $user, $request);
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

    private function _doSelfValidate(Controller $controller, User $user, Request $request)
    {
        $week_interval_flg = false;
        if ($request->hasParameter("week")) {
            $week_interval_flg = true;
        }
        $current_param = $request->getAttribute("current_param");
        $current_param_context = $current_param . "年";
        $date_list = array();
        if ($week_interval_flg) {
            $weekly_day_list = $request->getAttribute("weekly_day_list");
            foreach ($weekly_day_list as $week_num => $week_array) {
                if (substr($week_num, 0, 4) == $current_param) {
                    $date_text = "第" . sprintf("%d", substr($week_num, 4, 2)) . "周";
                    $date_list[$week_num] = $date_text;
                }
            }
        } else {
            for ($i = 1; $i <= 12; $i++) {
                $date_key = $current_param . sprintf("%02d", $i);
                $date_list[$date_key] = $i . "月";
            }
        }
        $request->setAttribute("week_interval_flg", $week_interval_flg);
        $request->setAttribute("current_param_context", $current_param_context);
        $request->setAttribute("date_list", $date_list);
        return VIEW_DONE;
    }

    private function _doDefaultExecute(Controller $controller, User $user, Request $request)
    {
        $current_param = $request->getAttribute("current_param");
        $date_list = $request->getAttribute("date_list");
        $amount_info = LustoStatisticsDBI::selectAmountByYear($current_param);
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
        $sales_info = LustoStatisticsDBI::selectSalesByYear($current_param);
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
        $chart_info = $this->_getChartData($date_list, $amount_list, $times_list, $predict_list);
        $request->setAttribute("amount_list", $amount_list);
        $request->setAttribute("times_list", $times_list);
        $request->setAttribute("predict_list", $predict_list);
        $request->setAttribute("chart_info", $chart_info);
        return VIEW_DONE;
    }

    private function _doWeeklyExecute(Controller $controller, User $user, Request $request)
    {
        $current_param = $request->getAttribute("current_param");
        $date_list = $request->getAttribute("date_list");
        $from_day = date("Ymd", mktime(0, 0, 0, 1, -6, $current_param));
        $to_day = date("Ymd", mktime(0, 0, 0, 12, 38, $current_param));
        $amount_info = LustoStatisticsDBI::selectAmountByInterval($from_day, $to_day, true);
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
        $sales_info = LustoStatisticsDBI::selectSalesByInterval($from_day, $to_day, true);
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
        $chart_info = $this->_getChartData($date_list, $amount_list, $times_list, $predict_list);
        $request->setAttribute("amount_list", $amount_list);
        $request->setAttribute("times_list", $times_list);
        $request->setAttribute("predict_list", $predict_list);
        $request->setAttribute("chart_info", $chart_info);
        return VIEW_DONE;
    }
}
?>