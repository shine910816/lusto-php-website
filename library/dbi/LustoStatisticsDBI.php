<?php

/**
 * 数据库操作类-多表
 * @author Kinsama
 * @version 2020-01-15
 */
class LustoStatisticsDBI
{

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

    public static function selectAmountByMonth($month)
    {
        $dbi = Database::getInstance();
        $sql = "SELECT create_d, SUM(card_price)" .
               " FROM custom_package_info" .
               " WHERE del_flg = 0" .
               " AND create_m = " . $month .
               " GROUP BY create_d" .
               " ORDER BY create_d ASC";
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row["create_d"]] = $row["SUM(card_price)"];
        }
        $result->free();
        return $data;
    }

    public static function selectSalesByMonth($month)
    {
        $dbi = Database::getInstance();
        $sql = "SELECT create_d AS date, COUNT(*) AS times, SUM(card_predict_amount) AS predict" .
               " FROM custom_sale_history" .
               " WHERE del_flg = 0" .
               " AND create_m = " . $month .
               " GROUP BY create_d" .
               " ORDER BY create_d ASC";
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

    public static function selectAmountByYear($year)
    {
        $dbi = Database::getInstance();
        $sql = "SELECT create_m, SUM(card_price)" .
               " FROM custom_package_info" .
               " WHERE del_flg = 0" .
               " AND create_y = " . $year .
               " GROUP BY create_m" .
               " ORDER BY create_m ASC";
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row["create_m"]] = $row["SUM(card_price)"];
        }
        $result->free();
        return $data;
    }

    public static function selectSalesByYear($year)
    {
        $dbi = Database::getInstance();
        $sql = "SELECT create_m AS date, COUNT(*) AS times, SUM(card_predict_amount) AS predict" .
               " FROM custom_sale_history" .
               " WHERE del_flg = 0" .
               " AND create_y = " . $year .
               " GROUP BY create_m" .
               " ORDER BY create_m ASC";
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
}
?>