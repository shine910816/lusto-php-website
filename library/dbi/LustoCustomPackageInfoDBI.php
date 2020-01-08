<?php

/**
 * 数据库操作类-custom_package_info
 * @author Kinsama
 * @version 2020-01-08
 */
class LustoCustomPackageInfoDBI
{

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
        $where = "custom_id = " . $custom_id . " WHERE card_order_id = " . $card_order_id;
        $result = $dbi->update("custom_package_info", $update_data, $where);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        return $result;
    }
}
?>