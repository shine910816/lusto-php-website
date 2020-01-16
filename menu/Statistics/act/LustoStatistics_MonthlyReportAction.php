<?php
require_once SRC_PATH . "/menu/Statistics/lib/LustoStatisticsBaseAction.php";

/**
 * 月度账目
 * @author Kinsama
 * @version 2020-01-16
 */
class LustoStatistics_MonthlyReportAction extends LustoStatisticsBaseAction
{
    protected $_stat_interval = "2";

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

    private function _doDefaultExecute(Controller $controller, User $user, Request $request)
    {
        $current_param = $request->getAttribute("current_param");
        $current_time = mktime(0, 0, 0, substr($current_param, 4, 2), 1, substr($current_param, 0, 4));
        $current_param_context = date("Y", $current_time) . "年" . date("n", $current_time) . "月";
        $date_list = array();
        $current_month_max_day = date("t", $current_time);
        for ($i = 1; $i <= $current_month_max_day; $i++) {
            $date_time = mktime(0, 0, 0, date("n", $current_time), $i, date("Y", $current_time));
            $day_num = date("Ymd", $date_time);
            $date_text = date("j", $date_time) . "日";
            $date_list[$day_num] = $date_text;
        }
        $amount_info = LustoStatisticsDBI::selectAmount($current_param);
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
        $sales_info = LustoStatisticsDBI::selectSales($current_param);
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
        $request->setAttribute("current_param_context", $current_param_context);
        $request->setAttribute("date_list", $date_list);
        $request->setAttribute("amount_list", $amount_list);
        $request->setAttribute("times_list", $times_list);
        $request->setAttribute("predict_list", $predict_list);
        $request->setAttribute("chart_info", $chart_info);
        return VIEW_DONE;
    }
}
?>