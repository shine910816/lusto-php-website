<?php

/**
 * 数据库操作类-custom_sale_history
 * @author Kinsama
 * @version 2020-01-14
 */
class LustoCustomSaleHistoryDBI
{

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