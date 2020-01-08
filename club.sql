/*
Navicat MySQL Data Transfer

Source Server         : Localhost
Source Server Version : 50617
Source Host           : 127.0.0.1:3306
Source Database       : club

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2020-01-08 18:33:14
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for admin_info
-- ----------------------------
DROP TABLE IF EXISTS `admin_info`;
CREATE TABLE `admin_info` (
  `admin_id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_name` varchar(50) DEFAULT NULL,
  `admin_salt` varchar(6) DEFAULT NULL,
  `admin_password` varchar(32) DEFAULT NULL,
  `admin_auth_level` tinyint(4) NOT NULL,
  `admin_activity` tinyint(4) NOT NULL,
  `admin_note` text,
  `insert_date` datetime NOT NULL,
  `update_date` datetime NOT NULL,
  `del_flg` tinyint(4) NOT NULL,
  PRIMARY KEY (`admin_id`)
) ENGINE=InnoDB AUTO_INCREMENT=102 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admin_info
-- ----------------------------
INSERT INTO `admin_info` VALUES ('100', 'admin', '7aaq5g', '0c4c47baef406d9901f222d3d3bba898', '2', '1', '老板专用', '2019-12-29 23:59:59', '2019-12-31 11:57:33', '0');
INSERT INTO `admin_info` VALUES ('101', 'e0001', 'rciizb', '0c5b04c203051eb1894ec18aea7efc70', '1', '1', '测试用', '2019-12-31 11:17:00', '2019-12-31 17:37:49', '0');

-- ----------------------------
-- Table structure for custom_change_history
-- ----------------------------
DROP TABLE IF EXISTS `custom_change_history`;
CREATE TABLE `custom_change_history` (
  `history_id` int(11) NOT NULL AUTO_INCREMENT,
  `custom_id` int(11) NOT NULL,
  `change_type` tinyint(4) NOT NULL,
  `change_from` varchar(50) DEFAULT NULL,
  `change_to` varchar(50) DEFAULT NULL,
  `operator_id` int(11) NOT NULL,
  `insert_date` datetime NOT NULL,
  `update_date` datetime NOT NULL,
  `del_flg` tinyint(4) NOT NULL,
  PRIMARY KEY (`history_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of custom_change_history
-- ----------------------------
INSERT INTO `custom_change_history` VALUES ('1', '1', '3', '', '津HLR865', '100', '2020-01-08 18:23:41', '2020-01-08 18:23:41', '0');
INSERT INTO `custom_change_history` VALUES ('2', '2', '4', '大哥', '张鹤鹏', '100', '2020-01-08 18:25:33', '2020-01-08 18:25:33', '0');

-- ----------------------------
-- Table structure for custom_info
-- ----------------------------
DROP TABLE IF EXISTS `custom_info`;
CREATE TABLE `custom_info` (
  `custom_id` int(11) NOT NULL AUTO_INCREMENT,
  `custom_mobile` varchar(11) DEFAULT NULL,
  `custom_plate_region` tinyint(4) NOT NULL,
  `custom_plate` varchar(8) DEFAULT NULL,
  `custom_name` varchar(50) DEFAULT NULL,
  `custom_vehicle_type` tinyint(4) NOT NULL,
  `card_id` varchar(20) NOT NULL,
  `card_usable_infinity_flg` tinyint(4) NOT NULL,
  `insert_date` datetime NOT NULL,
  `update_date` datetime NOT NULL,
  `del_flg` tinyint(4) NOT NULL,
  PRIMARY KEY (`custom_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of custom_info
-- ----------------------------
INSERT INTO `custom_info` VALUES ('1', '13622082200', '12', 'HLR865', '李然', '1', '10001000001', '0', '2020-01-08 18:23:07', '2020-01-08 18:23:41', '0');
INSERT INTO `custom_info` VALUES ('2', '15750293735', '12', 'ADC416', '张鹤鹏', '2', '10001000002', '1', '2020-01-08 18:24:21', '2020-01-08 18:25:32', '0');

-- ----------------------------
-- Table structure for custom_package_info
-- ----------------------------
DROP TABLE IF EXISTS `custom_package_info`;
CREATE TABLE `custom_package_info` (
  `custom_id` int(11) NOT NULL,
  `card_order_id` int(11) NOT NULL,
  `card_package` int(11) NOT NULL,
  `card_price` float(11,2) NOT NULL,
  `card_usable_infinity_flg` tinyint(4) NOT NULL,
  `card_usable_count` int(11) NOT NULL,
  `card_current_count` int(11) NOT NULL,
  `card_expire` datetime NOT NULL,
  `card_predict_amount` float(11,2) NOT NULL,
  `operator_id` int(11) NOT NULL,
  `insert_date` datetime NOT NULL,
  `update_date` datetime NOT NULL,
  `del_flg` tinyint(4) NOT NULL,
  PRIMARY KEY (`custom_id`,`card_order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of custom_package_info
-- ----------------------------
INSERT INTO `custom_package_info` VALUES ('1', '1', '1001', '798.00', '0', '59', '59', '0000-00-00 00:00:00', '13.53', '100', '2020-01-08 18:23:07', '2020-01-08 18:23:07', '0');
INSERT INTO `custom_package_info` VALUES ('2', '1', '3001', '998.00', '1', '0', '0', '2021-01-07 23:59:59', '0.00', '100', '2020-01-08 18:24:21', '2020-01-08 18:24:21', '0');

-- ----------------------------
-- Table structure for package_info
-- ----------------------------
DROP TABLE IF EXISTS `package_info`;
CREATE TABLE `package_info` (
  `p_id` int(11) NOT NULL,
  `p_vehicle_type` tinyint(4) NOT NULL,
  `p_price` float(11,2) NOT NULL,
  `p_infinity_flg` tinyint(4) NOT NULL,
  `p_times` int(11) NOT NULL,
  `p_predict_price` float(11,2) NOT NULL,
  `p_special_flg` tinyint(4) NOT NULL,
  `insert_date` datetime NOT NULL,
  `update_date` datetime NOT NULL,
  `del_flg` tinyint(4) NOT NULL,
  PRIMARY KEY (`p_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of package_info
-- ----------------------------
INSERT INTO `package_info` VALUES ('1001', '1', '798.00', '0', '59', '13.53', '0', '2020-01-01 00:00:00', '2020-01-01 00:00:00', '0');
INSERT INTO `package_info` VALUES ('1002', '1', '498.00', '0', '32', '15.56', '0', '2020-01-01 00:00:00', '2020-01-01 00:00:00', '0');
INSERT INTO `package_info` VALUES ('1003', '1', '298.00', '0', '17', '17.52', '0', '2020-01-01 00:00:00', '2020-01-01 00:00:00', '0');
INSERT INTO `package_info` VALUES ('2001', '2', '798.00', '0', '46', '17.34', '0', '2020-01-01 00:00:00', '2020-01-01 00:00:00', '0');
INSERT INTO `package_info` VALUES ('2002', '2', '498.00', '0', '25', '19.92', '0', '2020-01-01 00:00:00', '2020-01-01 00:00:00', '0');
INSERT INTO `package_info` VALUES ('2003', '2', '298.00', '0', '14', '21.30', '0', '2020-01-01 00:00:00', '2020-01-01 00:00:00', '0');
INSERT INTO `package_info` VALUES ('3001', '0', '998.00', '1', '0', '0.00', '0', '2020-01-01 00:00:00', '2020-01-01 00:00:00', '0');
INSERT INTO `package_info` VALUES ('4000', '0', '499.00', '1', '0', '0.00', '1', '2020-01-01 00:00:00', '2020-01-01 00:00:00', '0');
