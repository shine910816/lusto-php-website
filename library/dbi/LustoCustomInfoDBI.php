<?php

/**
 * ฟ๔ฟ๘&#24211;มเบ๎&#31867;-custom_info
 * @author Kinsama
 * @version 2020-01-02
 */
class LustoCustomInfoDBI
{

    public static function searchCustom($keyword, $type = "2")
    {
        $dbi = Database::getInstance();
        $sql = "SELECT c.custom_id," .
               " c.custom_name," .
               " d.card_id," .
               " c.custom_mobile," .
               " c.custom_plate_region," .
               " c.custom_plate," .
               " c.custom_vehicle_type" .
               " FROM custom_info c" .
               " LEFT OUTER JOIN card_info d ON d.custom_id = c.custom_id" .
               " WHERE c.del_flg = 0 AND d.del_flg = 0";
        if ($type == "2") {
            $sql .= " AND c.custom_mobile = " . $dbi->quote($keyword);
        } elseif ($type == "3") {
            $sql .= " AND c.custom_plate = " . $dbi->quote($keyword);
        } else {
            $sql .= " AND d.card_id = " . $dbi->quote($keyword);
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
}
?>