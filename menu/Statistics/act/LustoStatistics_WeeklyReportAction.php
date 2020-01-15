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
        $current_param = $request->getAttribute("current_param");
        $column_list = $this->_getDailyColumn($current_param);
Utility::testVariable($column_list);
        return VIEW_NONE;
    }

    private function _getDailyColumn($param)
    {
        $year_param = substr($param, 0, 4);
        $year_param = 2020;
        $week_param = substr($param, 4, 2);
        $days_max = 365;
        if (date("L", strtotime($year_param . "-01-01 00:00:00")) == "1") {
            $days_max = 366;
        }
        $result = array();
        for ($i = -6; $i <= $days_max + 7; $i++) {
            $current_time = mktime(0, 0, 0, 1, $i, $year_param);
            $column_key = date("oW", $current_time);
            $column_value = date("Ymd", $current_time);
            $result[$column_key][] = $column_value;
        }
        return $result;
    }
}
?>