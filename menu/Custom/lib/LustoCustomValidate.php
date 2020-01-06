<?php
	
/**
 * 会员信息检证
 * @author Kinsama
 * @version 2020-01-03
 */
class LustoCustomValidate
{

    public static function checkCustomName($param)
    {
        if (!Validate::checkNotNull($param)) {
            return false;
        }
        return Validate::checkChinese($param);
    }

    public static function checkCardId($param)
    {
        if (!Validate::checkNotNull($param)) {
            return false;
        }
        if (!preg_match("/^[0-9]{5,11}$/", $param)) {
            return false;
        }
        return true;
    }

    public static function checkCustomMobile($param)
    {
        if (!Validate::checkNotNull($param)) {
            return true;
        }
        return Validate::checkMobileNumber($param);
    }

    public static function checkPlateNumber($param)
    {
        if (!Validate::checkNotNull($param)) {
            return true;
        }
        if (!preg_match("/^[a-z0-9]{6,7}$/i", $param)) {
            return false;
        }
        return true;
    }
}
?>