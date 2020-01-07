<?php

/**
 * 数据库应用类-custom_change_history
 * @author Kinsama
 * @version 2020-01-08
 */
class LustoCustomChangeHistoryEntity
{
    const CHANGE_TYPE_CARD_ID = "1";
    const CHANGE_TYPE_MOBILE = "2";
    const CHANGE_TYPE_PLATE = "3";
    const CHANGE_TYPE_NAME = "4";

    public static function getChangeTypeList()
    {
        return array(
            self::CHANGE_TYPE_CARD_ID => "会员卡号",
            self::CHANGE_TYPE_MOBILE => "手机号码",
            self::CHANGE_TYPE_PLATE => "车牌号码",
            self::CHANGE_TYPE_NAME => "会员姓名"
        );
    }
}
?>