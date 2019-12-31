/*
Navicat MySQL Data Transfer

Source Server         : Localhost
Source Server Version : 50617
Source Host           : 127.0.0.1:3306
Source Database       : club

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2019-12-31 00:47:20
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
) ENGINE=InnoDB AUTO_INCREMENT=109 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admin_info
-- ----------------------------
INSERT INTO `admin_info` VALUES ('100', 'admin', 'rq1654', '692ce12433515518f9836bfd74921965', '2', '1', '老板专用', '2019-12-29 23:59:59', '2019-12-30 16:07:56', '0');
