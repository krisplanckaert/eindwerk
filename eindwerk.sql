/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50150
Source Host           : localhost:3306
Source Database       : eindwerk

Target Server Type    : MYSQL
Target Server Version : 50150
File Encoding         : 65001

Date: 2013-06-14 06:06:19
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `basket`
-- ----------------------------
DROP TABLE IF EXISTS `basket`;
CREATE TABLE `basket` (
  `basketId` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) DEFAULT NULL,
  `productId` int(11) NOT NULL,
  `session` varchar(50) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `creationDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `changeDate` timestamp NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`basketId`),
  KEY `userId` (`userId`),
  KEY `productId` (`productId`),
  CONSTRAINT `basket_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`userId`),
  CONSTRAINT `basket_ibfk_2` FOREIGN KEY (`productId`) REFERENCES `product` (`productId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of basket
-- ----------------------------

-- ----------------------------
-- Table structure for `category`
-- ----------------------------
DROP TABLE IF EXISTS `category`;
CREATE TABLE `category` (
  `categoryId` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(255) NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `creationDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `changeDate` timestamp NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `creationUserId` int(11) NOT NULL,
  `changeUserId` int(11) DEFAULT NULL,
  PRIMARY KEY (`categoryId`),
  KEY `creationUserId` (`creationUserId`),
  KEY `changeUserId` (`changeUserId`),
  CONSTRAINT `category_ibfk_1` FOREIGN KEY (`creationUserId`) REFERENCES `user` (`userId`),
  CONSTRAINT `category_ibfk_2` FOREIGN KEY (`changeUserId`) REFERENCES `user` (`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of category
-- ----------------------------
INSERT INTO `category` VALUES ('1', 'Cat A', 'active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2', null);
INSERT INTO `category` VALUES ('2', 'Cat B', 'active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2', null);

-- ----------------------------
-- Table structure for `categorylocale`
-- ----------------------------
DROP TABLE IF EXISTS `categorylocale`;
CREATE TABLE `categorylocale` (
  `categoryLocaleId` int(11) NOT NULL AUTO_INCREMENT,
  `categoryId` int(11) NOT NULL,
  `localeId` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `translated` tinyint(4) NOT NULL,
  `creationDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `changeDate` timestamp NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `creationUserId` int(11) NOT NULL,
  `changeUserId` int(11) DEFAULT NULL,
  PRIMARY KEY (`categoryLocaleId`),
  KEY `creationUserId` (`creationUserId`),
  KEY `changeUserId` (`changeUserId`),
  KEY `categoryId` (`categoryId`),
  CONSTRAINT `categorylocale_ibfk_2` FOREIGN KEY (`creationUserId`) REFERENCES `user` (`userId`),
  CONSTRAINT `categorylocale_ibfk_3` FOREIGN KEY (`changeUserId`) REFERENCES `user` (`userId`),
  CONSTRAINT `categorylocale_ibfk_4` FOREIGN KEY (`categoryId`) REFERENCES `category` (`categoryId`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of categorylocale
-- ----------------------------
INSERT INTO `categorylocale` VALUES ('1', '1', '1', 'Categorie A', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2', null);
INSERT INTO `categorylocale` VALUES ('2', '1', '2', 'Category A', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2', null);
INSERT INTO `categorylocale` VALUES ('3', '2', '1', 'Categorie B', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2', null);
INSERT INTO `categorylocale` VALUES ('4', '2', '2', 'Category B', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2', null);

-- ----------------------------
-- Table structure for `categoryproduct`
-- ----------------------------
DROP TABLE IF EXISTS `categoryproduct`;
CREATE TABLE `categoryproduct` (
  `categoryProductId` int(11) NOT NULL AUTO_INCREMENT,
  `categoryId` int(11) NOT NULL,
  `productId` int(11) NOT NULL,
  `creationDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `changeDate` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `creationUserId` int(11) NOT NULL,
  `changeUserId` int(11) DEFAULT NULL,
  PRIMARY KEY (`categoryProductId`),
  KEY `productId` (`productId`),
  KEY `creationUserId` (`creationUserId`),
  KEY `changeUserId` (`changeUserId`),
  KEY `categoryId` (`categoryId`),
  CONSTRAINT `categoryproduct_ibfk_2` FOREIGN KEY (`productId`) REFERENCES `product` (`productId`),
  CONSTRAINT `categoryproduct_ibfk_3` FOREIGN KEY (`creationUserId`) REFERENCES `user` (`userId`),
  CONSTRAINT `categoryproduct_ibfk_4` FOREIGN KEY (`changeUserId`) REFERENCES `user` (`userId`),
  CONSTRAINT `categoryproduct_ibfk_5` FOREIGN KEY (`categoryId`) REFERENCES `category` (`categoryId`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of categoryproduct
-- ----------------------------
INSERT INTO `categoryproduct` VALUES ('1', '1', '1', '0000-00-00 00:00:00', null, '2', null);
INSERT INTO `categoryproduct` VALUES ('2', '1', '2', '0000-00-00 00:00:00', null, '2', null);
INSERT INTO `categoryproduct` VALUES ('3', '2', '3', '0000-00-00 00:00:00', null, '2', null);
INSERT INTO `categoryproduct` VALUES ('4', '2', '4', '0000-00-00 00:00:00', null, '2', null);

-- ----------------------------
-- Table structure for `currency`
-- ----------------------------
DROP TABLE IF EXISTS `currency`;
CREATE TABLE `currency` (
  `currencyId` int(11) NOT NULL AUTO_INCREMENT,
  `factor` float(11,4) DEFAULT NULL,
  `basecurrencyId` int(11) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `short` varchar(255) NOT NULL,
  `creationUserId` int(11) DEFAULT NULL,
  `changeUserId` int(11) DEFAULT NULL,
  `creationDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  ` changeDate` timestamp NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`currencyId`),
  KEY `creationUserId` (`creationUserId`),
  KEY `changeUserId` (`changeUserId`),
  CONSTRAINT `currency_ibfk_1` FOREIGN KEY (`creationUserId`) REFERENCES `user` (`userId`),
  CONSTRAINT `currency_ibfk_2` FOREIGN KEY (`changeUserId`) REFERENCES `user` (`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of currency
-- ----------------------------
INSERT INTO `currency` VALUES ('1', '1.0000', null, 'EURO', 'EUR', '1', null, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `currency` VALUES ('2', '1.2000', '1', 'Dollar', '$', '1', null, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- ----------------------------
-- Table structure for `locale`
-- ----------------------------
DROP TABLE IF EXISTS `locale`;
CREATE TABLE `locale` (
  `localeId` int(11) NOT NULL AUTO_INCREMENT,
  `locale` varchar(255) NOT NULL,
  `short` varchar(255) DEFAULT NULL,
  `creationUserId` int(11) NOT NULL,
  `changeUserId` int(11) DEFAULT NULL,
  `creationDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `changeDate` timestamp NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`localeId`),
  KEY `creationUserId` (`creationUserId`),
  KEY `changeUserId` (`changeUserId`),
  CONSTRAINT `locale_ibfk_1` FOREIGN KEY (`creationUserId`) REFERENCES `user` (`userId`),
  CONSTRAINT `locale_ibfk_2` FOREIGN KEY (`changeUserId`) REFERENCES `user` (`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of locale
-- ----------------------------
INSERT INTO `locale` VALUES ('1', 'nl_BE', 'NL', '2', null, '0000-00-00 00:00:00', '2013-06-13 08:54:25');
INSERT INTO `locale` VALUES ('2', 'en_US', 'EN', '2', null, '0000-00-00 00:00:00', '2013-06-13 08:54:27');

-- ----------------------------
-- Table structure for `menu`
-- ----------------------------
DROP TABLE IF EXISTS `menu`;
CREATE TABLE `menu` (
  `menuId` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(255) DEFAULT NULL,
  `action` varchar(255) NOT NULL,
  `controller` varchar(255) NOT NULL,
  `module` varchar(255) NOT NULL DEFAULT 'default',
  `slug` varchar(255) NOT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `creationUserId` int(11) NOT NULL,
  `changeUserId` int(11) DEFAULT NULL,
  `creationDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `changeDate` timestamp NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`menuId`),
  KEY `creationUserId` (`creationUserId`),
  KEY `changeUserId` (`changeUserId`),
  CONSTRAINT `menu_ibfk_1` FOREIGN KEY (`creationUserId`) REFERENCES `user` (`userId`),
  CONSTRAINT `menu_ibfk_2` FOREIGN KEY (`changeUserId`) REFERENCES `user` (`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of menu
-- ----------------------------
INSERT INTO `menu` VALUES ('1', 'home', 'index', 'index', 'default', 'home', '1', '1', null, '0000-00-00 00:00:00', '2013-06-12 16:19:26');
INSERT INTO `menu` VALUES ('2', 'basket', 'index', 'basket', 'default', 'basket', '1', '1', null, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `menu` VALUES ('3', 'highlight', 'highlight', 'index', 'default', 'highlight', '1', '1', null, '0000-00-00 00:00:00', '2013-06-13 21:27:38');
INSERT INTO `menu` VALUES ('4', 'menu', 'index', 'menu', 'admin', 'menu', '1', '1', null, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `menu` VALUES ('5', 'role', 'index', 'role', 'admin', 'role', '1', '1', null, '0000-00-00 00:00:00', '2013-06-13 21:47:34');
