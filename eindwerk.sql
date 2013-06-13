/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50150
Source Host           : localhost:3306
Source Database       : eindwerk

Target Server Type    : MYSQL
Target Server Version : 50150
File Encoding         : 65001

Date: 2013-06-13 06:19:41
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
  `categorieId` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(255) NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `creationDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `changeDate` timestamp NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `creationUserId` int(11) NOT NULL,
  `changeUserId` int(11) DEFAULT NULL,
  PRIMARY KEY (`categorieId`),
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
  `categorylocaleId` int(11) NOT NULL AUTO_INCREMENT,
  `categoryId` int(11) NOT NULL,
  `localeId` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `translated` tinyint(4) NOT NULL,
  `creationDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `changeDate` timestamp NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `creationUserId` int(11) NOT NULL,
  `changeUserId` int(11) DEFAULT NULL,
  PRIMARY KEY (`categorylocaleId`),
  KEY `categoryId` (`categoryId`),
  KEY `creationUserId` (`creationUserId`),
  KEY `changeUserId` (`changeUserId`),
  CONSTRAINT `categorylocale_ibfk_1` FOREIGN KEY (`categoryId`) REFERENCES `category` (`categorieId`),
  CONSTRAINT `categorylocale_ibfk_2` FOREIGN KEY (`creationUserId`) REFERENCES `user` (`userId`),
  CONSTRAINT `categorylocale_ibfk_3` FOREIGN KEY (`changeUserId`) REFERENCES `user` (`userId`)
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
  KEY `categoryId` (`categoryId`),
  KEY `productId` (`productId`),
  KEY `creationUserId` (`creationUserId`),
  KEY `changeUserId` (`changeUserId`),
  CONSTRAINT `categoryproduct_ibfk_1` FOREIGN KEY (`categoryId`) REFERENCES `category` (`categorieId`),
  CONSTRAINT `categoryproduct_ibfk_2` FOREIGN KEY (`productId`) REFERENCES `product` (`productId`),
  CONSTRAINT `categoryproduct_ibfk_3` FOREIGN KEY (`creationUserId`) REFERENCES `user` (`userId`),
  CONSTRAINT `categoryproduct_ibfk_4` FOREIGN KEY (`changeUserId`) REFERENCES `user` (`userId`)
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
INSERT INTO `locale` VALUES ('1', 'nl_BE', '2', null, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `locale` VALUES ('2', 'en_EN', '2', null, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of menu
-- ----------------------------
INSERT INTO `menu` VALUES ('1', 'home', 'index', 'index', 'default', 'home', '1', '1', null, '0000-00-00 00:00:00', '2013-06-12 16:19:26');

-- ----------------------------
-- Table structure for `menulocale`
-- ----------------------------
DROP TABLE IF EXISTS `menulocale`;
CREATE TABLE `menulocale` (
  `menulocaleId` int(11) NOT NULL AUTO_INCREMENT,
  `menuId` int(11) NOT NULL,
  `label` varchar(255) NOT NULL,
  `localeId` int(11) NOT NULL,
  `translated` tinyint(4) DEFAULT NULL,
  `creationUserId` int(11) NOT NULL,
  `changeUserId` int(11) DEFAULT NULL,
  `creationDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `changeDate` timestamp NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`menulocaleId`),
  KEY `menuId` (`menuId`),
  KEY `creationUserId` (`creationUserId`),
  KEY `changeUserId` (`changeUserId`),
  CONSTRAINT `menulocale_ibfk_1` FOREIGN KEY (`menuId`) REFERENCES `menu` (`menuId`),
  CONSTRAINT `menulocale_ibfk_2` FOREIGN KEY (`creationUserId`) REFERENCES `user` (`userId`),
  CONSTRAINT `menulocale_ibfk_3` FOREIGN KEY (`changeUserId`) REFERENCES `user` (`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of menulocale
-- ----------------------------
INSERT INTO `menulocale` VALUES ('1', '1', 'home', '1', '1', '2', null, '0000-00-00 00:00:00', '2013-06-12 16:32:45');
INSERT INTO `menulocale` VALUES ('2', '1', 'home', '2', '1', '2', null, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

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
  KEY `menuId` (`menuId`),
  KEY `roleId` (`roleId`),
  KEY `creationUserId` (`creationUserId`),
  KEY `changeUserId` (`changeUserId`),
  CONSTRAINT `menurole_ibfk_1` FOREIGN KEY (`menuId`) REFERENCES `menu` (`menuId`),
  CONSTRAINT `menurole_ibfk_2` FOREIGN KEY (`roleId`) REFERENCES `role` (`roleId`),
  CONSTRAINT `menurole_ibfk_3` FOREIGN KEY (`creationUserId`) REFERENCES `user` (`userId`),
  CONSTRAINT `menurole_ibfk_4` FOREIGN KEY (`changeUserId`) REFERENCES `user` (`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of menurole
-- ----------------------------
INSERT INTO `menurole` VALUES ('1', '1', '1', '0000-00-00 00:00:00', '2013-06-12 16:19:48', '2', null);

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
  `currencyId` int(11) NOT NULL,
  `creationDate` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `changeDate` timestamp NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `creationUserId` int(11) DEFAULT NULL,
  `changeUserId` int(11) DEFAULT NULL,
  PRIMARY KEY (`orderDetailId`),
  KEY `productId` (`productId`),
  KEY `orderId` (`orderId`),
  KEY `currencyId` (`currencyId`),
  KEY `creationUserId` (`creationUserId`),
  KEY `changeUserId` (`changeUserId`),
  CONSTRAINT `orderdetail_ibfk_1` FOREIGN KEY (`productId`) REFERENCES `product` (`productId`),
  CONSTRAINT `orderdetail_ibfk_2` FOREIGN KEY (`orderId`) REFERENCES `order` (`orderId`),
  CONSTRAINT `orderdetail_ibfk_3` FOREIGN KEY (`currencyId`) REFERENCES `currency` (`currencyId`),
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
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of page
-- ----------------------------

-- ----------------------------
-- Table structure for `pagelocale`
-- ----------------------------
DROP TABLE IF EXISTS `pagelocale`;
CREATE TABLE `pagelocale` (
  `pageLocaleId` int(11) NOT NULL AUTO_INCREMENT,
  `pageId` int(11) NOT NULL,
  `lcoaleId` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `traslated` tinyint(4) NOT NULL,
  `creationDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `changeDate` timestamp NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `creationUserId` int(11) NOT NULL,
  `changeUserId` int(11) DEFAULT NULL,
  PRIMARY KEY (`pageLocaleId`),
  KEY `pageId` (`pageId`),
  KEY `lcoaleId` (`lcoaleId`),
  KEY `creationUserId` (`creationUserId`),
  KEY `changeUserId` (`changeUserId`),
  CONSTRAINT `pagelocale_ibfk_1` FOREIGN KEY (`pageId`) REFERENCES `page` (`pageId`),
  CONSTRAINT `pagelocale_ibfk_2` FOREIGN KEY (`lcoaleId`) REFERENCES `locale` (`localeId`),
  CONSTRAINT `pagelocale_ibfk_3` FOREIGN KEY (`creationUserId`) REFERENCES `user` (`userId`),
  CONSTRAINT `pagelocale_ibfk_4` FOREIGN KEY (`changeUserId`) REFERENCES `user` (`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pagelocale
-- ----------------------------

-- ----------------------------
-- Table structure for `photo`
-- ----------------------------
DROP TABLE IF EXISTS `photo`;
CREATE TABLE `photo` (
  `photoId` int(11) NOT NULL AUTO_INCREMENT,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of photo
-- ----------------------------

-- ----------------------------
-- Table structure for `photolocale`
-- ----------------------------
DROP TABLE IF EXISTS `photolocale`;
CREATE TABLE `photolocale` (
  `photoLocaleId` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `teaser` varchar(255) NOT NULL,
  `photoId` int(11) NOT NULL,
  `localeId` int(11) NOT NULL,
  `translated` tinyint(4) NOT NULL,
  PRIMARY KEY (`photoLocaleId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of photolocale
-- ----------------------------

-- ----------------------------
-- Table structure for `product`
-- ----------------------------
DROP TABLE IF EXISTS `product`;
CREATE TABLE `product` (
  `productId` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(255) NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `currencyId` int(11) NOT NULL,
  `price` float(11,4) NOT NULL,
  `highlight` tinyint(4) NOT NULL,
  `creationDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `changeDate` timestamp NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `creationUserId` int(11) NOT NULL,
  `changeUserId` int(11) DEFAULT NULL,
  PRIMARY KEY (`productId`),
  KEY `currencyId` (`currencyId`),
  KEY `creationUserId` (`creationUserId`),
  KEY `changeUserId` (`changeUserId`),
  CONSTRAINT `product_ibfk_1` FOREIGN KEY (`currencyId`) REFERENCES `currency` (`currencyId`),
  CONSTRAINT `product_ibfk_2` FOREIGN KEY (`creationUserId`) REFERENCES `user` (`userId`),
  CONSTRAINT `product_ibfk_3` FOREIGN KEY (`changeUserId`) REFERENCES `user` (`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of product
-- ----------------------------
INSERT INTO `product` VALUES ('1', 'product A', 'active', '1', '10.0000', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2', null);
INSERT INTO `product` VALUES ('2', 'product B', 'active', '1', '11.0000', '0', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2', null);
INSERT INTO `product` VALUES ('3', 'product C', 'active', '1', '12.0000', '0', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2', null);
INSERT INTO `product` VALUES ('4', 'product D', 'active', '1', '13.0000', '0', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2', null);

-- ----------------------------
-- Table structure for `productlocale`
-- ----------------------------
DROP TABLE IF EXISTS `productlocale`;
CREATE TABLE `productlocale` (
  `productlocale` int(11) NOT NULL AUTO_INCREMENT,
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
  PRIMARY KEY (`productlocale`),
  KEY `productId` (`productId`),
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of productphoto
-- ----------------------------

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of translate
-- ----------------------------
INSERT INTO `translate` VALUES ('3', '1', 'lbl_Naam', 'Naam', '1');
INSERT INTO `translate` VALUES ('4', '2', 'lbl_Naam', 'Name', '1');
INSERT INTO `translate` VALUES ('5', '1', 'lbl_Wachtwoord', 'Wachtwoord', '1');
INSERT INTO `translate` VALUES ('6', '2', 'lbl_Wachtwoord', 'Password', '1');

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
  `currencyId` int(11) NOT NULL,
  `creationDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `changeDate` timestamp NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `creationUserId` int(11) NOT NULL,
  `changeUserId` int(11) DEFAULT NULL,
  PRIMARY KEY (`userId`),
  KEY `roleId` (`roleId`),
  KEY `creationUserId` (`creationUserId`),
  KEY `changeUserId` (`changeUserId`),
  KEY `currencyId` (`currencyId`),
  CONSTRAINT `user_ibfk_1` FOREIGN KEY (`roleId`) REFERENCES `role` (`roleId`),
  CONSTRAINT `user_ibfk_2` FOREIGN KEY (`creationUserId`) REFERENCES `user` (`userId`),
  CONSTRAINT `user_ibfk_3` FOREIGN KEY (`changeUserId`) REFERENCES `user` (`userId`),
  CONSTRAINT `user_ibfk_4` FOREIGN KEY (`currencyId`) REFERENCES `currency` (`currencyId`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', 'kris.planckaert@winsol.eu', '03e13700e25563c0c0a8ffdb48dbbc19', 'kris', 'active', '4', '1', '0000-00-00 00:00:00', '2013-06-12 12:40:36', '1', null);
INSERT INTO `user` VALUES ('2', 'thomas.vanhuysse@winsol.eu', 'ef6e65efc188e7dffd7335b646a85a21', 'thomas', 'active', '3', '1', '0000-00-00 00:00:00', '2013-06-12 12:40:43', '1', null);
INSERT INTO `user` VALUES ('3', 'xavier@dxsolutions.be', '0f5366b3b19afc3184d23bc73d8cd311', 'xavier', 'active', '2', '2', '0000-00-00 00:00:00', '2013-06-12 12:40:52', '1', null);
