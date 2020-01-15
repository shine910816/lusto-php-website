<?php

/**
 * 统计基础
 * @author Kinsama
 * @version 2020-01-15
 */
class LustoStatisticsBaseAction extends ActionBase
{
    protected $_stat_interval = "1";

    protected function _getIntervalList()
    {
        return array(
            "1" => "周度",
            "2" => "月度",
            "3" => "年度"
        );
    }

    /**
     * 执行参数检测
     * @param object $controller Controller对象类
     * @param object $user User对象类
     * @param object $request Request对象类
     */
    public function doMainValidate(Controller $controller, User $user, Request $request)
    {
        $current_param = date("oW");
        if ($this->_stat_interval == "2") {
            $current_param = date("Ym");
        } elseif ($this->_stat_interval == "3") {
            $current_param = date("Y");
        }
        if ($request->hasParameter("date")) {
            $current_param = $request->getParameter("date");
        }
        $current_year = $current_param;
        if ($this->_stat_interval == "1" || $this->_stat_interval == "2") {
            $current_year = substr($current_param, 0, 4);
        }
        $weekly_list = Utility::getWeeklyList($current_year);
        if ($this->_stat_interval == "3") {
            if (!Validate::checkDate($current_year, 1, 1)) {
                $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY, "Parameter date is invalid");
                $err->setPos(__FILE__, __LINE__);
                return $err;
            }
        } else {
            if ($this->_stat_interval == "2") {
                $current_month = substr($current_param, 4, 2);
                if (!Validate::checkDate($current_year, $current_month, 1)) {
                    $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY, "Parameter date is invalid");
                    $err->setPos(__FILE__, __LINE__);
                    return $err;
                }
            } else {
                if (!isset($weekly_list["week"][$current_param])) {
                    $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY, "Parameter date is invalid");
                    $err->setPos(__FILE__, __LINE__);
                    return $err;
                }
            }
        }
        $prev_param = "";
        $next_param = "";
        if ($this->_stat_interval == "3") {
            $next_param = date("Y", mktime(0, 0, 0, 1, 1, $current_param + 1));
            $prev_param = date("Y", mktime(0, 0, 0, 1, 1, $current_param - 1));
        } elseif ($this->_stat_interval == "2") {
            $year_param = substr($current_param, 0, 4);
            $month_param = substr($current_param, 4, 2);
            $next_param = date("Ym", mktime(0, 0, 0, $month_param + 1, 1, $year_param));
            $prev_param = date("Ym", mktime(0, 0, 0, $month_param - 1, 1, $year_param));
        } else {
            $week_num_list = array_keys($weekly_list["week"]);
            for ($i = 0; $i < count($week_num_list); $i++) {
                if ($week_num_list[$i] == $current_param) {
                    $next_param = $week_num_list[$i + 1];
                    $prev_param = $week_num_list[$i - 1];
                    break;
                } else {
                    continue;
                }
            }
        }
        $request->setAttribute("current_param", $current_param);
        $request->setAttribute("prev_param", $prev_param);
        $request->setAttribute("next_param", $next_param);
        $request->setAttribute("weekly_day_list", $weekly_list["week"]);
    }
}
?>