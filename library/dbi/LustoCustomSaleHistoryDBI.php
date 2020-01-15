<?php

/**
 * 数据库操作类-custom_sale_history
 * @author Kinsama
 * @version 2020-01-14
 */
class LustoCustomSaleHistoryDBI
{

    public static function selectSaleHistory($custom_id)
    {
        $dbi = Database::getInstance();
        $sql = "SELECT * FROM custom_sale_history" .
               " WHERE del_flg = 0 AND custom_id = " . $custom_id .
               " ORDER BY insert_date ASC";
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row["sale_id"]] = $row;
        }
        $result->free();
        return $data;
    }

    public static function insertCustomSaleHistory($insert_data)
    {
        $dbi = Database::getInstance();
        $result = $dbi->insert("custom_sale_history", $insert_data);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        return $result;
    }
}
?>