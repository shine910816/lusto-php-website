<?php

/**
 * 数据库操作类-custom_change_history
 * @author Kinsama
 * @version 2020-01-08
 */
class LustoCustomChangeHistoryDBI
{

    public static function searchCustomChangeHistory($custom_id)
    {
        $dbi = Database::getInstance();
        $sql = "SELECT * FROM custom_change_history" .
               " WHERE del_flg = 0 AND custom_id = " . $custom_id . " ORDER BY history_id ASC";
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row["history_id"]] = $row;
        }
        $result->free();
        return $data;
    }

    public static function insertCustomPackage($insert_data)
    {
        $dbi = Database::getInstance();
        $result = $dbi->insert("custom_change_history", $insert_data);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        return $result;
    }
}
?>