/*
Navicat MySQL Data Transfer

Source Server         : Localhost
Source Server Version : 50617
Source Host           : 127.0.0.1:3306
Source Database       : club

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2020-01-15 18:27:23
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
INSERT INTO `admin_info` VALUES ('100', 'admin', '7aaq5g', '0c4c47baef406d9901f222d3d3bba898', '2', '1', '老板', '2019-12-29 23:59:59', '2019-12-31 11:57:33', '0');
INSERT INTO `admin_info` VALUES ('101', 'e0001', 'rciizb', '0c5b04c203051eb1894ec18aea7efc70', '1', '1', '一店小王', '2019-12-31 11:17:00', '2019-12-31 17:37:49', '0');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of custom_change_history
-- ----------------------------

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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of custom_info
-- ----------------------------
INSERT INTO `custom_info` VALUES ('1', '', '12', '', '茨木童子', '1', '10001', '0', '2019-07-16 13:07:08', '2019-07-16 13:07:08', '0');
INSERT INTO `custom_info` VALUES ('2', '', '12', '', '酒吞童子', '2', '10002', '0', '2019-07-17 13:07:50', '2019-07-17 13:07:50', '0');
INSERT INTO `custom_info` VALUES ('3', '', '12', '', '姑获鸟', '2', '10003', '1', '2019-08-16 13:10:01', '2019-08-16 13:10:01', '0');
INSERT INTO `custom_info` VALUES ('4', '', '12', '', '以津真天', '1', '10004', '1', '2019-08-16 13:10:17', '2019-08-16 13:10:17', '0');
INSERT INTO `custom_info` VALUES ('5', '', '12', '', '大天狗', '2', '10005', '1', '2019-09-20 13:11:38', '2019-09-20 13:11:38', '0');
INSERT INTO `custom_info` VALUES ('6', '', '12', '', '青行灯', '2', '10006', '1', '2019-10-25 13:12:25', '2019-10-25 13:12:25', '0');
INSERT INTO `custom_info` VALUES ('7', '', '12', '', '山兔', '1', '10007', '0', '2019-11-13 13:13:37', '2019-11-13 13:13:37', '0');
INSERT INTO `custom_info` VALUES ('8', '', '12', '', '孟婆', '2', '10008', '0', '2019-11-13 13:13:56', '2019-11-13 13:13:56', '0');
INSERT INTO `custom_info` VALUES ('9', '', '12', '', '座敷童子', '1', '10009', '0', '2019-12-04 13:17:02', '2019-12-04 13:17:02', '0');
INSERT INTO `custom_info` VALUES ('10', '', '12', '', '青蛙瓷器', '2', '10010', '0', '2019-12-04 13:17:24', '2019-12-04 13:17:24', '0');

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
  `create_y` int(4) NOT NULL,
  `create_m` int(6) NOT NULL,
  `create_w` int(6) NOT NULL,
  `create_d` int(8) NOT NULL,
  `insert_date` datetime NOT NULL,
  `update_date` datetime NOT NULL,
  `del_flg` tinyint(4) NOT NULL,
  PRIMARY KEY (`custom_id`,`card_order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of custom_package_info
-- ----------------------------
INSERT INTO `custom_package_info` VALUES ('1', '1', '1003', '298.00', '0', '17', '15', '0000-00-00 00:00:00', '17.52', '101', '2019', '201907', '201929', '20190716', '2019-07-16 13:07:08', '2020-01-06 13:20:24', '0');
INSERT INTO `custom_package_info` VALUES ('2', '1', '2003', '298.00', '0', '14', '12', '0000-00-00 00:00:00', '21.30', '101', '2019', '201907', '201929', '20190717', '2019-07-17 13:07:50', '2020-01-06 13:20:31', '0');
INSERT INTO `custom_package_info` VALUES ('3', '1', '4000', '499.00', '1', '0', '0', '2020-08-15 23:59:59', '0.00', '101', '2019', '201908', '201933', '20190816', '2019-08-16 13:10:01', '2019-08-16 13:10:01', '0');
INSERT INTO `custom_package_info` VALUES ('4', '1', '4000', '499.00', '1', '0', '0', '2020-08-15 23:59:59', '0.00', '101', '2019', '201908', '201933', '20190816', '2019-08-16 13:10:17', '2019-08-16 13:10:17', '0');
INSERT INTO `custom_package_info` VALUES ('5', '1', '3001', '998.00', '1', '0', '0', '2020-09-19 23:59:59', '0.00', '101', '2019', '201909', '201938', '20190920', '2019-09-20 13:11:38', '2019-09-20 13:11:38', '0');
INSERT INTO `custom_package_info` VALUES ('6', '1', '3001', '998.00', '1', '0', '0', '2020-10-24 23:59:59', '0.00', '101', '2019', '201910', '201943', '20191025', '2019-10-25 13:12:25', '2019-10-25 13:12:25', '0');
INSERT INTO `custom_package_info` VALUES ('7', '1', '1002', '498.00', '0', '32', '30', '0000-00-00 00:00:00', '15.56', '101', '2019', '201911', '201946', '20191113', '2019-11-13 13:13:37', '2020-01-09 13:21:15', '0');
INSERT INTO `custom_package_info` VALUES ('8', '1', '2002', '498.00', '0', '25', '23', '0000-00-00 00:00:00', '19.92', '101', '2019', '201911', '201946', '20191113', '2019-11-13 13:13:56', '2020-01-09 13:21:20', '0');
INSERT INTO `custom_package_info` VALUES ('9', '1', '1001', '798.00', '0', '59', '57', '0000-00-00 00:00:00', '13.53', '101', '2019', '201912', '201949', '20191204', '2019-12-04 13:17:02', '2020-01-10 13:21:27', '0');
INSERT INTO `custom_package_info` VALUES ('10', '1', '2001', '798.00', '0', '46', '44', '0000-00-00 00:00:00', '17.34', '101', '2019', '201912', '201949', '20191204', '2019-12-04 13:17:24', '2020-01-10 13:21:32', '0');

-- ----------------------------
-- Table structure for custom_sale_history
-- ----------------------------
DROP TABLE IF EXISTS `custom_sale_history`;
CREATE TABLE `custom_sale_history` (
  `sale_id` int(11) NOT NULL AUTO_INCREMENT,
  `custom_id` int(11) NOT NULL,
  `card_usable_infinity_flg` tinyint(4) NOT NULL,
  `card_predict_amount` float(11,2) NOT NULL,
  `operator_id` int(11) NOT NULL,
  `create_y` int(4) NOT NULL,
  `create_m` int(6) NOT NULL,
  `create_w` int(6) NOT NULL,
  `create_d` int(8) NOT NULL,
  `insert_date` datetime NOT NULL,
  `update_date` datetime NOT NULL,
  `del_flg` tinyint(4) NOT NULL,
  PRIMARY KEY (`sale_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of custom_sale_history
-- ----------------------------
INSERT INTO `custom_sale_history` VALUES ('1', '1', '0', '17.52', '101', '2019', '201912', '202001', '20191230', '2019-12-30 13:18:19', '2019-12-30 13:18:19', '0');
INSERT INTO `custom_sale_history` VALUES ('2', '2', '0', '21.30', '101', '2019', '201912', '202001', '20191230', '2019-12-30 13:18:31', '2019-12-30 13:18:31', '0');
INSERT INTO `custom_sale_history` VALUES ('3', '3', '1', '0.00', '101', '2019', '201912', '202001', '20191230', '2019-12-30 13:18:38', '2019-12-30 13:18:38', '0');
INSERT INTO `custom_sale_history` VALUES ('4', '4', '1', '0.00', '101', '2019', '201912', '202001', '20191230', '2019-12-30 13:18:47', '2019-12-30 13:18:47', '0');
INSERT INTO `custom_sale_history` VALUES ('5', '5', '1', '0.00', '101', '2019', '201912', '202001', '20191230', '2019-12-30 13:18:55', '2019-12-30 13:18:55', '0');
INSERT INTO `custom_sale_history` VALUES ('6', '6', '1', '0.00', '101', '2019', '201912', '202001', '20191231', '2019-12-31 13:19:04', '2019-12-31 13:19:04', '0');
INSERT INTO `custom_sale_history` VALUES ('7', '7', '0', '15.56', '101', '2019', '201912', '202001', '20191231', '2019-12-31 13:19:11', '2019-12-31 13:19:11', '0');
INSERT INTO `custom_sale_history` VALUES ('8', '8', '0', '19.92', '101', '2019', '201912', '202001', '20191231', '2019-12-31 13:19:16', '2019-12-31 13:19:16', '0');
INSERT INTO `custom_sale_history` VALUES ('9', '9', '0', '13.53', '101', '2019', '201912', '202001', '20191231', '2019-12-31 13:19:22', '2019-12-31 13:19:22', '0');
INSERT INTO `custom_sale_history` VALUES ('10', '10', '0', '17.34', '101', '2019', '201912', '202001', '20191231', '2019-12-31 13:19:28', '2019-12-31 13:19:28', '0');
INSERT INTO `custom_sale_history` VALUES ('11', '1', '0', '17.52', '101', '2020', '202001', '202002', '20200106', '2020-01-06 13:20:24', '2020-01-06 13:20:24', '0');
INSERT INTO `custom_sale_history` VALUES ('12', '2', '0', '21.30', '101', '2020', '202001', '202002', '20200106', '2020-01-06 13:20:31', '2020-01-06 13:20:31', '0');
INSERT INTO `custom_sale_history` VALUES ('13', '3', '1', '0.00', '101', '2020', '202001', '202002', '20200107', '2020-01-07 13:20:42', '2020-01-07 13:20:42', '0');
INSERT INTO `custom_sale_history` VALUES ('14', '4', '1', '0.00', '101', '2020', '202001', '202002', '20200107', '2020-01-07 13:20:48', '2020-01-07 13:20:48', '0');
INSERT INTO `custom_sale_history` VALUES ('15', '5', '1', '0.00', '101', '2020', '202001', '202002', '20200108', '2020-01-08 13:20:57', '2020-01-08 13:20:57', '0');
INSERT INTO `custom_sale_history` VALUES ('16', '6', '1', '0.00', '101', '2020', '202001', '202002', '20200108', '2020-01-08 13:21:04', '2020-01-08 13:21:04', '0');
INSERT INTO `custom_sale_history` VALUES ('17', '7', '0', '15.56', '101', '2020', '202001', '202002', '20200109', '2020-01-09 13:21:15', '2020-01-09 13:21:15', '0');
INSERT INTO `custom_sale_history` VALUES ('18', '8', '0', '19.92', '101', '2020', '202001', '202002', '20200109', '2020-01-09 13:21:20', '2020-01-09 13:21:20', '0');
INSERT INTO `custom_sale_history` VALUES ('19', '9', '0', '13.53', '101', '2020', '202001', '202002', '20200110', '2020-01-10 13:21:27', '2020-01-10 13:21:27', '0');
INSERT INTO `custom_sale_history` VALUES ('20', '10', '0', '17.34', '101', '2020', '202001', '202002', '20200110', '2020-01-10 13:21:32', '2020-01-10 13:21:32', '0');

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
