<?php

/**
 * 数据库操作类-多表
 * @author Kinsama
 * @version 2020-01-15
 */
class LustoStatisticsDBI
{

    public static function selectAmountByInterval($from_day, $to_day)
    {
        $dbi = Database::getInstance();
        $sql = "SELECT create_d, SUM(card_price)" .
               " FROM custom_package_info" .
               " WHERE del_flg = 0" .
               " AND create_d >= " . $from_day .
               " AND create_d <= " . $to_day .
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

    public static function selectSaleTimesByInterval($from_day, $to_day)
    {
        $dbi = Database::getInstance();
        $sql = "SELECT create_d, COUNT(*)" .
               " FROM custom_sale_history" .
               " WHERE del_flg = 0" .
               " AND create_d >= " . $from_day .
               " AND create_d <= " . $to_day .
               " GROUP BY create_d" .
               " ORDER BY create_d ASC";
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row["create_d"]] = $row["COUNT(*)"];
        }
        $result->free();
        return $data;
    }

    public static function selectPredictByInterval($from_day, $to_day)
    {
        $dbi = Database::getInstance();
        $sql = "SELECT create_d, SUM(card_predict_amount)" .
               " FROM custom_sale_history" .
               " WHERE del_flg = 0" .
               " AND create_d >= " . $from_day .
               " AND create_d <= " . $to_day .
               " GROUP BY create_d" .
               " ORDER BY create_d ASC";
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row["create_d"]] = $row["SUM(card_predict_amount)"];
        }
        $result->free();
        return $data;
    }
}
?>