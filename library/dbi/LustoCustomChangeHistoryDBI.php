<?php

/**
 * 数据库操作类-custom_change_history
 * @author Kinsama
 * @version 2020-01-08
 */
class LustoCustomChangeHistoryDBI
{

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