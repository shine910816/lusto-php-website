<?php

/**
 * 配置控制器
 * @author Kinsama
 * @version 2017-08-02
 */
class Config
{

    public static function getAllowedCurrent()
    {
        $list_data = array();
        $result = array();
        $result["common"]["home"] = SYSTEM_AUTH_LOGIN;
        $result["user"]["login"] = SYSTEM_AUTH_COMMON;
        $result["user"]["disp"] = SYSTEM_AUTH_LOGIN;
        $result["user"]["change_password"] = SYSTEM_AUTH_LOGIN;
        $result["admin"]["admin_list"] = SYSTEM_AUTH_ADMIN;
        $result["admin"]["admin_create"] = SYSTEM_AUTH_ADMIN;
        $list_data["php"] = $result;
        $result = array();
        $list_data["api"] = $result;
        return $list_data;
    }

    public static function getNavigation()
    {
        $result = array();
        $result["common"]["home"] = array();
        $result["user"]["login"] = array("用户登录");
        $result["user"]["disp"] = array("个人设定");
        $result["user"]["change_password"] = array('<a href="./?menu=user&act=disp" data-ajax="false">个人设定</a>', "修改密码");
        $result["admin"]["admin_list"] = array("成员管理");
        $result["admin"]["admin_create"] = array('<a href="./?menu=admin&act=admin_list" data-ajax="false">成员管理</a>', "创建用户");
        return $result;
    }

    public static function getDataSourceName()
    {
        return array(
            "host" => "127.0.0.1",
            "user" => "root",
            "pswd" => "",
            "name" => "club",
            "port" => "3306"
        );
    }

    public static function getUsableGlobalKeys()
    {
        $result = array();
        $result[REDIRECT_URL] = array("user:login");
        return $result;
    }
}
?>