<?php
require_once SRC_PATH . "/menu/Statistics/lib/LustoStatisticsBaseAction.php";

/**
 * 账目管理
 * @author Kinsama
 * @version 2020-01-15
 */
class LustoStatistics_WeeklyReportAction extends LustoStatisticsBaseAction
{
    protected $_stat_interval = "1";

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
        $current_param_context = substr($current_param, 0, 4) . "年 第" . sprintf("%d", substr($current_param, 4, 2)) . "周 (";
        $weekly_day_list = $request->getAttribute("weekly_day_list");
        $weekly_day_arr = $weekly_day_list[$current_param];
        $current_param_context .= sprintf("%d", substr($weekly_day_arr[0], 4, 2)) . "月";
        $current_param_context .= sprintf("%d", substr($weekly_day_arr[0], 6, 2)) . "日~";
        $current_param_context .= sprintf("%d", substr($weekly_day_arr[6], 4, 2)) . "月";
        $current_param_context .= sprintf("%d", substr($weekly_day_arr[6], 6, 2)) . "日)";
        $date_list = array();
        foreach ($weekly_day_arr as $day_num) {
            $date_time = mktime(0, 0, 0, substr($day_num, 4, 2), substr($day_num, 6, 2), substr($day_num, 0, 4));
            $date_text = date("n", $date_time) . "月" . date("j", $date_time) . "日";
            $date_list[$day_num] = $date_text;
        }
        $amount_info = LustoStatisticsDBI::selectAmountByInterval($weekly_day_arr[0], $weekly_day_arr[6]);
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
        $times_info = LustoStatisticsDBI::selectSaleTimesByInterval($weekly_day_arr[0], $weekly_day_arr[6]);
        if ($controller->isError($times_info)) {
            $times_info->setPos(__FILE__, __LINE__);
            return $times_info;
        }
        $times_list = array();
        foreach ($date_list as $day_num => $day_tmp) {
            $times_value = "0";
            if (isset($times_info[$day_num])) {
                $times_value = $times_info[$day_num];
            }
            $times_list[$day_num] = $times_value;
        }
        $predict_info = LustoStatisticsDBI::selectPredictByInterval($weekly_day_arr[0], $weekly_day_arr[6]);
        if ($controller->isError($predict_info)) {
            $predict_info->setPos(__FILE__, __LINE__);
            return $predict_info;
        }
        $predict_list = array();
        foreach ($date_list as $day_num => $day_tmp) {
            $predict_value = "0";
            if (isset($predict_info[$day_num])) {
                $predict_value = $predict_info[$day_num];
            }
            $predict_list[$day_num] = $predict_value;
        }
        $request->setAttribute("current_param_context", $current_param_context);
        $request->setAttribute("date_list", $date_list);
        $request->setAttribute("amount_list", $amount_list);
        $request->setAttribute("times_list", $times_list);
        $request->setAttribute("predict_list", $predict_list);
//Utility::testVariable($amount_list);
        return VIEW_DONE;
    }
}
?>