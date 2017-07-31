/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50719
Source Host           : localhost:3306
Source Database       : test

Target Server Type    : MYSQL
Target Server Version : 50719
File Encoding         : 65001

Date: 2017-07-31 10:01:20
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for currencies
-- ----------------------------
DROP TABLE IF EXISTS `currencies`;
CREATE TABLE `currencies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `rate` decimal(20,8) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of currencies
-- ----------------------------
INSERT INTO `currencies` VALUES ('1', 'BTC', '1.00000000');
INSERT INTO `currencies` VALUES ('2', 'USD', '0.00300000');
INSERT INTO `currencies` VALUES ('3', 'RUB', '0.00000600');

-- ----------------------------
-- Table structure for offers
-- ----------------------------
DROP TABLE IF EXISTS `offers`;
CREATE TABLE `offers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `pament_method_id` int(11) NOT NULL,
  `min` float NOT NULL,
  `max` float NOT NULL,
  `currency_id` int(11) NOT NULL,
  `margin` decimal(10,0) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id_to_user_id` (`user_id`),
  KEY `payment_id_to_payment` (`pament_method_id`),
  KEY `currency_id_toCurrency` (`currency_id`),
  CONSTRAINT `currency_id_toCurrency` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`),
  CONSTRAINT `payment_id_to_payment` FOREIGN KEY (`pament_method_id`) REFERENCES `payment_methods` (`id`),
  CONSTRAINT `user_id_to_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of offers
-- ----------------------------
INSERT INTO `offers` VALUES ('8', '8', '0', '3', '1', '10', '1', '0');

-- ----------------------------
-- Table structure for payment_method_groups
-- ----------------------------
DROP TABLE IF EXISTS `payment_method_groups`;
CREATE TABLE `payment_method_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of payment_method_groups
-- ----------------------------
INSERT INTO `payment_method_groups` VALUES ('1', 'gift cart');
INSERT INTO `payment_method_groups` VALUES ('2', 'online payments');

-- ----------------------------
-- Table structure for payment_methods
-- ----------------------------
DROP TABLE IF EXISTS `payment_methods`;
CREATE TABLE `payment_methods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `group_id_to_method` (`group_id`),
  CONSTRAINT `group_id_to_method` FOREIGN KEY (`group_id`) REFERENCES `payment_method_groups` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of payment_methods
-- ----------------------------
INSERT INTO `payment_methods` VALUES ('1', '1', 'ms');
INSERT INTO `payment_methods` VALUES ('2', '1', 'boxX');
INSERT INTO `payment_methods` VALUES ('3', '2', 'master card');
INSERT INTO `payment_methods` VALUES ('4', '2', 'visa');

-- ----------------------------
-- Table structure for trades
-- ----------------------------
DROP TABLE IF EXISTS `trades`;
CREATE TABLE `trades` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `offer_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `offer_id_to_offer` (`offer_id`),
  KEY `user_id_to_user` (`user_id`),
  CONSTRAINT `offer_id_to_offer` FOREIGN KEY (`offer_id`) REFERENCES `offers` (`id`),
  CONSTRAINT `user_id_to_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of trades
-- ----------------------------

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `amount` decimal(20,8) NOT NULL DEFAULT '0.00000000',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_username_unique` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('8', 'test', 'test', '7743e8cfd69bbbe7b7732a67a1ba0a10', '0.00000000');
