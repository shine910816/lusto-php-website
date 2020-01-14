<?php

/**
 * 数据库操作类-custom_package_info
 * @author Kinsama
 * @version 2020-01-08
 */
class LustoCustomPackageInfoDBI
{

    public static function selectCardPackage($custom_id, $card_usable_infinity_flg = "0")
    {
        $dbi = Database::getInstance();
        $where = "del_flg = 0 AND custom_id = " . $custom_id . " AND card_usable_infinity_flg = " . $card_usable_infinity_flg;
        $sql = "SELECT * FROM custom_package_info WHERE " . $where . " ORDER BY card_order_id ASC";
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row["card_order_id"]] = $row;
        }
        $result->free();
        return $data;
    }

    public static function selectTimesCardTotal($custom_id)
    {
        $dbi = Database::getInstance();
        $sql = "SELECT SUM(card_current_count) FROM custom_package_info" .
               " WHERE del_flg = 0" . 
               " AND custom_id = " . $custom_id .
               " AND card_usable_infinity_flg = 0" .
               " LIMIT 1";
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row["SUM(card_current_count)"];
        }
        $result->free();
        if (count($data) == 1) {
            return $data[0];
        } else {
            return false;
        }
    }

    public static function selectCurrentTimesCardPackage($custom_id)
    {
        $dbi = Database::getInstance();
        $sql = "SELECT card_order_id" .
               " FROM custom_package_info" .
               " WHERE del_flg = 0" .
               " AND custom_id = " . $custom_id .
               " AND card_usable_infinity_flg = 0" .
               " AND card_current_count > 0" .
               " ORDER BY card_order_id ASC LIMIT 1";
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row["card_order_id"];
        }
        $result->free();
        if (count($data) == 1) {
            return $data[0];
        } else {
            return false;
        }
    }

    public static function selectCurrentYearCardExpire($custom_id)
    {
        $dbi = Database::getInstance();
        $sql = "SELECT card_expire" .
               " FROM custom_package_info" .
               " WHERE del_flg = 0" .
               " AND custom_id = " . $custom_id .
               " AND card_usable_infinity_flg = 1" .
               " ORDER BY card_expire DESC LIMIT 1";
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row["card_expire"];
        }
        $result->free();
        if (count($data) == 1) {
            return $data[0];
        } else {
            return false;
        }
    }

    public static function selectCardCount($custom_id)
    {
        $dbi = Database::getInstance();
        $sql = "SELECT COUNT(*) FROM custom_package_info WHERE custom_id = " . $custom_id . " LIMIT 1";
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row["COUNT(*)"];
        }
        $result->free();
        if (count($data) == 1) {
            return $data[0];
        } else {
            return false;
        }
    }

    public static function insertCustomPackage($insert_data)
    {
        $dbi = Database::getInstance();
        $result = $dbi->insert("custom_package_info", $insert_data);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        return $result;
    }

    public static function updateCustomPackage($update_data, $custom_id, $card_order_id)
    {
        $dbi = Database::getInstance();
        $where = "custom_id = " . $custom_id . " AND card_order_id = " . $card_order_id;
        $result = $dbi->update("custom_package_info", $update_data, $where);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        return $result;
    }
}
?>