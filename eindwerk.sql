/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50150
Source Host           : localhost:3306
Source Database       : eindwerk

Target Server Type    : MYSQL
Target Server Version : 50150
File Encoding         : 65001

Date: 2013-06-15 17:29:16
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

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
  `status` tinyint(4) NOT NULL DEFAULT '1',
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
INSERT INTO `category` VALUES ('1', 'Cat A', '1', '0000-00-00 00:00:00', '2013-06-15 17:26:39', '2', '2');
INSERT INTO `category` VALUES ('2', 'Cat B', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2', null);

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
  UNIQUE KEY `categoryId` (`categoryId`,`localeId`),
  KEY `creationUserId` (`creationUserId`),
  KEY `changeUserId` (`changeUserId`),
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
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of categoryproduct
-- ----------------------------
INSERT INTO `categoryproduct` VALUES ('3', '2', '3', '0000-00-00 00:00:00', null, '2', null);
INSERT INTO `categoryproduct` VALUES ('4', '2', '4', '0000-00-00 00:00:00', null, '2', null);
INSERT INTO `categoryproduct` VALUES ('16', '1', '1', '2013-06-15 17:26:39', null, '2', null);
INSERT INTO `categoryproduct` VALUES ('17', '1', '2', '2013-06-15 17:26:39', null, '2', null);

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
  `status` tinyint(4) DEFAULT '1',
  `creationUserId` int(11) NOT NULL,
  `changeUserId` int(11) DEFAULT NULL,
  `creationDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `changeDate` timestamp NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`menuId`),
  KEY `creationUserId` (`creationUserId`),
  KEY `changeUserId` (`changeUserId`),
  CONSTRAINT `menu_ibfk_1` FOREIGN KEY (`creationUserId`) REFERENCES `user` (`userId`),
  CONSTRAINT `menu_ibfk_2` FOREIGN KEY (`changeUserId`) REFERENCES `user` (`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of menu
-- ----------------------------
INSERT INTO `menu` VALUES ('1', 'home', 'index', 'index', 'default', 'home', '1', '1', '2', '0000-00-00 00:00:00', '2013-06-15 11:48:18');
INSERT INTO `menu` VALUES ('2', 'basket', 'list', 'basket', 'default', 'basket', '1', '1', '2', '0000-00-00 00:00:00', '2013-06-15 16:29:47');
INSERT INTO `menu` VALUES ('3', 'highlight', 'highlight', 'index', 'default', 'highlight', '1', '1', '2', '0000-00-00 00:00:00', '2013-06-15 11:48:40');
INSERT INTO `menu` VALUES ('4', 'menu', 'list', 'menu', 'admin', 'menu', '1', '1', '2', '0000-00-00 00:00:00', '2013-06-15 11:48:49');
INSERT INTO `menu` VALUES ('17', 'photo', 'list', 'photo', 'dealer', 'photo', null, '2', '2', '2013-06-15 11:30:08', '2013-06-15 11:48:53');
INSERT INTO `menu` VALUES ('18', 'product', 'list', 'product', 'dealer', 'product', null, '2', '2', '2013-06-15 11:31:42', '2013-06-15 11:48:56');
INSERT INTO `menu` VALUES ('20', 'category', 'list', 'category', 'dealer', 'category', '1', '2', null, '2013-06-15 17:16:07', '0000-00-00 00:00:00');

-- ----------------------------
-- Table structure for `menulocale`
-- ----------------------------
DROP TABLE IF EXISTS `menulocale`;
CREATE TABLE `menulocale` (
  `menuLocaleId` int(11) NOT NULL AUTO_INCREMENT,
  `menuId` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `localeId` int(11) NOT NULL,
  `translated` tinyint(4) DEFAULT NULL,
  `creationUserId` int(11) NOT NULL,
  `changeUserId` int(11) DEFAULT NULL,
  `creationDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `changeDate` timestamp NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`menuLocaleId`),
  UNIQUE KEY `menuId_2` (`menuId`,`localeId`),
  KEY `menuId` (`menuId`),
  KEY `creationUserId` (`creationUserId`),
  KEY `changeUserId` (`changeUserId`),
  CONSTRAINT `menulocale_ibfk_2` FOREIGN KEY (`creationUserId`) REFERENCES `user` (`userId`),
  CONSTRAINT `menulocale_ibfk_3` FOREIGN KEY (`changeUserId`) REFERENCES `user` (`userId`),
  CONSTRAINT `menulocale_ibfk_4` FOREIGN KEY (`menuId`) REFERENCES `menu` (`menuId`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of menulocale
-- ----------------------------
INSERT INTO `menulocale` VALUES ('3', '1', 'Home', '1', '1', '2', '2', '0000-00-00 00:00:00', '2013-06-15 11:48:18');
INSERT INTO `menulocale` VALUES ('4', '1', 'Home', '2', '1', '2', '2', '0000-00-00 00:00:00', '2013-06-15 11:48:18');
INSERT INTO `menulocale` VALUES ('5', '2', 'Winkelmand', '1', '1', '2', '2', '0000-00-00 00:00:00', '2013-06-15 16:29:47');
INSERT INTO `menulocale` VALUES ('6', '2', 'Basket', '2', '1', '2', '2', '0000-00-00 00:00:00', '2013-06-15 16:29:47');
INSERT INTO `menulocale` VALUES ('7', '3', 'In de kijker', '1', '1', '2', '2', '0000-00-00 00:00:00', '2013-06-15 11:48:40');
INSERT INTO `menulocale` VALUES ('8', '3', 'Highlight', '2', '1', '2', '2', '0000-00-00 00:00:00', '2013-06-15 11:48:40');
INSERT INTO `menulocale` VALUES ('9', '4', 'Menu', '1', '1', '2', '2', '0000-00-00 00:00:00', '2013-06-15 11:48:49');
INSERT INTO `menulocale` VALUES ('10', '4', 'Menu', '2', '1', '2', '2', '0000-00-00 00:00:00', '2013-06-15 11:48:49');
INSERT INTO `menulocale` VALUES ('13', '2', '', '3', '1', '2', null, '2013-06-14 21:06:57', '0000-00-00 00:00:00');
INSERT INTO `menulocale` VALUES ('34', '17', 'Foto', '1', '1', '2', '2', '2013-06-15 11:30:08', '2013-06-15 11:48:53');
INSERT INTO `menulocale` VALUES ('35', '17', 'Photo', '2', '1', '2', '2', '2013-06-15 11:30:08', '2013-06-15 11:48:53');
INSERT INTO `menulocale` VALUES ('36', '18', 'Product', '1', '1', '2', '2', '2013-06-15 11:31:42', '2013-06-15 11:48:56');
INSERT INTO `menulocale` VALUES ('37', '18', 'Product', '2', '1', '2', '2', '2013-06-15 11:31:42', '2013-06-15 11:48:56');
INSERT INTO `menulocale` VALUES ('40', '20', 'Categorie', '1', '1', '2', null, '2013-06-15 17:16:07', '0000-00-00 00:00:00');
INSERT INTO `menulocale` VALUES ('41', '20', 'Category', '2', '1', '2', null, '2013-06-15 17:16:07', '0000-00-00 00:00:00');

-- ----------------------------
-- Table structure for `menurole`
-- ----------------------------
DROP TABLE IF EXISTS `menurole`;
CREATE TABLE `menurole` (
  `menuroleId` int(11) NOT NULL AUTO_INCREMENT,
  `menuId` int(11) NOT NULL,
  `roleId` int(11) NOT NULL,
  `creationDate` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `changeDate` timestamp NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `creationUserId` int(11) DEFAULT NULL,
  `changeUserId` int(11) DEFAULT NULL,
  PRIMARY KEY (`menuroleId`),
  KEY `roleId` (`roleId`),
  KEY `creationUserId` (`creationUserId`),
  KEY `changeUserId` (`changeUserId`),
  KEY `menurole_ibfk_1` (`menuId`),
  CONSTRAINT `menurole_ibfk_1` FOREIGN KEY (`menuId`) REFERENCES `menu` (`menuId`) ON DELETE CASCADE,
  CONSTRAINT `menurole_ibfk_2` FOREIGN KEY (`roleId`) REFERENCES `role` (`roleId`),
  CONSTRAINT `menurole_ibfk_3` FOREIGN KEY (`creationUserId`) REFERENCES `user` (`userId`),
  CONSTRAINT `menurole_ibfk_4` FOREIGN KEY (`changeUserId`) REFERENCES `user` (`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of menurole
-- ----------------------------
INSERT INTO `menurole` VALUES ('1', '1', '1', '0000-00-00 00:00:00', '2013-06-12 16:19:48', '2', null);
INSERT INTO `menurole` VALUES ('3', '1', '4', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2', null);
INSERT INTO `menurole` VALUES ('5', '3', '1', '0000-00-00 00:00:00', '2013-06-13 21:25:40', '2', null);
INSERT INTO `menurole` VALUES ('6', '3', '4', '0000-00-00 00:00:00', '2013-06-13 21:25:41', '2', null);
INSERT INTO `menurole` VALUES ('7', '4', '4', '0000-00-00 00:00:00', '2013-06-13 21:36:46', '2', null);
INSERT INTO `menurole` VALUES ('12', '2', '1', '2013-06-14 21:23:03', '0000-00-00 00:00:00', '2', null);
INSERT INTO `menurole` VALUES ('13', '2', '3', '2013-06-14 21:29:27', '0000-00-00 00:00:00', '2', null);
INSERT INTO `menurole` VALUES ('19', '17', '3', '2013-06-15 11:30:08', '0000-00-00 00:00:00', '2', null);
INSERT INTO `menurole` VALUES ('20', '17', '4', '2013-06-15 11:30:08', '0000-00-00 00:00:00', '2', null);
INSERT INTO `menurole` VALUES ('21', '18', '3', '2013-06-15 11:31:42', '0000-00-00 00:00:00', '2', null);
INSERT INTO `menurole` VALUES ('22', '18', '4', '2013-06-15 11:31:42', '0000-00-00 00:00:00', '2', null);
INSERT INTO `menurole` VALUES ('23', '1', '2', '2013-06-15 11:48:18', '0000-00-00 00:00:00', '2', null);
INSERT INTO `menurole` VALUES ('24', '1', '3', '2013-06-15 11:48:18', '0000-00-00 00:00:00', '2', null);
INSERT INTO `menurole` VALUES ('25', '2', '2', '2013-06-15 11:48:25', '0000-00-00 00:00:00', '2', null);
INSERT INTO `menurole` VALUES ('27', '3', '2', '2013-06-15 11:48:40', '0000-00-00 00:00:00', '2', null);
INSERT INTO `menurole` VALUES ('28', '3', '3', '2013-06-15 11:48:40', '0000-00-00 00:00:00', '2', null);
INSERT INTO `menurole` VALUES ('31', '2', '4', '2013-06-15 16:23:35', '0000-00-00 00:00:00', '2', null);
INSERT INTO `menurole` VALUES ('32', '20', '3', '2013-06-15 17:16:07', '0000-00-00 00:00:00', '2', null);
INSERT INTO `menurole` VALUES ('33', '20', '4', '2013-06-15 17:16:07', '0000-00-00 00:00:00', '2', null);

-- ----------------------------
-- Table structure for `order`
-- ----------------------------
DROP TABLE IF EXISTS `order`;
CREATE TABLE `order` (
  `orderId` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `creationDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `changeDate` timestamp NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `creationUserId` int(11) NOT NULL,
  `changeUserId` int(11) DEFAULT NULL,
  PRIMARY KEY (`orderId`,`userId`),
  KEY `userId` (`userId`),
  KEY `creationUserId` (`creationUserId`),
  KEY `changeUserId` (`changeUserId`),
  KEY `orderId` (`orderId`),
  CONSTRAINT `order_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`userId`),
  CONSTRAINT `order_ibfk_2` FOREIGN KEY (`creationUserId`) REFERENCES `user` (`userId`),
  CONSTRAINT `order_ibfk_3` FOREIGN KEY (`changeUserId`) REFERENCES `user` (`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of order
-- ----------------------------

-- ----------------------------
-- Table structure for `orderdetail`
-- ----------------------------
DROP TABLE IF EXISTS `orderdetail`;
CREATE TABLE `orderdetail` (
  `orderDetailId` int(11) NOT NULL AUTO_INCREMENT,
  `productId` int(11) NOT NULL,
  `orderId` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` float(11,2) NOT NULL,
  `creationDate` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `changeDate` timestamp NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `creationUserId` int(11) DEFAULT NULL,
  `changeUserId` int(11) DEFAULT NULL,
  PRIMARY KEY (`orderDetailId`),
  KEY `productId` (`productId`),
  KEY `orderId` (`orderId`),
  KEY `creationUserId` (`creationUserId`),
  KEY `changeUserId` (`changeUserId`),
  CONSTRAINT `orderdetail_ibfk_1` FOREIGN KEY (`productId`) REFERENCES `product` (`productId`),
  CONSTRAINT `orderdetail_ibfk_2` FOREIGN KEY (`orderId`) REFERENCES `order` (`orderId`),
  CONSTRAINT `orderdetail_ibfk_4` FOREIGN KEY (`creationUserId`) REFERENCES `user` (`userId`),
  CONSTRAINT `orderdetail_ibfk_5` FOREIGN KEY (`changeUserId`) REFERENCES `user` (`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of orderdetail
-- ----------------------------

-- ----------------------------
-- Table structure for `page`
-- ----------------------------
DROP TABLE IF EXISTS `page`;
CREATE TABLE `page` (
  `pageId` int(11) NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `label` varchar(255) NOT NULL,
  `creationDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `changeDate` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `creationUserId` int(11) NOT NULL,
  `changeUserId` int(11) DEFAULT NULL,
  PRIMARY KEY (`pageId`),
  KEY `creationUserId` (`creationUserId`),
  KEY `changeUserId` (`changeUserId`),
  CONSTRAINT `page_ibfk_1` FOREIGN KEY (`creationUserId`) REFERENCES `user` (`userId`),
  CONSTRAINT `page_ibfk_2` FOREIGN KEY (`changeUserId`) REFERENCES `user` (`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of page
-- ----------------------------
INSERT INTO `page` VALUES ('1', 'about', '1', 'about', '0000-00-00 00:00:00', null, '2', null);
INSERT INTO `page` VALUES ('2', 'dislaimer', '1', 'disclaimer', '0000-00-00 00:00:00', null, '2', null);

-- ----------------------------
-- Table structure for `pagelocale`
-- ----------------------------
DROP TABLE IF EXISTS `pagelocale`;
CREATE TABLE `pagelocale` (
  `pageLocaleId` int(11) NOT NULL AUTO_INCREMENT,
  `pageId` int(11) NOT NULL,
  `localeId` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `traslated` tinyint(4) NOT NULL,
  `creationDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `changeDate` timestamp NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `creationUserId` int(11) NOT NULL,
  `changeUserId` int(11) DEFAULT NULL,
  PRIMARY KEY (`pageLocaleId`),
  UNIQUE KEY `pageId` (`pageId`,`localeId`),
  KEY `creationUserId` (`creationUserId`),
  KEY `changeUserId` (`changeUserId`),
  KEY `localeId` (`localeId`),
  CONSTRAINT `pagelocale_ibfk_1` FOREIGN KEY (`pageId`) REFERENCES `page` (`pageId`),
  CONSTRAINT `pagelocale_ibfk_3` FOREIGN KEY (`creationUserId`) REFERENCES `user` (`userId`),
  CONSTRAINT `pagelocale_ibfk_4` FOREIGN KEY (`changeUserId`) REFERENCES `user` (`userId`),
  CONSTRAINT `pagelocale_ibfk_5` FOREIGN KEY (`localeId`) REFERENCES `locale` (`localeId`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pagelocale
-- ----------------------------
INSERT INTO `pagelocale` VALUES ('1', '1', '1', 'about titel', 'about description', '1', '0000-00-00 00:00:00', '2013-06-13 21:23:34', '2', null);
INSERT INTO `pagelocale` VALUES ('2', '1', '2', 'about title', 'about description', '1', '0000-00-00 00:00:00', '2013-06-13 21:23:20', '2', null);
INSERT INTO `pagelocale` VALUES ('3', '2', '1', 'disclaimer', 'disclaimer', '1', '0000-00-00 00:00:00', '2013-06-13 19:28:25', '2', null);
INSERT INTO `pagelocale` VALUES ('4', '2', '2', 'disclaimer', 'disclaimer', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2', null);

-- ----------------------------
-- Table structure for `photo`
-- ----------------------------
DROP TABLE IF EXISTS `photo`;
CREATE TABLE `photo` (
  `photoId` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(255) NOT NULL,
  `fileName` varchar(250) NOT NULL,
  `fileNameOrig` varchar(250) DEFAULT NULL,
  `screenName` varchar(250) DEFAULT NULL,
  `mimeType` varchar(80) DEFAULT NULL,
  `fileSize` int(11) DEFAULT NULL,
  `filePath` text,
  `identifier` int(11) DEFAULT NULL,
  `thumb` varchar(250) DEFAULT NULL,
  `creationDate` int(10) DEFAULT NULL,
  `lastUpdate` int(10) DEFAULT NULL,
  PRIMARY KEY (`photoId`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of photo
-- ----------------------------
INSERT INTO `photo` VALUES ('19', 'koe', 'koe.jpg', null, null, null, null, null, null, null, null, null);

-- ----------------------------
-- Table structure for `photolocale`
-- ----------------------------
DROP TABLE IF EXISTS `photolocale`;
CREATE TABLE `photolocale` (
  `photoLocaleId` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `teaser` varchar(255) DEFAULT NULL,
  `photoId` int(11) NOT NULL,
  `localeId` int(11) NOT NULL,
  `translated` tinyint(4) NOT NULL,
  `creationDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `changeDate` timestamp NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `creationUserId` int(11) NOT NULL,
  `changeUserId` int(11) DEFAULT NULL,
  PRIMARY KEY (`photoLocaleId`),
  UNIQUE KEY `photoId` (`photoId`,`localeId`),
  KEY `localeId` (`localeId`),
  KEY `creationUserId` (`creationUserId`),
  KEY `changeUserId` (`changeUserId`),
  CONSTRAINT `photolocale_ibfk_1` FOREIGN KEY (`photoId`) REFERENCES `photo` (`photoId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `photolocale_ibfk_2` FOREIGN KEY (`localeId`) REFERENCES `locale` (`localeId`),
  CONSTRAINT `photolocale_ibfk_3` FOREIGN KEY (`creationUserId`) REFERENCES `user` (`userId`),
  CONSTRAINT `photolocale_ibfk_4` FOREIGN KEY (`changeUserId`) REFERENCES `user` (`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of photolocale
-- ----------------------------
INSERT INTO `photolocale` VALUES ('11', 'koe2', 'Koe in de wei2', '19', '1', '1', '2013-06-15 09:46:43', '2013-06-15 11:30:34', '2', '2');
INSERT INTO `photolocale` VALUES ('12', 'Cow2', 'Cow in the meadow2', '19', '2', '1', '2013-06-15 09:46:43', '2013-06-15 11:30:34', '2', '2');

-- ----------------------------
-- Table structure for `product`
-- ----------------------------
DROP TABLE IF EXISTS `product`;
CREATE TABLE `product` (
  `productId` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `price` float(11,4) NOT NULL,
  `highlight` tinyint(4) NOT NULL,
  `creationDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `changeDate` timestamp NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `creationUserId` int(11) NOT NULL,
  `changeUserId` int(11) DEFAULT NULL,
  PRIMARY KEY (`productId`),
  KEY `creationUserId` (`creationUserId`),
  KEY `changeUserId` (`changeUserId`),
  CONSTRAINT `product_ibfk_2` FOREIGN KEY (`creationUserId`) REFERENCES `user` (`userId`),
  CONSTRAINT `product_ibfk_3` FOREIGN KEY (`changeUserId`) REFERENCES `user` (`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of product
-- ----------------------------
INSERT INTO `product` VALUES ('1', 'product A', '1', '11.0000', '1', '0000-00-00 00:00:00', '2013-06-15 16:20:40', '2', '2');
INSERT INTO `product` VALUES ('2', 'product B', '1', '11.0000', '0', '0000-00-00 00:00:00', '2013-06-15 16:16:30', '2', '2');
INSERT INTO `product` VALUES ('3', 'product C', '1', '12.0000', '1', '0000-00-00 00:00:00', '2013-06-13 21:31:48', '2', null);
INSERT INTO `product` VALUES ('4', 'product D', '1', '13.0000', '0', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2', null);

-- ----------------------------
-- Table structure for `productlocale`
-- ----------------------------
DROP TABLE IF EXISTS `productlocale`;
CREATE TABLE `productlocale` (
  `productLocaleId` int(11) NOT NULL AUTO_INCREMENT,
  `productId` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `teaser` varchar(255) NOT NULL,
  `content` varchar(255) NOT NULL,
  `localeId` int(11) NOT NULL,
  `translated` tinyint(4) NOT NULL,
  `creationDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `changeDate` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `creationUserId` int(11) NOT NULL,
  `changeUserId` int(11) DEFAULT NULL,
  PRIMARY KEY (`productLocaleId`),
  UNIQUE KEY `productId` (`productId`,`localeId`),
  KEY `localeId` (`localeId`),
  KEY `creationUserId` (`creationUserId`),
  KEY `changeUserId` (`changeUserId`),
  CONSTRAINT `productlocale_ibfk_1` FOREIGN KEY (`productId`) REFERENCES `product` (`productId`),
  CONSTRAINT `productlocale_ibfk_2` FOREIGN KEY (`localeId`) REFERENCES `locale` (`localeId`),
  CONSTRAINT `productlocale_ibfk_3` FOREIGN KEY (`creationUserId`) REFERENCES `user` (`userId`),
  CONSTRAINT `productlocale_ibfk_4` FOREIGN KEY (`changeUserId`) REFERENCES `user` (`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of productlocale
-- ----------------------------

-- ----------------------------
-- Table structure for `productphoto`
-- ----------------------------
DROP TABLE IF EXISTS `productphoto`;
CREATE TABLE `productphoto` (
  `productPhotoId` int(11) NOT NULL AUTO_INCREMENT,
  `productId` int(11) NOT NULL,
  `photoId` int(11) NOT NULL,
  `creationDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `changeDate` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `creationUserId` int(11) NOT NULL,
  `changeUserId` int(11) DEFAULT NULL,
  PRIMARY KEY (`productPhotoId`),
  KEY `productId` (`productId`),
  KEY `photoId` (`photoId`),
  KEY `creationUserId` (`creationUserId`),
  KEY `changeUserId` (`changeUserId`),
  CONSTRAINT `productphoto_ibfk_1` FOREIGN KEY (`productId`) REFERENCES `product` (`productId`),
  CONSTRAINT `productphoto_ibfk_2` FOREIGN KEY (`photoId`) REFERENCES `photo` (`photoId`),
  CONSTRAINT `productphoto_ibfk_3` FOREIGN KEY (`creationUserId`) REFERENCES `user` (`userId`),
  CONSTRAINT `productphoto_ibfk_4` FOREIGN KEY (`changeUserId`) REFERENCES `user` (`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of productphoto
-- ----------------------------
INSERT INTO `productphoto` VALUES ('6', '2', '19', '2013-06-15 16:16:30', null, '2', null);
INSERT INTO `productphoto` VALUES ('9', '1', '19', '2013-06-15 16:20:40', null, '2', null);

-- ----------------------------
-- Table structure for `role`
-- ----------------------------
DROP TABLE IF EXISTS `role`;
CREATE TABLE `role` (
  `roleId` int(11) NOT NULL AUTO_INCREMENT,
  `role` varchar(255) NOT NULL,
  `creationDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `changeDate` timestamp NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `creationUserId` int(11) NOT NULL,
  `changeUserId` int(11) DEFAULT NULL,
  PRIMARY KEY (`roleId`),
  KEY `creationUserId` (`creationUserId`),
  KEY `changeUserId` (`changeUserId`),
  CONSTRAINT `role_ibfk_1` FOREIGN KEY (`creationUserId`) REFERENCES `user` (`userId`),
  CONSTRAINT `role_ibfk_2` FOREIGN KEY (`changeUserId`) REFERENCES `user` (`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of role
-- ----------------------------
INSERT INTO `role` VALUES ('1', 'GUEST', '0000-00-00 00:00:00', '2013-06-12 09:07:19', '1', null);
INSERT INTO `role` VALUES ('2', 'USER', '0000-00-00 00:00:00', '2013-06-12 09:07:19', '1', null);
INSERT INTO `role` VALUES ('3', 'DEALER', '0000-00-00 00:00:00', '2013-06-12 09:07:19', '1', null);
INSERT INTO `role` VALUES ('4', 'ADMIN', '0000-00-00 00:00:00', '2013-06-12 09:07:20', '1', null);

-- ----------------------------
-- Table structure for `translate`
-- ----------------------------
DROP TABLE IF EXISTS `translate`;
CREATE TABLE `translate` (
  `translateId` int(11) NOT NULL AUTO_INCREMENT,
  `localeId` int(11) NOT NULL,
  `tag` varchar(50) NOT NULL,
  `translation` varchar(50) NOT NULL,
  `translated` tinyint(4) NOT NULL,
  PRIMARY KEY (`translateId`),
  KEY `localeId` (`localeId`),
  CONSTRAINT `translate_ibfk_1` FOREIGN KEY (`localeId`) REFERENCES `locale` (`localeId`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of translate
-- ----------------------------
INSERT INTO `translate` VALUES ('3', '1', 'lbl_Naam', 'Naam', '1');
INSERT INTO `translate` VALUES ('4', '2', 'lbl_Naam', 'Name', '1');
INSERT INTO `translate` VALUES ('5', '1', 'lbl_Wachtwoord', 'Wachtwoord', '1');
INSERT INTO `translate` VALUES ('6', '2', 'lbl_Wachtwoord', 'Password', '1');
INSERT INTO `translate` VALUES ('7', '1', 'lbl_Hier kan je inloggen', 'Hier kan je inloggen', '1');
INSERT INTO `translate` VALUES ('8', '2', 'lbl_Hier kan je inloggen', 'Sign up here', '1');
INSERT INTO `translate` VALUES ('9', '1', 'lbl_Bedankt om in te loggen', 'Bedankt om in te loggen', '1');
INSERT INTO `translate` VALUES ('10', '2', 'lbl_Bedankt om in te loggen', 'Thank you for the log in', '1');
INSERT INTO `translate` VALUES ('11', '1', 'lbl_Welkom', 'Welkom', '1');
INSERT INTO `translate` VALUES ('12', '2', 'lbl_Welkom', 'Welcome', '1');
INSERT INTO `translate` VALUES ('13', '1', 'prijs', 'prijs', '1');
INSERT INTO `translate` VALUES ('14', '2', 'prijs', 'price', '1');
INSERT INTO `translate` VALUES ('15', '1', 'Aantal', 'Aantal', '1');
INSERT INTO `translate` VALUES ('16', '2', 'Aantal', 'Quantity', '1');
INSERT INTO `translate` VALUES ('17', '1', 'toevoegen', 'toevoegen', '1');
INSERT INTO `translate` VALUES ('18', '2', 'toevoegen', 'add', '1');
INSERT INTO `translate` VALUES ('19', '1', 'Winkelmand overzicht', 'Winkelmand overzicht', '1');
INSERT INTO `translate` VALUES ('20', '2', 'Winkelmand overzicht', 'Basket overview', '1');
INSERT INTO `translate` VALUES ('21', '1', 'delete', 'Verwijderen', '1');
INSERT INTO `translate` VALUES ('22', '2', 'delete', 'Delete', '1');
INSERT INTO `translate` VALUES ('23', '1', 'Menus overzicht', 'Menus overzicht', '1');
INSERT INTO `translate` VALUES ('24', '2', 'Menus overzicht', 'Menu overview', '1');
INSERT INTO `translate` VALUES ('25', '1', 'Filename', 'Bestandsnaam', '1');
INSERT INTO `translate` VALUES ('26', '2', 'Filename', 'Filename', '1');

-- ----------------------------
-- Table structure for `user`
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `userId` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `roleId` int(11) NOT NULL,
  `creationDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `changeDate` timestamp NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `creationUserId` int(11) NOT NULL,
  `changeUserId` int(11) DEFAULT NULL,
  PRIMARY KEY (`userId`),
  KEY `roleId` (`roleId`),
  KEY `creationUserId` (`creationUserId`),
  KEY `changeUserId` (`changeUserId`),
  CONSTRAINT `user_ibfk_1` FOREIGN KEY (`roleId`) REFERENCES `role` (`roleId`),
  CONSTRAINT `user_ibfk_2` FOREIGN KEY (`creationUserId`) REFERENCES `user` (`userId`),
  CONSTRAINT `user_ibfk_3` FOREIGN KEY (`changeUserId`) REFERENCES `user` (`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', 'kris.planckaert@winsol.eu', '03e13700e25563c0c0a8ffdb48dbbc19', 'kris', 'active', '4', '0000-00-00 00:00:00', '2013-06-12 12:40:36', '1', null);
INSERT INTO `user` VALUES ('2', 'thomas.vanhuysse@winsol.eu', 'ef6e65efc188e7dffd7335b646a85a21', 'thomas', 'active', '3', '0000-00-00 00:00:00', '2013-06-12 12:40:43', '1', null);
INSERT INTO `user` VALUES ('3', 'xavier@dxsolutions.be', '0f5366b3b19afc3184d23bc73d8cd311', 'xavier', 'active', '2', '0000-00-00 00:00:00', '2013-06-12 12:40:52', '1', null);
