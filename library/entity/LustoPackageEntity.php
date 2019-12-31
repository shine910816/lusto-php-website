<?php

/**
 * 数据库应用类-package_info
 * @author Kinsama
 * @version 2019-12-31
 */
class LustoPackageEntity
{
    const VEHICLE_TYPE_COMMON = "0";
    const VEHICLE_TYPE_NORMAL = "1";
    const VEHICLE_TYPE_SUV = "2";

    public static function getVehicleTypeList()
    {
        return array(
            self::VEHICLE_TYPE_COMMON => "通用",
            self::VEHICLE_TYPE_NORMAL => "轿车",
            self::VEHICLE_TYPE_SUV => "SUV"
        );
    }
}
?>