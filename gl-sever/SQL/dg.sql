/*
Navicat MySQL Data Transfer

Source Server         : 数据库
Source Server Version : 50640
Source Host           : localhost:3306
Source Database       : dg

Target Server Type    : MYSQL
Target Server Version : 50640
File Encoding         : 65001

Date: 2022-03-17 13:07:05
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for cp
-- ----------------------------
DROP TABLE IF EXISTS `cp`;
CREATE TABLE `cp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cai_name` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `cai_xi` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `jiage` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `cai_img` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `num` varchar(255) COLLATE utf8_bin DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of cp
-- ----------------------------
INSERT INTO `cp` VALUES ('31', '芒果冰冰乐', '茶饮', '2', '/img/nc/nai1.jpg', '1');
INSERT INTO `cp` VALUES ('77', '泡芙面包', '甜点', '3', '/img/nc/chi4.jpg', '1');
INSERT INTO `cp` VALUES ('78', '红旗22', '茶饮', '10', '/img/nc/nai2.jpg', '1');
INSERT INTO `cp` VALUES ('79', '果汁牛肉', '甜点', '15', '/img/nc/nai4.jpg', '1');

-- ----------------------------
-- Table structure for cx
-- ----------------------------
DROP TABLE IF EXISTS `cx`;
CREATE TABLE `cx` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `xi_name` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of cx
-- ----------------------------
INSERT INTO `cx` VALUES ('2', '茶饮');
INSERT INTO `cx` VALUES ('5', '甜点');
INSERT INTO `cx` VALUES ('7', '333');
INSERT INTO `cx` VALUES ('8', '奶茶');

-- ----------------------------
-- Table structure for dd
-- ----------------------------
DROP TABLE IF EXISTS `dd`;
CREATE TABLE `dd` (
  `id` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '1',
  `date` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `sum` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `code` varchar(255) COLLATE utf8_bin DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of dd
-- ----------------------------
INSERT INTO `dd` VALUES ('2021n06y04r02s19f10', '2021-06-04', '18', '1');
INSERT INTO `dd` VALUES ('2021n06y04r02s20f48', '2021-06-04', '16', '1');
INSERT INTO `dd` VALUES ('2021n06y04r02s21f06', '2021-06-04', '28', '1');
INSERT INTO `dd` VALUES ('2021n06y04r02s21f59', '2021-06-04', '27', '1');
INSERT INTO `dd` VALUES ('2021n06y04r03s10f15', '2021-06-04', '36', '0');
INSERT INTO `dd` VALUES ('2021n06y04r11s20f09', '2021-06-04', '50', '1');
INSERT INTO `dd` VALUES ('2021n06y04r11s22f34', '2021-06-04', '15', '0');
INSERT INTO `dd` VALUES ('2021n06y04r11s26f15', '2021-06-04', '18', '1');
INSERT INTO `dd` VALUES ('2021n06y04r17s02f08', '2021-06-04', '5', '1');
INSERT INTO `dd` VALUES ('2021n06y04r17s11f46', '2021-06-04', '42', '1');
INSERT INTO `dd` VALUES ('2021n06y04r17s11f54', '2021-06-04', '30', '0');
INSERT INTO `dd` VALUES ('2021n06y04r17s12f04', '2021-06-04', '20', '1');
INSERT INTO `dd` VALUES ('2021n06y04r17s12f19', '2021-06-04', '14', '1');
INSERT INTO `dd` VALUES ('2021n06y04r17s20f41', '2021-06-04', '49', '1');
INSERT INTO `dd` VALUES ('2021n06y04r17s35f38', '2021-06-04', '30', '1');
INSERT INTO `dd` VALUES ('2021n06y04r17s36f31', '2021-06-04', '20', '0');
INSERT INTO `dd` VALUES ('2021n06y04r18s11f21', '2021-06-04', '10', '1');
INSERT INTO `dd` VALUES ('2021n06y24r01s48f59', '2021-06-24', '12', '1');
INSERT INTO `dd` VALUES ('2021n06y24r01s49f06', '2021-06-24', '5', '1');
INSERT INTO `dd` VALUES ('2021n06y24r01s49f12', '2021-06-24', '9', '1');
INSERT INTO `dd` VALUES ('2021n06y24r01s55f22', '2021-06-24', '16', '1');
INSERT INTO `dd` VALUES ('2021n06y24r01s58f34', '2021-06-24', '10', '1');
INSERT INTO `dd` VALUES ('2021n06y24r02s15f10', '2021-06-24', '19', '1');
INSERT INTO `dd` VALUES ('2021n06y24r02s19f31', '2021-06-24', '19', '1');
INSERT INTO `dd` VALUES ('2021n06y24r02s21f07', '2021-06-24', '12', '1');
INSERT INTO `dd` VALUES ('2021n06y24r02s27f37', '2021-06-24', '10', '1');
INSERT INTO `dd` VALUES ('2021n06y24r02s28f39', '2021-06-24', '38', '1');
INSERT INTO `dd` VALUES ('2021n06y24r02s31f45', '2021-06-24', '95', '1');
INSERT INTO `dd` VALUES ('2021n06y28r02s00f27', '2021-06-28', '3', '0');
INSERT INTO `dd` VALUES ('2021n06y28r02s00f52', '2021-06-28', '10', '0');
INSERT INTO `dd` VALUES ('2021n08y11r20s30f01', '2021-08-11', '4', '1');
INSERT INTO `dd` VALUES ('2021n08y11r22s17f30', '2021-08-11', '35', '1');
INSERT INTO `dd` VALUES ('2021n09y16r00s58f36', '2021-09-16', '12', '0');
INSERT INTO `dd` VALUES ('2022n03y15r18s05f09', '2022-03-15', '42', '1');

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `xian` varchar(255) COLLATE utf8_bin DEFAULT '0',
  `user_img` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `token` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', 'admin', '123456789', '1', '/img/user/tx10.jpg', '123ss');
INSERT INTO `user` VALUES ('3', 'cmx', '123456', '1', '/img/user/tx8.jpeg', '321vd');
INSERT INTO `user` VALUES ('4', 'ljk', '123456', '1', '/img/user/tx10.jpg', '418321');
INSERT INTO `user` VALUES ('5', 'sml', '147258', '0', '/img/user/tx6.jpg', '41231');
INSERT INTO `user` VALUES ('7', 'wjd', '666666', '0', '/img/user/tx8.jpeg', '41273');
INSERT INTO `user` VALUES ('9', 'kkk', '44556', '0', '/img/user/tx4.jpg', '28742');
INSERT INTO `user` VALUES ('11', 'qwer', '123', '1', '/img/user/nai5.jpg', 's');
INSERT INTO `user` VALUES ('12', 'asd', '222', '0', '/img/user/back.png', 'oxwew7g02st8');
