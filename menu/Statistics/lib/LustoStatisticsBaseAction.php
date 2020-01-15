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
        $min_param = "201901";
        $max_param = Utility::getDateWeek(date("Y-m-d H:i:s"));
        if ($this->_stat_interval == "2") {
            $max_param = date("Ym");
        } elseif ($this->_stat_interval == "3") {
            $min_param = "2019";
            $max_param = date("Y");
        }
        $current_param = $max_param;
        if ($request->hasParameter("date")) {
            $current_param = $request->getParameter("date");
            if ($current_param > $max_param || $current_param < $min_param) {
                $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY, "Parameter date is over interval");
                $err->setPos(__FILE__, __LINE__);
                return $err;
            }
            if ($this->_stat_interval == "3") {
                if (!Validate::checkDate($current_param, 1, 1)) {
                    $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY, "Parameter date is invalid");
                    $err->setPos(__FILE__, __LINE__);
                    return $err;
                }
            } else {
                $param_year = substr($current_param, 0, 4);
                $param_other = substr($current_param, 4, 2);
                if ($this->_stat_interval == "2") {
                    if (!Validate::checkDate($param_year, $param_other, 1)) {
                        $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY, "Parameter date is invalid");
                        $err->setPos(__FILE__, __LINE__);
                        return $err;
                    }
                } else {
                    if (!Validate::checkDate($param_year, 1, 1)) {
                        $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY, "Parameter date is invalid");
                        $err->setPos(__FILE__, __LINE__);
                        return $err;
                    }
                    $week_num = (int) $param_other;
                    if ($week_num < 1 && $week_num > 52) {
                        $err = $controller->raiseError(ERROR_CODE_USER_FALSIFY, "Parameter date is invalid");
                        $err->setPos(__FILE__, __LINE__);
                        return $err;
                    }
                }
            }
        }
        $prev_param = "";
        $next_param = "";
        if ($this->_stat_interval == "3") {
            if ($current_param < $max_param) {
                $next_param = date("Y", mktime(0, 0, 0, 1, 1, $current_param + 1));
            }
            if ($current_param > $min_param) {
                $prev_param = date("Y", mktime(0, 0, 0, 1, 1, $current_param - 1));
            }
        } elseif ($this->_stat_interval == "2") {
            $year_param = substr($current_param, 0, 4);
            $month_param = substr($current_param, 4, 2);
            if ($current_param < $max_param) {
                $next_param = date("Ym", mktime(0, 0, 0, $month_param + 1, 1, $year_param));
            }
            if ($current_param > $min_param) {
                $prev_param = date("Ym", mktime(0, 0, 0, $month_param - 1, 1, $year_param));
            }
        } else {
            $year_param = substr($current_param, 0, 4);
            $week_param = substr($current_param, 4, 2);
            if ($current_param < $max_param) {
                if ($week_param == "52") {
                    $adjust_year = $year_param + 1;
                    $adjust_week = 1;
                } else {
                    $adjust_year = $year_param;
                    $adjust_week = $week_param + 1;
                }
                $next_param = sprintf("%04d%02d", $adjust_year, $adjust_week);
            }
            if ($current_param > $min_param) {
                if ($week_param == "01") {
                    $adjust_year = $year_param - 1;
                    $adjust_week = 52;
                } else {
                    $adjust_year = $year_param;
                    $adjust_week = $week_param - 1;
                }
                $prev_param = sprintf("%04d%02d", $adjust_year, $adjust_week);
            }
        }
        $request->setAttribute("current_param", $current_param);
        $request->setAttribute("prev_param", $prev_param);
        $request->setAttribute("next_param", $next_param);
    }
}
?>