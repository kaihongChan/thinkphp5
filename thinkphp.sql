/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50719
Source Host           : localhost:3306
Source Database       : thinkphp

Target Server Type    : MYSQL
Target Server Version : 50719
File Encoding         : 65001

Date: 2017-11-14 15:41:30
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `thinkphp_function`
-- ----------------------------
DROP TABLE IF EXISTS `thinkphp_function`;
CREATE TABLE `thinkphp_function` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '唯一标识',
  `identifier` text NOT NULL COMMENT '标记符',
  `category` varchar(255) NOT NULL COMMENT '类别',
  `name` varchar(100) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '描述',
  `module` varchar(100) NOT NULL COMMENT '模块',
  `controller` varchar(100) NOT NULL COMMENT '控制器',
  `action` varchar(100) NOT NULL COMMENT '方法（函数）',
  `add_time` char(10) NOT NULL COMMENT '添加时间',
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '类型',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态，0禁用，1启用',
  `update_time` char(10) DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of thinkphp_function
-- ----------------------------
INSERT INTO `thinkphp_function` VALUES ('1', 'admin:index:index', 'index', '后台主页', '后台主页', 'admin', 'index', 'index', '', '0', '1', '1510643317');
INSERT INTO `thinkphp_function` VALUES ('2', 'admin:group:index', 'group', '用户组管理', '用户组管理', 'admin', 'group', 'index', '1507518004', '1', '1', '1510643321');
INSERT INTO `thinkphp_function` VALUES ('3', 'admin:group:addgroup', 'group', '添加用户组', '添加用户组界面', 'admin', 'group', 'addgroup', '1507712654', '0', '1', '1510643211');
INSERT INTO `thinkphp_function` VALUES ('5', 'admin:user:index', 'user', '用户管理', '用户管理页', 'admin', 'user', 'index', '1509084633', '1', '1', '1510643325');
INSERT INTO `thinkphp_function` VALUES ('6', 'admin:user:adduser', 'user', '添加用户', '添加用户功能', 'admin', 'user', 'adduser', '1509084748', '0', '1', '1510643227');
INSERT INTO `thinkphp_function` VALUES ('8', 'admin:menu:index', 'menu', '系统菜单', '系统菜单', 'admin', 'menu', 'index', '1510222161', '1', '1', '1510643328');
INSERT INTO `thinkphp_function` VALUES ('9', 'admin:function:index', 'function', '系统功能', '系统功能管理页面', 'admin', 'function', 'index', '1510304275', '1', '1', '1510643285');
INSERT INTO `thinkphp_function` VALUES ('10', 'admin:index:content', 'index', '首页内容页', '首页内容页', 'admin', 'index', 'content', '1510643397', '0', '1', '1510643397');
INSERT INTO `thinkphp_function` VALUES ('11', 'admin:function:addfunction', 'function', '新增系统功能', '新增系统功能', 'admin', 'function', 'addfunction', '1510643443', '0', '1', '1510643443');
INSERT INTO `thinkphp_function` VALUES ('12', 'admin:function:editfunction', 'function', '更新系统功能', '更新系统功能', 'admin', 'function', 'editfunction', '1510643465', '0', '1', '1510643465');
INSERT INTO `thinkphp_function` VALUES ('13', 'admin:function:deletefunction', 'function', '删除系统功能', '删除系统功能', 'admin', 'function', 'deletefunction', '1510643485', '0', '1', '1510643485');
INSERT INTO `thinkphp_function` VALUES ('14', 'admin:function:getactionbycontroller', 'function', '获取方法名', '通过控制器获取方法名', 'admin', 'function', 'getactionbycontroller', '1510643536', '0', '1', '1510643536');
INSERT INTO `thinkphp_function` VALUES ('15', 'admin:function:checkfunction', 'function', '校验系统功能', '校验系统功能是否存在', 'admin', 'function', 'checkfunction', '1510643568', '0', '1', '1510643568');
INSERT INTO `thinkphp_function` VALUES ('16', 'admin:group:editgroup', 'group', '更新用户组', '更新用户组', 'admin', 'group', 'editgroup', '1510643596', '0', '1', '1510643596');
INSERT INTO `thinkphp_function` VALUES ('17', 'admin:group:deletegroup', 'group', '删除用户组', '删除用户组', 'admin', 'group', 'deletegroup', '1510643612', '0', '1', '1510643612');
INSERT INTO `thinkphp_function` VALUES ('18', 'admin:menu:addmenu', 'menu', '新增菜单项', '新增菜单项', 'admin', 'menu', 'addmenu', '1510643641', '0', '1', '1510643641');
INSERT INTO `thinkphp_function` VALUES ('19', 'admin:menu:editmenu', 'menu', '更新菜单项', '更新菜单项', 'admin', 'menu', 'editmenu', '1510643662', '0', '1', '1510643662');
INSERT INTO `thinkphp_function` VALUES ('20', 'admin:menu:deletemenu', 'menu', '删除菜单项', '删除菜单项', 'admin', 'menu', 'deletemenu', '1510643682', '0', '1', '1510643682');
INSERT INTO `thinkphp_function` VALUES ('21', 'admin:menu:refreshmenufunction', 'menu', '刷新菜单项', '刷新菜单配置信息功能下拉框', 'admin', 'menu', 'refreshmenufunction', '1510643728', '0', '1', '1510643728');
INSERT INTO `thinkphp_function` VALUES ('22', 'admin:user:checkuser', 'user', '校验用户名', '校验用户名是否重名', 'admin', 'user', 'checkuser', '1510643777', '0', '1', '1510643777');
INSERT INTO `thinkphp_function` VALUES ('23', 'admin:user:edituser', 'user', '更新用户', '更新系统用户', 'admin', 'user', 'edituser', '1510643802', '0', '1', '1510643802');
INSERT INTO `thinkphp_function` VALUES ('24', 'admin:user:deleteuser', 'user', '删除用户', '删除系统用户', 'admin', 'user', 'deleteuser', '1510643824', '0', '1', '1510643824');

-- ----------------------------
-- Table structure for `thinkphp_group`
-- ----------------------------
DROP TABLE IF EXISTS `thinkphp_group`;
CREATE TABLE `thinkphp_group` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '' COMMENT '组名',
  `description` varchar(255) NOT NULL COMMENT '描述',
  `powers` longtext NOT NULL COMMENT '用户组权限',
  `sort` int(3) NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `add_time` char(10) NOT NULL DEFAULT '0' COMMENT '添加时间',
  `update_time` char(10) NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of thinkphp_group
-- ----------------------------
INSERT INTO `thinkphp_group` VALUES ('1', '超级管理员', '超级管理员', '[\"1\",\"2\",\"3\",\"4\",\"5\",\"6\",\"7\",\"8\",\"9\"]', '0', '1', '1506752251', '1510304627');
INSERT INTO `thinkphp_group` VALUES ('2', '信息部', '信息部分组', '[\"1\",\"2\",\"3\",\"4\",\"5\",\"6\",\"7\"]', '1', '1', '1506752251', '1510214394');
INSERT INTO `thinkphp_group` VALUES ('3', '测试1', '测试分组1', '[\"1\"]', '3', '1', '1506752251', '1510214560');

-- ----------------------------
-- Table structure for `thinkphp_menu`
-- ----------------------------
DROP TABLE IF EXISTS `thinkphp_menu`;
CREATE TABLE `thinkphp_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '父id',
  `title` varchar(255) NOT NULL COMMENT '菜单名称',
  `function` varchar(255) DEFAULT NULL COMMENT '功能',
  `sort` int(3) DEFAULT '0' COMMENT '排序',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态，0禁用，1启用',
  `icon` text COMMENT '图标',
  `add_time` char(10) DEFAULT NULL COMMENT '添加时间',
  `update_time` char(10) DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of thinkphp_menu
-- ----------------------------
INSERT INTO `thinkphp_menu` VALUES ('1', '0', '系统设置', '#', '0', '1', 'fa-home', null, null);
INSERT INTO `thinkphp_menu` VALUES ('2', '1', '用户组', '2', '0', '1', '', null, null);
INSERT INTO `thinkphp_menu` VALUES ('3', '1', '系统用户', '5', '2', '1', '', '1510304179', '1510304179');
INSERT INTO `thinkphp_menu` VALUES ('4', '1', '系统菜单', '8', '4', '1', '', '1510304217', '1510304217');
INSERT INTO `thinkphp_menu` VALUES ('5', '1', '系统功能', '9', '3', '1', '', '1510304327', '1510304327');

-- ----------------------------
-- Table structure for `thinkphp_user`
-- ----------------------------
DROP TABLE IF EXISTS `thinkphp_user`;
CREATE TABLE `thinkphp_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户id',
  `name` varchar(255) NOT NULL COMMENT '用户名',
  `display_name` varchar(64) NOT NULL COMMENT '显示名',
  `password` longtext NOT NULL COMMENT '用户密码',
  `salt` char(5) NOT NULL COMMENT '加盐',
  `add_time` char(10) NOT NULL DEFAULT '0' COMMENT '添加时间',
  `update_time` char(10) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `last_login_time` char(10) DEFAULT '0' COMMENT '最后登录时间',
  `last_login_ip` char(15) DEFAULT NULL COMMENT '最后登录ip',
  `status` tinyint(1) NOT NULL COMMENT '状态0禁用1启用',
  `remarks` varchar(200) NOT NULL COMMENT '备注',
  `group_list` longtext COMMENT '用户组列表',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of thinkphp_user
-- ----------------------------
INSERT INTO `thinkphp_user` VALUES ('1', 'admin', '超级管理员', '$2y$10$o4BZ5tJLC5wGBYZshLRVG.GDpcP80S0vr0NrKiDe.XpSt26zUF6xS', 'AExrv', '1507535644', '1510305491', '1510644377', '127.0.0.1', '1', '超级管理员拥有所有系统权限', '[\"1\",\"2\"]');
INSERT INTO `thinkphp_user` VALUES ('2', 'chen', '陈', '$2y$10$gqZIr0xwwaHwYGBghnBeiO4wkS9WYBVN.CAVMIsAYS1/twNPO.QXG', 'J7HhX', '1507535644', '1510642920', '1510304759', '127.0.0.1', '1', '要什么备注', '[\"2\"]');
