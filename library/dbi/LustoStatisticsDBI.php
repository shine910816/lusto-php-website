<?php

/**
 * 数据库操作类-多表
 * @author Kinsama
 * @version 2020-01-15
 */
class LustoStatisticsDBI
{

    public static function selectAmount($param, $year_flg = false)
    {
        $dbi = Database::getInstance();
        $result_column = "create_d";
        $search_column = "create_m";
        if ($year_flg) {
            $result_column = "create_m";
            $search_column = "create_y";
        }
        $sql = "SELECT " . $result_column . ", SUM(card_price)" .
               " FROM custom_package_info" .
               " WHERE del_flg = 0" .
               " AND " . $search_column . " = " . $param .
               " GROUP BY " . $result_column .
               " ORDER BY " . $result_column . " ASC";
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row[$result_column]] = $row["SUM(card_price)"];
        }
        $result->free();
        return $data;
    }

    public static function selectSales($param, $year_flg = false)
    {
        $dbi = Database::getInstance();
        $result_column = "create_d";
        $search_column = "create_m";
        if ($year_flg) {
            $result_column = "create_m";
            $search_column = "create_y";
        }
        $sql = "SELECT " . $result_column . " AS date, COUNT(*) AS times, SUM(card_predict_amount) AS predict" .
               " FROM custom_sale_history" .
               " WHERE del_flg = 0" .
               " AND " . $search_column . " = " . $param .
               " GROUP BY " . $result_column .
               " ORDER BY " . $result_column . " ASC";
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row["date"]] = $row;
        }
        $result->free();
        return $data;
    }

    public static function selectAmountByInterval($from_day, $to_day, $week_interval = false)
    {
        $dbi = Database::getInstance();
        $interval_column = "create_d";
        if ($week_interval) {
            $interval_column = "create_w";
        }
        $sql = "SELECT create_d, create_w, SUM(card_price)" .
               " FROM custom_package_info" .
               " WHERE del_flg = 0" .
               " AND create_d >= " . $from_day .
               " AND create_d <= " . $to_day .
               " GROUP BY " . $interval_column .
               " ORDER BY " . $interval_column . " ASC";
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row[$interval_column]] = $row["SUM(card_price)"];
        }
        $result->free();
        return $data;
    }

    public static function selectSalesByInterval($from_day, $to_day, $week_interval = false)
    {
        $dbi = Database::getInstance();
        $interval_column = "create_d";
        if ($week_interval) {
            $interval_column = "create_w";
        }
        $sql = "SELECT " . $interval_column . " AS date, COUNT(*) AS times, SUM(card_predict_amount) AS predict" .
               " FROM custom_sale_history" .
               " WHERE del_flg = 0" .
               " AND create_d >= " . $from_day .
               " AND create_d <= " . $to_day .
               " GROUP BY " . $interval_column .
               " ORDER BY " . $interval_column . " ASC";
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row["date"]] = $row;
        }
        $result->free();
        return $data;
    }

    public static function selectCustomList($infinity_flg = false)
    {
        $dbi = Database::getInstance();
        $search_column = "SUM(p.card_current_count)";
        $where_value = "0";
        if ($infinity_flg) {
            $search_column = "MAX(p.card_expire)";
            $where_value = "1";
        }
        $sql = "SELECT p.custom_id, i.card_id, i.custom_name, " . $search_column . " AS `value`" .
               " FROM custom_package_info p LEFT OUTER JOIN custom_info i ON i.custom_id = p.custom_id" .
               " WHERE p.del_flg = 0 AND i.del_flg = 0" .
               " AND p.card_usable_infinity_flg = " . $where_value .
               " GROUP BY p.custom_id ORDER BY p.custom_id ASC";
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row["custom_id"]] = $row;
        }
        $result->free();
        return $data;
    }
}
?>