/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50150
Source Host           : localhost:3306
Source Database       : eindwerk

Target Server Type    : MYSQL
Target Server Version : 50150
File Encoding         : 65001

Date: 2013-06-17 22:00:08
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
  UNIQUE KEY `userId` (`userId`,`productId`),
  KEY `productId` (`productId`),
  CONSTRAINT `basket_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`userId`) ON DELETE CASCADE,
  CONSTRAINT `basket_ibfk_2` FOREIGN KEY (`productId`) REFERENCES `product` (`productId`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of basket
-- ----------------------------
INSERT INTO `basket` VALUES ('27', '3', '1', '02clos8m3o1r5s1685ciq7j9p5', '12', '0000-00-00 00:00:00', '2013-06-17 16:59:23');

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
INSERT INTO `category` VALUES ('1', 'Cat A', '1', '0000-00-00 00:00:00', '2013-06-15 19:44:17', '2', '2');
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
  CONSTRAINT `categorylocale_ibfk_4` FOREIGN KEY (`categoryId`) REFERENCES `category` (`categoryId`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of categorylocale
-- ----------------------------
INSERT INTO `categorylocale` VALUES ('1', '1', '1', 'Categorie A NL', '1', '0000-00-00 00:00:00', '2013-06-15 19:44:17', '2', '2');
INSERT INTO `categorylocale` VALUES ('2', '1', '2', 'Category A EN', '1', '0000-00-00 00:00:00', '2013-06-15 19:44:17', '2', '2');
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
  KEY `creationUserId` (`creationUserId`),
  KEY `changeUserId` (`changeUserId`),
  KEY `categoryproduct_ibfk_2` (`productId`),
  KEY `categoryproduct_ibfk_5` (`categoryId`),
  CONSTRAINT `categoryproduct_ibfk_2` FOREIGN KEY (`productId`) REFERENCES `product` (`productId`) ON DELETE CASCADE,
  CONSTRAINT `categoryproduct_ibfk_3` FOREIGN KEY (`creationUserId`) REFERENCES `user` (`userId`),
  CONSTRAINT `categoryproduct_ibfk_4` FOREIGN KEY (`changeUserId`) REFERENCES `user` (`userId`),
  CONSTRAINT `categoryproduct_ibfk_5` FOREIGN KEY (`categoryId`) REFERENCES `category` (`categoryId`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of categoryproduct
-- ----------------------------
INSERT INTO `categoryproduct` VALUES ('3', '2', '3', '0000-00-00 00:00:00', null, '2', null);
INSERT INTO `categoryproduct` VALUES ('4', '2', '4', '0000-00-00 00:00:00', null, '2', null);
INSERT INTO `categoryproduct` VALUES ('40', '1', '1', '2013-06-15 19:44:17', null, '2', null);
INSERT INTO `categoryproduct` VALUES ('41', '1', '2', '2013-06-15 19:44:17', null, '2', null);

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
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

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
INSERT INTO `menu` VALUES ('21', 'page', 'list', 'page', 'dealer', 'page', '1', '2', null, '2013-06-15 19:45:06', '0000-00-00 00:00:00');
INSERT INTO `menu` VALUES ('23', 'order', 'list', 'order', 'user', 'order', '1', '2', '2', '2013-06-15 21:23:03', '2013-06-16 07:32:25');
INSERT INTO `menu` VALUES ('24', 'user', 'list', 'user', 'dealer', 'user', '1', '2', null, '2013-06-16 13:09:25', '0000-00-00 00:00:00');

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
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8;

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
INSERT INTO `menulocale` VALUES ('42', '21', 'pagina', '1', '1', '2', null, '2013-06-15 19:45:06', '0000-00-00 00:00:00');
INSERT INTO `menulocale` VALUES ('43', '21', 'page', '2', '1', '2', null, '2013-06-15 19:45:06', '0000-00-00 00:00:00');
INSERT INTO `menulocale` VALUES ('46', '23', 'Bestellingen', '1', '1', '2', '2', '2013-06-15 21:23:03', '2013-06-16 07:32:25');
INSERT INTO `menulocale` VALUES ('47', '23', 'Orders', '2', '1', '2', '2', '2013-06-15 21:23:03', '2013-06-16 07:32:25');
INSERT INTO `menulocale` VALUES ('48', '24', 'Gebruikers', '1', '1', '2', null, '2013-06-16 13:09:25', '0000-00-00 00:00:00');
INSERT INTO `menulocale` VALUES ('49', '24', 'Users', '2', '1', '2', null, '2013-06-16 13:09:26', '0000-00-00 00:00:00');

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
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8;

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
INSERT INTO `menurole` VALUES ('34', '21', '3', '2013-06-15 19:45:06', '0000-00-00 00:00:00', '2', null);
INSERT INTO `menurole` VALUES ('35', '21', '4', '2013-06-15 19:45:06', '0000-00-00 00:00:00', '2', null);
INSERT INTO `menurole` VALUES ('37', '23', '3', '2013-06-15 21:23:03', '0000-00-00 00:00:00', '2', null);
INSERT INTO `menurole` VALUES ('38', '23', '4', '2013-06-15 21:23:03', '0000-00-00 00:00:00', '2', null);
INSERT INTO `menurole` VALUES ('39', '23', '2', '2013-06-16 07:32:25', '0000-00-00 00:00:00', '2', null);
INSERT INTO `menurole` VALUES ('40', '24', '3', '2013-06-16 13:09:26', '0000-00-00 00:00:00', '2', null);
INSERT INTO `menurole` VALUES ('41', '24', '4', '2013-06-16 13:09:26', '0000-00-00 00:00:00', '2', null);

-- ----------------------------
-- Table structure for `order`
-- ----------------------------
DROP TABLE IF EXISTS `order`;
CREATE TABLE `order` (
  `orderId` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `reference` varchar(255) DEFAULT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of order
-- ----------------------------
INSERT INTO `order` VALUES ('2', '3', null, '2013-06-15 21:47:57', '2013-06-16 12:43:52', '2', null);
INSERT INTO `order` VALUES ('3', '2', null, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2', null);
INSERT INTO `order` VALUES ('4', '11', 'test', '2013-06-16 08:04:02', '0000-00-00 00:00:00', '2', null);
INSERT INTO `order` VALUES ('5', '11', 'test', '2013-06-16 08:10:05', '0000-00-00 00:00:00', '2', null);
INSERT INTO `order` VALUES ('6', '11', 'test', '2013-06-16 17:11:31', '0000-00-00 00:00:00', '2', null);
INSERT INTO `order` VALUES ('7', '11', 'test', '2013-06-16 17:12:05', '0000-00-00 00:00:00', '2', null);
INSERT INTO `order` VALUES ('8', '11', 'test', '2013-06-16 17:13:08', '0000-00-00 00:00:00', '2', null);
INSERT INTO `order` VALUES ('9', '11', 'test', '2013-06-16 17:14:52', '0000-00-00 00:00:00', '2', null);
INSERT INTO `order` VALUES ('10', '11', 'test', '2013-06-16 17:15:46', '0000-00-00 00:00:00', '2', null);
INSERT INTO `order` VALUES ('11', '11', 'test123', '2013-06-16 17:16:46', '0000-00-00 00:00:00', '2', null);
INSERT INTO `order` VALUES ('12', '11', 'test123', '2013-06-16 17:18:17', '0000-00-00 00:00:00', '2', null);
INSERT INTO `order` VALUES ('13', '11', 'test123', '2013-06-16 17:18:31', '0000-00-00 00:00:00', '2', null);
INSERT INTO `order` VALUES ('14', '11', 'test123', '2013-06-16 17:18:56', '0000-00-00 00:00:00', '2', null);
INSERT INTO `order` VALUES ('15', '11', 'test123', '2013-06-16 17:20:15', '0000-00-00 00:00:00', '2', null);
INSERT INTO `order` VALUES ('16', '11', 'test123', '2013-06-16 17:20:58', '0000-00-00 00:00:00', '2', null);
INSERT INTO `order` VALUES ('17', '11', 'test123', '2013-06-16 17:21:39', '0000-00-00 00:00:00', '2', null);
INSERT INTO `order` VALUES ('18', '11', 'test123', '2013-06-16 17:22:05', '0000-00-00 00:00:00', '2', null);
INSERT INTO `order` VALUES ('19', '11', 'test58', '2013-06-16 17:23:16', '0000-00-00 00:00:00', '2', null);
INSERT INTO `order` VALUES ('20', '14', 'test1', '2013-06-16 17:33:50', '0000-00-00 00:00:00', '2', null);
INSERT INTO `order` VALUES ('21', '15', 'test', '2013-06-16 17:46:43', '0000-00-00 00:00:00', '2', null);
INSERT INTO `order` VALUES ('22', '18', 'Test Bjorn', '2013-06-17 08:17:06', '0000-00-00 00:00:00', '2', null);
INSERT INTO `order` VALUES ('23', '19', 'thomas', '2013-06-17 08:36:48', '0000-00-00 00:00:00', '2', null);
INSERT INTO `order` VALUES ('24', '3', 'test xavier', '2013-06-17 09:00:53', '0000-00-00 00:00:00', '2', null);
INSERT INTO `order` VALUES ('25', '3', 'test xavier', '2013-06-17 09:02:18', '0000-00-00 00:00:00', '2', null);
INSERT INTO `order` VALUES ('26', '3', 'jhfkgfkj', '2013-06-17 09:02:55', '0000-00-00 00:00:00', '2', null);
INSERT INTO `order` VALUES ('27', '3', 'jhfkgfkj', '2013-06-17 09:03:42', '0000-00-00 00:00:00', '2', null);
INSERT INTO `order` VALUES ('28', '3', 'illijlijglk', '2013-06-17 09:04:00', '0000-00-00 00:00:00', '2', null);

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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of orderdetail
-- ----------------------------
INSERT INTO `orderdetail` VALUES ('1', '2', '2', '2', '10.00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2', null);
INSERT INTO `orderdetail` VALUES ('2', '1', '5', '174', '11.00', '2013-06-16 08:10:05', '0000-00-00 00:00:00', '2', null);
INSERT INTO `orderdetail` VALUES ('3', '1', '17', '58', '11.00', '2013-06-16 17:21:39', '0000-00-00 00:00:00', '2', null);
INSERT INTO `orderdetail` VALUES ('4', '1', '18', '58', '11.00', '2013-06-16 17:22:05', '0000-00-00 00:00:00', '2', null);
INSERT INTO `orderdetail` VALUES ('5', '1', '19', '58', '11.00', '2013-06-16 17:23:16', '0000-00-00 00:00:00', '2', null);
INSERT INTO `orderdetail` VALUES ('6', '1', '20', '1', '11.00', '2013-06-16 17:33:50', '0000-00-00 00:00:00', '2', null);
INSERT INTO `orderdetail` VALUES ('7', '1', '22', '2', '11.00', '2013-06-17 08:17:06', '0000-00-00 00:00:00', '2', null);
INSERT INTO `orderdetail` VALUES ('8', '1', '23', '2', '11.00', '2013-06-17 08:36:48', '0000-00-00 00:00:00', '2', null);
INSERT INTO `orderdetail` VALUES ('9', '1', '24', '2', '11.00', '2013-06-17 09:00:53', '0000-00-00 00:00:00', '2', null);
INSERT INTO `orderdetail` VALUES ('10', '1', '24', '2', '11.00', '2013-06-17 09:00:53', '0000-00-00 00:00:00', '2', null);
INSERT INTO `orderdetail` VALUES ('11', '1', '27', '2', '11.00', '2013-06-17 09:03:42', '0000-00-00 00:00:00', '2', null);
INSERT INTO `orderdetail` VALUES ('12', '1', '28', '2', '11.00', '2013-06-17 09:04:00', '0000-00-00 00:00:00', '2', null);

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
INSERT INTO `page` VALUES ('1', 'about', '1', 'about', '0000-00-00 00:00:00', '2013-06-15 19:51:53', '2', '2');
INSERT INTO `page` VALUES ('2', 'dislaimer', '1', 'disclaimer', '0000-00-00 00:00:00', '2013-06-16 06:28:11', '2', '2');

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
  `translated` tinyint(4) NOT NULL,
  `creationDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `changeDate` timestamp NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `creationUserId` int(11) NOT NULL,
  `changeUserId` int(11) DEFAULT NULL,
  PRIMARY KEY (`pageLocaleId`),
  UNIQUE KEY `pageId` (`pageId`,`localeId`),
  KEY `creationUserId` (`creationUserId`),
  KEY `changeUserId` (`changeUserId`),
  KEY `localeId` (`localeId`),
  CONSTRAINT `pagelocale_ibfk_1` FOREIGN KEY (`pageId`) REFERENCES `page` (`pageId`) ON DELETE CASCADE,
  CONSTRAINT `pagelocale_ibfk_3` FOREIGN KEY (`creationUserId`) REFERENCES `user` (`userId`),
  CONSTRAINT `pagelocale_ibfk_4` FOREIGN KEY (`changeUserId`) REFERENCES `user` (`userId`),
  CONSTRAINT `pagelocale_ibfk_5` FOREIGN KEY (`localeId`) REFERENCES `locale` (`localeId`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pagelocale
-- ----------------------------
INSERT INTO `pagelocale` VALUES ('1', '1', '1', 'about titel NL', 'about description NL', '1', '0000-00-00 00:00:00', '2013-06-15 19:51:53', '2', '2');
INSERT INTO `pagelocale` VALUES ('2', '1', '2', 'about title EN', 'about description EN', '1', '0000-00-00 00:00:00', '2013-06-15 19:51:53', '2', '2');
INSERT INTO `pagelocale` VALUES ('3', '2', '1', 'Vrijwaring', 'disclaimer', '1', '0000-00-00 00:00:00', '2013-06-16 06:28:11', '2', '2');
INSERT INTO `pagelocale` VALUES ('4', '2', '2', 'disclaimer', 'disclaimer', '1', '0000-00-00 00:00:00', '2013-06-16 06:28:11', '2', '2');

-- ----------------------------
-- Table structure for `photo`
-- ----------------------------
DROP TABLE IF EXISTS `photo`;
CREATE TABLE `photo` (
  `photoId` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(255) NOT NULL,
  `fileNameOrig` varchar(250) DEFAULT NULL,
  `fileSize` int(11) DEFAULT NULL,
  PRIMARY KEY (`photoId`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of photo
-- ----------------------------
INSERT INTO `photo` VALUES ('23', 'aardbei.jpg', 'aardbei.jpg', '10399');

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
  CONSTRAINT `photolocale_ibfk_1` FOREIGN KEY (`photoId`) REFERENCES `photo` (`photoId`) ON DELETE CASCADE,
  CONSTRAINT `photolocale_ibfk_2` FOREIGN KEY (`localeId`) REFERENCES `locale` (`localeId`),
  CONSTRAINT `photolocale_ibfk_3` FOREIGN KEY (`creationUserId`) REFERENCES `user` (`userId`),
  CONSTRAINT `photolocale_ibfk_4` FOREIGN KEY (`changeUserId`) REFERENCES `user` (`userId`)
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
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `price` float(11,4) NOT NULL,
  `highlight` tinyint(4) NOT NULL DEFAULT '0',
  `creationDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `changeDate` timestamp NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `creationUserId` int(11) NOT NULL,
  `changeUserId` int(11) DEFAULT NULL,
  PRIMARY KEY (`productId`),
  KEY `creationUserId` (`creationUserId`),
  KEY `changeUserId` (`changeUserId`),
  CONSTRAINT `product_ibfk_2` FOREIGN KEY (`creationUserId`) REFERENCES `user` (`userId`),
  CONSTRAINT `product_ibfk_3` FOREIGN KEY (`changeUserId`) REFERENCES `user` (`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of product
-- ----------------------------
INSERT INTO `product` VALUES ('1', 'product A', '1', '11.0000', '1', '0000-00-00 00:00:00', '2013-06-15 16:20:40', '2', '2');
INSERT INTO `product` VALUES ('2', 'product B', '1', '11.0000', '0', '0000-00-00 00:00:00', '2013-06-15 16:16:30', '2', '2');
INSERT INTO `product` VALUES ('3', 'product C', '1', '12.0000', '1', '0000-00-00 00:00:00', '2013-06-13 21:31:48', '2', null);
INSERT INTO `product` VALUES ('4', 'product D', '1', '13.0000', '0', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2', null);
INSERT INTO `product` VALUES ('10', 'test', '0', '10.0000', '0', '2013-06-15 21:01:22', '0000-00-00 00:00:00', '2', null);

-- ----------------------------
-- Table structure for `productlocale`
-- ----------------------------
DROP TABLE IF EXISTS `productlocale`;
CREATE TABLE `productlocale` (
  `productLocaleId` int(11) NOT NULL AUTO_INCREMENT,
  `productId` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `teaser` varchar(255) DEFAULT NULL,
  `content` varchar(255) DEFAULT NULL,
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
  CONSTRAINT `productlocale_ibfk_1` FOREIGN KEY (`productId`) REFERENCES `product` (`productId`) ON DELETE CASCADE,
  CONSTRAINT `productlocale_ibfk_2` FOREIGN KEY (`localeId`) REFERENCES `locale` (`localeId`),
  CONSTRAINT `productlocale_ibfk_3` FOREIGN KEY (`creationUserId`) REFERENCES `user` (`userId`),
  CONSTRAINT `productlocale_ibfk_4` FOREIGN KEY (`changeUserId`) REFERENCES `user` (`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of productlocale
-- ----------------------------
INSERT INTO `productlocale` VALUES ('3', '10', 'test NL', 'Teaser NL', 'Content NL', '1', '1', '2013-06-15 21:01:22', '2013-06-15 21:01:22', '2', '2');
INSERT INTO `productlocale` VALUES ('4', '10', 'Title EN', 'Tease EN', 'Content EN', '2', '1', '2013-06-15 21:01:22', '2013-06-15 21:01:22', '2', '2');
INSERT INTO `productlocale` VALUES ('5', '1', 'Kast', 'Kast voro in de living', 'Mooie eiken kast', '1', '1', '2013-06-17 09:42:45', null, '2', null);
INSERT INTO `productlocale` VALUES ('6', '1', 'Closet', 'Closet for the house', 'Nice oak closet', '2', '1', '2013-06-17 09:43:52', '2013-06-17 09:43:55', '2', null);

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
  KEY `creationUserId` (`creationUserId`),
  KEY `changeUserId` (`changeUserId`),
  KEY `productphoto_ibfk_1` (`productId`),
  KEY `productphoto_ibfk_2` (`photoId`),
  CONSTRAINT `productphoto_ibfk_1` FOREIGN KEY (`productId`) REFERENCES `product` (`productId`) ON DELETE CASCADE,
  CONSTRAINT `productphoto_ibfk_2` FOREIGN KEY (`photoId`) REFERENCES `photo` (`photoId`) ON DELETE CASCADE,
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
  UNIQUE KEY `localeId` (`localeId`,`tag`),
  CONSTRAINT `translate_ibfk_1` FOREIGN KEY (`localeId`) REFERENCES `locale` (`localeId`)
) ENGINE=InnoDB AUTO_INCREMENT=108 DEFAULT CHARSET=utf8;

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
INSERT INTO `translate` VALUES ('13', '1', 'lbl_price', 'prijs', '1');
INSERT INTO `translate` VALUES ('14', '2', 'lbl_price', 'price', '1');
INSERT INTO `translate` VALUES ('15', '1', 'lbl_quantity', 'Aantal', '1');
INSERT INTO `translate` VALUES ('16', '2', 'lbl_quantity', 'Quantity', '1');
INSERT INTO `translate` VALUES ('17', '1', 'lbl_add', 'toevoegen', '1');
INSERT INTO `translate` VALUES ('18', '2', 'lbl_add', 'add', '1');
INSERT INTO `translate` VALUES ('19', '1', 'lbl_basketoverview', 'Winkelmand overzicht', '1');
INSERT INTO `translate` VALUES ('20', '2', 'lbl_basketoverview', 'Basket overview', '1');
INSERT INTO `translate` VALUES ('21', '1', 'lbl_delete', 'Verwijderen', '1');
INSERT INTO `translate` VALUES ('22', '2', 'lbl_delete', 'Delete', '1');
INSERT INTO `translate` VALUES ('23', '1', 'lbl_menuoverview', 'Menus overzicht', '1');
INSERT INTO `translate` VALUES ('24', '2', 'lbl_menuoverview', 'Menu overview', '1');
INSERT INTO `translate` VALUES ('25', '1', 'lbl_filename', 'Bestandsnaam', '1');
INSERT INTO `translate` VALUES ('26', '2', 'lbl_filename', 'Filename', '1');
INSERT INTO `translate` VALUES ('29', '1', 'lbl_logout', 'Uitloggen', '1');
INSERT INTO `translate` VALUES ('30', '2', 'lbl_logout', 'Logout', '1');
INSERT INTO `translate` VALUES ('31', '1', 'lbl_basket', 'Winkelmand', '1');
INSERT INTO `translate` VALUES ('32', '2', 'lbl_basket', 'Basket', '1');
INSERT INTO `translate` VALUES ('33', '1', 'lbl_name', 'Naam', '1');
INSERT INTO `translate` VALUES ('34', '2', 'lbl_name', 'Name', '1');
INSERT INTO `translate` VALUES ('37', '1', 'lbl_description', 'Omschrijving', '1');
INSERT INTO `translate` VALUES ('38', '2', 'lbl_description', 'Description', '1');
INSERT INTO `translate` VALUES ('39', '1', 'lbl_search', 'Zoeken', '1');
INSERT INTO `translate` VALUES ('40', '2', 'lbl_search', 'Search', '1');
INSERT INTO `translate` VALUES ('43', '1', 'lbl_role', 'Rechten', '1');
INSERT INTO `translate` VALUES ('44', '2', 'lbl_role', 'Role', '1');
INSERT INTO `translate` VALUES ('45', '1', 'lbl_order', 'Bestel', '1');
INSERT INTO `translate` VALUES ('46', '2', 'lbl_order', 'Order', '1');
INSERT INTO `translate` VALUES ('47', '1', 'lbl_Congratulations', 'Gefeliciteerd met uw order', '1');
INSERT INTO `translate` VALUES ('48', '2', 'lbl_Congratulations', 'Congratulations with your order', '1');
INSERT INTO `translate` VALUES ('49', '1', 'lbl_reference', 'Referentie', '1');
INSERT INTO `translate` VALUES ('50', '2', 'lbl_reference', 'Reference', '1');
INSERT INTO `translate` VALUES ('51', '1', 'lbl_emptytable', 'Geen records', '1');
INSERT INTO `translate` VALUES ('52', '2', 'lbl_emptytable', 'No records', '1');
INSERT INTO `translate` VALUES ('53', '1', 'lbl_welcome', 'Welkom', '1');
INSERT INTO `translate` VALUES ('54', '2', 'lbl_welcome', 'Welcome', '1');
INSERT INTO `translate` VALUES ('55', '1', 'lbl_loginhere', 'Hier kan je inloggen', '1');
INSERT INTO `translate` VALUES ('56', '2', 'lbl_loginhere', 'Click here to login', '1');
INSERT INTO `translate` VALUES ('57', '1', 'lbl_loginthanks', 'Bedankt om in te loggen', '1');
INSERT INTO `translate` VALUES ('58', '2', 'lbl_loginthanks', 'Thanks to login', '1');
INSERT INTO `translate` VALUES ('59', '1', 'lbl_total', 'Totaal', '1');
INSERT INTO `translate` VALUES ('60', '2', 'lbl_total', 'Total', '1');
INSERT INTO `translate` VALUES ('61', '1', 'lbl_user', 'Gebruiker', '1');
INSERT INTO `translate` VALUES ('62', '2', 'lbl_user', 'User', '1');
INSERT INTO `translate` VALUES ('63', '1', 'lbl_details', 'Details', '1');
INSERT INTO `translate` VALUES ('64', '2', 'lbl_details', 'Details', '1');
INSERT INTO `translate` VALUES ('65', '1', 'lbl_label', 'Label', '1');
INSERT INTO `translate` VALUES ('66', '2', 'lbl_label', 'Label', '1');
INSERT INTO `translate` VALUES ('67', '1', 'lbl_highlight', 'In de kijker', '1');
INSERT INTO `translate` VALUES ('68', '2', 'lbl_highlight', 'Highlight', '1');
INSERT INTO `translate` VALUES ('69', '1', 'lbl_slug', 'Slug', '1');
INSERT INTO `translate` VALUES ('70', '2', 'lbl_slug', 'Slug', '1');
INSERT INTO `translate` VALUES ('71', '1', 'lbl_action', 'Action', '1');
INSERT INTO `translate` VALUES ('72', '2', 'lbl_action', 'Action', '1');
INSERT INTO `translate` VALUES ('73', '1', 'lbl_module', 'Module', '1');
INSERT INTO `translate` VALUES ('74', '2', 'lbl_module', 'Module', '1');
INSERT INTO `translate` VALUES ('75', '1', 'lbl_controller', 'Controller', '1');
INSERT INTO `translate` VALUES ('76', '2', 'lbl_controller', 'Controller', '1');
INSERT INTO `translate` VALUES ('77', '1', 'lbl_product', 'Product', '1');
INSERT INTO `translate` VALUES ('78', '2', 'lbl_product', 'Product', '1');
INSERT INTO `translate` VALUES ('79', '2', 'lbl_passwordconfirm', 'Confirm password', '1');
INSERT INTO `translate` VALUES ('80', '1', 'lbl_passwordconfirm', 'Bevestig wachtwoord', '1');
INSERT INTO `translate` VALUES ('81', '1', 'lbl_change', 'Wijzigen', '1');
INSERT INTO `translate` VALUES ('82', '2', 'lbl_change', 'Change', '1');
INSERT INTO `translate` VALUES ('84', '1', 'lbl_login', 'Login', '1');
INSERT INTO `translate` VALUES ('85', '2', 'lbl_login', 'Login', '1');
INSERT INTO `translate` VALUES ('86', '1', 'lbl_register', 'Registreer', '1');
INSERT INTO `translate` VALUES ('87', '2', 'lbl_register', 'Register', '1');
INSERT INTO `translate` VALUES ('88', '1', 'lbl_descriptionNL', 'Omschrijving NL', '1');
INSERT INTO `translate` VALUES ('89', '2', 'lbl_descriptionNL', 'Description NL', '1');
INSERT INTO `translate` VALUES ('90', '1', 'lbl_descriptionEN', 'Omschrijving EN', '1');
INSERT INTO `translate` VALUES ('91', '2', 'lbl_descriptionEN', 'Description EN', '1');
INSERT INTO `translate` VALUES ('92', '1', 'lbl_lostpassword', 'Wachtwoord vergeten?', '1');
INSERT INTO `translate` VALUES ('93', '2', 'lbl_lostpassword', 'Lost password?', '1');
INSERT INTO `translate` VALUES ('94', '1', 'lbl_send', 'Verzenden', '1');
INSERT INTO `translate` VALUES ('95', '2', 'lbl_send', 'Send', '1');
INSERT INTO `translate` VALUES ('96', '1', 'lbl_email', 'Email', '1');
INSERT INTO `translate` VALUES ('97', '2', 'lbl_email', 'Email', '1');
INSERT INTO `translate` VALUES ('98', '1', 'lbl_wrongemail', 'Verkeerd email adres', '1');
INSERT INTO `translate` VALUES ('99', '2', 'lbl_wrongemail', 'Wrong email address', '1');
INSERT INTO `translate` VALUES ('100', '1', 'lbl_passwordnew', 'Nieuw wachtwoord', '1');
INSERT INTO `translate` VALUES ('101', '2', 'lbl_passwordnew', 'New password', '1');
INSERT INTO `translate` VALUES ('102', '1', 'lbl_passwordnewconfirm', 'Bevestig nieuw wachtwoord', '1');
INSERT INTO `translate` VALUES ('103', '2', 'lbl_passwordnewconfirm', 'Confirm new password', '1');
INSERT INTO `translate` VALUES ('104', '1', 'lbl_continue', 'Verder', '1');
INSERT INTO `translate` VALUES ('105', '2', 'lbl_continue', 'Continue', '1');
INSERT INTO `translate` VALUES ('106', '1', 'lbl_addphoto', 'Toevoegen foto', '1');
INSERT INTO `translate` VALUES ('107', '2', 'lbl_addphoto', 'Add photo', '1');

-- ----------------------------
-- Table structure for `user`
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `userId` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `eId` varchar(32) DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `roleId` int(11) NOT NULL,
  `localeId` int(11) NOT NULL,
  `creationDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `changeDate` timestamp NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `creationUserId` int(11) NOT NULL,
  `changeUserId` int(11) DEFAULT NULL,
  PRIMARY KEY (`userId`),
  KEY `roleId` (`roleId`),
  KEY `creationUserId` (`creationUserId`),
  KEY `changeUserId` (`changeUserId`),
  KEY `localeId` (`localeId`),
  CONSTRAINT `user_ibfk_1` FOREIGN KEY (`roleId`) REFERENCES `role` (`roleId`),
  CONSTRAINT `user_ibfk_2` FOREIGN KEY (`creationUserId`) REFERENCES `user` (`userId`),
  CONSTRAINT `user_ibfk_3` FOREIGN KEY (`changeUserId`) REFERENCES `user` (`userId`),
  CONSTRAINT `user_ibfk_4` FOREIGN KEY (`localeId`) REFERENCES `user` (`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', 'kris.planckaert@winsol.eu', '098f6bcd4621d373cade4e832627b4f6', 'kris', '1.51bef33f9aad37.38926575', 'active', '4', '1', '0000-00-00 00:00:00', '2013-06-17 13:30:07', '1', '2');
INSERT INTO `user` VALUES ('2', 'thomas.vanhuysse@winsol.eu', 'ef6e65efc188e7dffd7335b646a85a21', 'thomas', null, 'active', '3', '1', '0000-00-00 00:00:00', '2013-06-16 17:36:43', '1', null);
INSERT INTO `user` VALUES ('3', 'xavier@dxsolutions.be', '0f5366b3b19afc3184d23bc73d8cd311', 'xavier', null, 'active', '2', '1', '0000-00-00 00:00:00', '2013-06-16 17:36:44', '1', '2');
INSERT INTO `user` VALUES ('11', 'test', '098f6bcd4621d373cade4e832627b4f6', 'test', null, 'active', '2', '1', '2013-06-16 07:44:34', '2013-06-16 17:36:44', '2', null);
INSERT INTO `user` VALUES ('12', 'test58', 'e947c4e3d3091991356d1564d09ddac2', 'test58', null, 'active', '2', '1', '2013-06-16 17:23:46', '2013-06-16 17:36:45', '2', null);
INSERT INTO `user` VALUES ('13', 'test59', 'debdcbab258bf9e208b9f2e6e6d1779b', 'test59', null, 'active', '2', '1', '2013-06-16 17:30:07', '2013-06-16 17:36:45', '2', null);
INSERT INTO `user` VALUES ('14', 'test1', '5a105e8b9d40e1329780d62ea2265d8a', 'test1', null, 'active', '2', '1', '2013-06-16 17:33:31', '2013-06-16 17:36:46', '2', null);
INSERT INTO `user` VALUES ('15', 'testtest', '05a671c66aefea124cc08b76ea6d30bb', 'testtest', null, 'active', '2', '2', '2013-06-16 17:46:27', '0000-00-00 00:00:00', '2', null);
INSERT INTO `user` VALUES ('16', 'test2', 'ad0234829205b9033196ba818f7a872b', 'test2', null, 'active', '2', '1', '2013-06-16 17:55:39', '0000-00-00 00:00:00', '2', null);
INSERT INTO `user` VALUES ('17', 'test3', '8ad8757baa8564dc136c1e07507f4a98', 'test3', null, 'active', '2', '2', '2013-06-16 17:58:47', '0000-00-00 00:00:00', '2', null);
INSERT INTO `user` VALUES ('18', 'test123', 'cc03e747a6afbbcbf8be7668acfebee5', 'test123', null, 'active', '2', '2', '2013-06-17 08:16:54', '0000-00-00 00:00:00', '2', null);
INSERT INTO `user` VALUES ('19', 'trtzer', '202cb962ac59075b964b07152d234b70', 'tzes', null, 'active', '2', '2', '2013-06-17 08:36:33', '0000-00-00 00:00:00', '2', null);
INSERT INTO `user` VALUES ('20', 'tetete', '098f6bcd4621d373cade4e832627b4f6', 'tetete', null, 'active', '2', '2', '2013-06-17 11:19:23', '0000-00-00 00:00:00', '2', null);
