/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50617
Source Host           : localhost:3306
Source Database       : gms

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2015-07-18 23:34:03
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `gms_auth_group`
-- ----------------------------
DROP TABLE IF EXISTS `gms_auth_group`;
CREATE TABLE `gms_auth_group` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `pid` smallint(8) DEFAULT NULL COMMENT '上级ID',
  `title` varchar(100) DEFAULT NULL COMMENT '名称',
  `status` int(3) NOT NULL DEFAULT '1' COMMENT '状态',
  `rules` text COMMENT '规则',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of gms_auth_group
-- ----------------------------
INSERT INTO `gms_auth_group` VALUES ('1', '0', '管理员', '1', '1,53,65,28,79,78,29,30,31,32,80,35,34,33,20,23,21,22,24,27,26,25,44,54,75,74,73,55,77,76,2,51,36,39,38,37,40,43,42,41,66,67,68,82,81,83,72,69,70,71');

-- ----------------------------
-- Table structure for `gms_auth_rule`
-- ----------------------------
DROP TABLE IF EXISTS `gms_auth_rule`;
CREATE TABLE `gms_auth_rule` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `pid` mediumint(8) DEFAULT '0' COMMENT '上级菜单',
  `name` varchar(100) DEFAULT NULL COMMENT '菜单名称',
  `title` varchar(100) DEFAULT NULL COMMENT '菜单标题',
  `icon` varchar(30) DEFAULT 'icon-form' COMMENT '图标',
  `type` varchar(1) DEFAULT '1' COMMENT '导航',
  `is_hide` varchar(1) DEFAULT '1' COMMENT '隐藏',
  `status` varchar(1) DEFAULT '1' COMMENT '状态',
  `sort` smallint(3) unsigned DEFAULT '1' COMMENT '排序',
  `condition` varchar(40) DEFAULT NULL COMMENT '附加参数',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=100 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of gms_auth_rule
-- ----------------------------
INSERT INTO `gms_auth_rule` VALUES ('1', '0', '', '系统', 'iconfont icon-all', '', '0', '1', '1', '');
INSERT INTO `gms_auth_rule` VALUES ('2', '0', '', '用户', 'iconfont icon-account', '', '0', '1', '2', '');
INSERT INTO `gms_auth_rule` VALUES ('24', '53', 'Admin/AuthRule/index', '菜单管理', 'iconfont icon-form', '1', '0', '1', '6', '');
INSERT INTO `gms_auth_rule` VALUES ('40', '51', 'Admin/AuthGroup/index', '用户组管理', 'iconfont icon-form', '1', '0', '1', '2', '');
INSERT INTO `gms_auth_rule` VALUES ('20', '53', 'Admin/Config/index', '配置管理', 'iconfont icon-form', '1', '0', '1', '5', '');
INSERT INTO `gms_auth_rule` VALUES ('36', '51', 'Admin/User/index', '用户管理', 'iconfont icon-form', '1', '0', '1', '1', '');
INSERT INTO `gms_auth_rule` VALUES ('22', '20', 'Admin/Config/edit', '编辑', 'iconfont icon-form', '1', '1', '1', '1', '');
INSERT INTO `gms_auth_rule` VALUES ('21', '20', 'Admin/Config/add', '新增', 'iconfont icon-form', '1', '1', '1', '1', '');
INSERT INTO `gms_auth_rule` VALUES ('23', '20', 'Admin/Config/del', '删除', 'iconfont icon-form', '1', '1', '1', '1', '');
INSERT INTO `gms_auth_rule` VALUES ('25', '24', 'Admin/AuthRule/add', '新增', 'iconfont icon-form', '1', '1', '1', '1', '');
INSERT INTO `gms_auth_rule` VALUES ('26', '24', 'Admin/AuthRule/edit', '编辑', 'iconfont icon-form', '1', '1', '1', '1', '');
INSERT INTO `gms_auth_rule` VALUES ('27', '24', 'Admin/AuthRule/del', '删除', 'iconfont icon-form', '1', '1', '1', '1', '');
INSERT INTO `gms_auth_rule` VALUES ('37', '36', 'Admin/User/add', '新增', 'iconfont icon-form', '1', '1', '1', '1', '');
INSERT INTO `gms_auth_rule` VALUES ('38', '36', 'Admin/User/edit', '编辑', 'iconfont icon-form', '1', '1', '1', '1', '');
INSERT INTO `gms_auth_rule` VALUES ('39', '36', 'Admin/User/del', '删除', 'iconfont icon-form', '1', '1', '1', '1', '');
INSERT INTO `gms_auth_rule` VALUES ('41', '40', 'Admin/AuthGroup/add', '新增', 'iconfont icon-form', '1', '1', '1', '1', '');
INSERT INTO `gms_auth_rule` VALUES ('42', '40', 'Admin/AuthGroup/edit', '编辑', 'iconfont icon-form', '1', '1', '1', '1', '');
INSERT INTO `gms_auth_rule` VALUES ('43', '40', 'Admin/AuthGroup/del', '删除', 'iconfont icon-form', '1', '1', '1', '1', '');
INSERT INTO `gms_auth_rule` VALUES ('44', '1', '', '数据库管理', 'iconfont icon-form', '1', '0', '1', '8', '');
INSERT INTO `gms_auth_rule` VALUES ('51', '2', '', '用户管理', 'iconfont icon-form', '1', '0', '1', '1', '');
INSERT INTO `gms_auth_rule` VALUES ('53', '1', '', '系统设置', 'iconfont icon-form', '1', '0', '1', '1', '');
INSERT INTO `gms_auth_rule` VALUES ('54', '44', 'Admin/Database/export_list', '备份数据库', 'iconfont icon-form', '1', '0', '1', '1', '');
INSERT INTO `gms_auth_rule` VALUES ('55', '44', 'Admin/Database/import_list', '还原数据库', 'iconfont icon-form', '1', '0', '1', '2', '');
INSERT INTO `gms_auth_rule` VALUES ('65', '53', 'Admin/Config/group', '系统设置', 'iconfont icon-form', '1', '0', '1', '1', '');
INSERT INTO `gms_auth_rule` VALUES ('73', '54', 'Admin/Database/optimize', '优化表', 'iconfont icon-form', '0', '1', '1', '1', '');
INSERT INTO `gms_auth_rule` VALUES ('74', '54', 'Admin/Database/repair', '修复表', 'iconfont icon-form', '0', '1', '1', '1', '');
INSERT INTO `gms_auth_rule` VALUES ('75', '54', 'Admin/Database/export', '备份', 'iconfont icon-form', '0', '1', '1', '1', '');
INSERT INTO `gms_auth_rule` VALUES ('76', '55', 'Admin/Database/import', '还原', 'iconfont icon-form', '0', '1', '1', '1', '');
INSERT INTO `gms_auth_rule` VALUES ('77', '55', 'Admin/Database/del', '删除', 'iconfont icon-form', '0', '1', '1', '1', '');

-- ----------------------------
-- Table structure for `gms_config`
-- ----------------------------
DROP TABLE IF EXISTS `gms_config`;
CREATE TABLE `gms_config` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '配置ID',
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '配置名称',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '配置类型',
  `title` varchar(50) NOT NULL DEFAULT '' COMMENT '配置标题',
  `group` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '配置分组',
  `extra` varchar(255) NOT NULL COMMENT '配置参数',
  `remark` varchar(100) NOT NULL COMMENT '说明',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` int(10) unsigned NOT NULL DEFAULT '1' COMMENT '状态',
  `value` text COMMENT '配置值',
  `sort` int(5) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_name` (`name`),
  KEY `type` (`type`),
  KEY `group` (`group`)
) ENGINE=MyISAM AUTO_INCREMENT=39 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gms_config
-- ----------------------------
INSERT INTO `gms_config` VALUES ('1', 'WEB_SITE_TITLE', '1', '网站标题', '1', '', '网站标题前台显示标题', '1378898976', '1379235274', '1', 'Gms管理系统', '0');
INSERT INTO `gms_config` VALUES ('2', 'WEB_SITE_DESCRIPTION', '2', '网站描述', '1', '', '网站搜索引擎描述', '1378898976', '1379235841', '1', 'Gms管理系统', '1');
INSERT INTO `gms_config` VALUES ('3', 'WEB_SITE_KEYWORD', '2', '网站关键字', '1', '', '网站搜索引擎关键字', '1378898976', '1381390100', '1', 'Gms管理系统', '8');
INSERT INTO `gms_config` VALUES ('4', 'WEB_SITE_CLOSE', '4', '关闭站点', '1', '0:关闭|1:开启', '站点关闭后其他用户不能访问，管理员可以正常访问', '1378898976', '1379235296', '1', '1', '1');
INSERT INTO `gms_config` VALUES ('9', 'CONFIG_TYPE_LIST', '3', '配置类型列表', '4', '', '主要用于数据解析和页面表单的生成', '1378898976', '1379235348', '1', '0:数字|1:字符|2:文本|3:数组|4:枚举|5:编辑器', '2');
INSERT INTO `gms_config` VALUES ('10', 'WEB_SITE_ICP', '1', '网站备案号', '1', '', '设置在网站底部显示的备案号，如“沪ICP备12007941号-2', '1378900335', '1379235859', '1', 'asd', '9');
INSERT INTO `gms_config` VALUES ('20', 'CONFIG_GROUP_LIST', '3', '配置分组', '4', '', '配置分组', '1379228036', '1384418383', '1', '1:基本|2:内容|3:用户|4:系统', '4');
INSERT INTO `gms_config` VALUES ('28', 'DATA_BACKUP_PATH', '1', '数据库备份根路径', '4', '', '路径必须以 / 结尾', '1381482411', '1381482411', '1', './Data/', '5');
INSERT INTO `gms_config` VALUES ('29', 'DATA_BACKUP_PART_SIZE', '0', '数据库备份卷大小', '4', '', '该值用于限制压缩后的分卷最大长度。单位：B；建议设置20M', '1381482488', '1381729564', '1', '20971520', '7');
INSERT INTO `gms_config` VALUES ('30', 'DATA_BACKUP_COMPRESS', '4', '数据库备份文件是否启用压缩', '4', '0:不压缩|1:启用压缩', '压缩备份文件需要PHP环境支持gzopen,gzwrite函数', '1381713345', '1381729544', '1', '1', '9');
INSERT INTO `gms_config` VALUES ('31', 'DATA_BACKUP_COMPRESS_LEVEL', '4', '数据库备份文件压缩级别', '4', '1:普通|4:一般|9:最高', '数据库备份文件的压缩级别，该配置在开启压缩时生效', '1381713408', '1381713408', '1', '1', '10');
INSERT INTO `gms_config` VALUES ('37', 'SHOW_PAGE_TRACE', '4', '是否显示页面Trace信息', '4', '0:关闭|1:开启', '是否显示页面Trace信息', '1387165685', '1387165685', '1', '0', '1');

-- ----------------------------
-- Table structure for `gms_user`
-- ----------------------------
DROP TABLE IF EXISTS `gms_user`;
CREATE TABLE `gms_user` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `username` varchar(32) NOT NULL COMMENT '用户名',
  `nickname` varchar(120) DEFAULT NULL COMMENT '真实姓名',
  `password` varchar(64) NOT NULL COMMENT '用户密码',
  `group_id` int(3) DEFAULT NULL COMMENT '注册类型',
  `create_time` int(11) unsigned NOT NULL COMMENT '注册日期',
  `update_time` int(11) unsigned NOT NULL COMMENT '最后修改时间',
  `logip` varchar(20) DEFAULT NULL COMMENT '上次登录IP',
  `logdatetime` int(11) unsigned NOT NULL COMMENT '上次登录时间',
  `remark` varchar(255) DEFAULT NULL COMMENT '备注',
  `status` int(3) DEFAULT '1' COMMENT '验证/状态',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gms_user
-- ----------------------------
INSERT INTO `gms_user` VALUES ('1', 'admin', '超级管理员', 'admin', '1', '0', '0', '', '0', '', '1');
