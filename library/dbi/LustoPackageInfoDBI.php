<?php

/**
 * 数据库操作类-package_info
 * @author Kinsama
 * @version 2019-12-31
 */
class LustoPackageInfoDBI
{

    public static function selectPackage($p_id)
    {
        $dbi = Database::getInstance();
        $sql = "SELECT * FROM package_info WHERE del_flg = 0 AND p_id = " . $p_id . " LIMIT 1";
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row["p_id"]] = $row;
        }
        $result->free();
        return $data;
    }

    public static function selectPackageList($special_flg = false)
    {
        $dbi = Database::getInstance();
        $sql = "SELECT * FROM package_info WHERE del_flg = 0 AND p_special_flg = ";
        if ($special_flg) {
            $sql .= "1";
        } else {
            $sql .= "0";
        }
        $sql .= " ORDER BY p_vehicle_type ASC, p_price DESC";
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row["p_id"]] = $row;
        }
        $result->free();
        return $data;
    }

    public static function selectUsablePackageList($vehicle_type = "1")
    {
        $dbi = Database::getInstance();
        $sql = "SELECT * FROM package_info WHERE del_flg = 0" .
               " AND (p_vehicle_type = 0 OR p_vehicle_type = " . $vehicle_type . ")";
        $sql .= " ORDER BY p_price DESC, p_special_flg DESC";
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row["p_id"]] = $row;
        }
        $result->free();
        return $data;
    }
}
?>