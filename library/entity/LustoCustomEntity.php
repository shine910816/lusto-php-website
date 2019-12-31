<?php

/**
 * 数据库应用类-custom_info
 * @author Kinsama
 * @version 2019-12-31
 */
class LustoCustomEntity
{
    const VEHICLE_TYPE_NORMAL = "1";
    const VEHICLE_TYPE_SUV = "2";

    public static function getVehicleTypeList()
    {
        return array(
            self::VEHICLE_TYPE_NORMAL => "轿车",
            self::VEHICLE_TYPE_SUV => "SUV"
        );
    }

    public static function getPlateRegionList()
    {
        return array(
            "11" => "京",
            "12" => "津",
            "13" => "冀",
            "14" => "晋",
            "15" => "蒙",
            "21" => "辽",
            "22" => "吉",
            "23" => "黑",
            "31" => "沪",
            "32" => "苏",
            "33" => "浙",
            "34" => "皖",
            "35" => "闽",
            "36" => "赣",
            "37" => "鲁",
            "41" => "豫",
            "42" => "鄂",
            "43" => "湘",
            "44" => "粤",
            "45" => "桂",
            "46" => "琼",
            "50" => "渝",
            "51" => "川",
            "52" => "贵",
            "53" => "云",
            "54" => "藏",
            "61" => "陕",
            "62" => "甘",
            "63" => "青",
            "64" => "宁",
            "65" => "新"
        );
    }
}
?>