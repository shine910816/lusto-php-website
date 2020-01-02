/*
Navicat MySQL Data Transfer

Source Server         : Localhost
Source Server Version : 50617
Source Host           : 127.0.0.1:3306
Source Database       : club

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2020-01-03 02:05:35
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
-- Table structure for card_info
-- ----------------------------
DROP TABLE IF EXISTS `card_info`;
CREATE TABLE `card_info` (
  `custom_id` int(11) NOT NULL,
  `card_id` varchar(20) DEFAULT NULL,
  `card_package` int(11) NOT NULL,
  `card_usable_infinity_flg` tinyint(4) NOT NULL,
  `card_usable_count` tinyint(11) NOT NULL,
  `card_expire` datetime NOT NULL,
  `card_predict_amount` float(11,2) NOT NULL,
  `insert_date` datetime NOT NULL,
  `update_date` datetime NOT NULL,
  `del_flg` tinyint(4) NOT NULL,
  PRIMARY KEY (`custom_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of card_info
-- ----------------------------
INSERT INTO `card_info` VALUES ('1', '10010000001', '0', '0', '3', '2020-05-19 23:59:59', '10.00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0');

-- ----------------------------
-- Table structure for custom_info
-- ----------------------------
DROP TABLE IF EXISTS `custom_info`;
CREATE TABLE `custom_info` (
  `custom_id` int(11) NOT NULL AUTO_INCREMENT,
  `custom_name` varchar(50) DEFAULT NULL,
  `custom_mobile` varchar(11) DEFAULT NULL,
  `custom_plate_region` tinyint(4) NOT NULL,
  `custom_plate` varchar(8) DEFAULT NULL,
  `custom_vehicle_type` tinyint(4) NOT NULL,
  `insert_date` datetime NOT NULL,
  `update_date` datetime NOT NULL,
  `del_flg` tinyint(4) NOT NULL,
  PRIMARY KEY (`custom_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of custom_info
-- ----------------------------
INSERT INTO `custom_info` VALUES ('1', '李然', '13622082200', '12', 'HLR865', '1', '2019-12-31 18:14:20', '2019-12-31 18:14:27', '0');

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
  `p_experience_flg` tinyint(4) NOT NULL,
  `p_special_flg` tinyint(4) NOT NULL,
  `insert_date` datetime NOT NULL,
  `update_date` datetime NOT NULL,
  `del_flg` tinyint(4) NOT NULL,
  PRIMARY KEY (`p_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of package_info
-- ----------------------------
INSERT INTO `package_info` VALUES ('1001', '1', '298.00', '0', '22', '0', '0', '2020-01-01 00:00:00', '2020-01-01 00:00:00', '0');
INSERT INTO `package_info` VALUES ('1002', '1', '200.00', '0', '14', '0', '0', '2020-01-01 00:00:00', '2020-01-01 00:00:00', '0');
INSERT INTO `package_info` VALUES ('2001', '2', '298.00', '0', '16', '0', '0', '2020-01-01 00:00:00', '2020-01-01 00:00:00', '0');
INSERT INTO `package_info` VALUES ('2002', '2', '200.00', '0', '10', '0', '0', '2020-01-01 00:00:00', '2020-01-01 00:00:00', '0');
INSERT INTO `package_info` VALUES ('3001', '0', '998.00', '1', '0', '0', '0', '2020-01-01 00:00:00', '2020-01-01 00:00:00', '0');
INSERT INTO `package_info` VALUES ('4000', '0', '499.00', '1', '0', '0', '1', '2020-01-01 00:00:00', '2020-01-01 00:00:00', '0');
INSERT INTO `package_info` VALUES ('4001', '1', '100.00', '0', '6', '1', '1', '2020-01-01 00:00:00', '2020-01-01 00:00:00', '0');
INSERT INTO `package_info` VALUES ('4002', '2', '100.00', '0', '4', '1', '1', '2020-01-01 00:00:00', '2020-01-01 00:00:00', '0');
