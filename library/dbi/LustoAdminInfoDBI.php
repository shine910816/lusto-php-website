<?php

/**
 * 数据库操作类-admin_info
 * @author Kinsama
 * @version 2019-12-30
 */
class LustoAdminInfoDBI
{

    public static function selectAdminNameList()
    {
        $dbi = Database::getInstance();
        $sql = "SELECT * FROM admin_info";
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            if ($row["admin_note"]) {
                $data[$row["admin_id"]] = $row["admin_note"];
            } else {
                $data[$row["admin_id"]] = $row["admin_name"];
            }
        }
        $result->free();
        return $data;
    }

    public static function getAdminInfo($admin_id)
    {
        $dbi = Database::getInstance();
        $sql = "SELECT * FROM admin_info WHERE del_flg = 0 AND admin_id = " . $admin_id . " LIMIT 1";
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row["admin_id"]] = $row;
        }
        $result->free();
        return $data;
    }

    public static function getAdminInfoByAdminName($admin_name)
    {
        $dbi = Database::getInstance();
        $sql = "SELECT * FROM admin_info WHERE del_flg = 0 AND admin_name = " . $dbi->quote($admin_name) . " AND admin_activity = 1 LIMIT 1";
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        $result->free();
        if (count($data) == 1) {
            return $data[0];
        } else {
            return array();
        }
    }

    public static function getNormalAdminInfo()
    {
        $dbi = Database::getInstance();
        $sql = "SELECT * FROM admin_info WHERE admin_auth_level = 1 AND del_flg = 0";
        $result = $dbi->query($sql);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[$row["admin_id"]] = $row;
        }
        $result->free();
        return $data;
    }

    public static function insertAdminInfo($insert_data)
    {
        $dbi = Database::getInstance();
        $result = $dbi->insert("admin_info", $insert_data);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        return $result;
    }

    public static function updateAdminInfo($update_data, $admin_id)
    {
        $dbi = Database::getInstance();
        $result = $dbi->update("admin_info", $update_data, "admin_id = " . $admin_id);
        if ($dbi->isError($result)) {
            $result->setPos(__FILE__, __LINE__);
            return $result;
        }
        return $result;
    }
}
?>