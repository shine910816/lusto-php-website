<?php

/**
 * 数据库操作类-custom_info
 * @author Kinsama
 * @version 2020-01-02
 */
class LustoCustomInfoDBI
{

    public static function searchCustom($keyword, $type = "1")
    {
        $dbi = Database::getInstance();
        $sql = "SELECT custom_id," .
               " card_id," .
               " custom_mobile," .
               " custom_plate_region," .
               " custom_plate," .
               " custom_name," .
               " custom_vehicle_type" .
               " FROM custom_info" .
               " WHERE del_flg = 0";
        if ($type == "2") {
            $sql .= " AND custom_mobile = " . $dbi->quote($keyword);
        } elseif ($type == "3") {
            $sql .= " AND custom_plate = " . $dbi->quote($keyword);
        } else {
            $sql .= " AND card_id = " . $dbi->quote($keyword);
        }
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

    public static function selectCustom($custom_id)
    {
        $dbi = Database::getInstance();
        $sql = "SELECT * FROM custom_info WHERE del_flg = 0 AND custom_id = " .$custom_id;
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