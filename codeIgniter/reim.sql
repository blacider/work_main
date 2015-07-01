-- MySQL dump 10.13  Distrib 5.5.38, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: reimadmin
-- ------------------------------------------------------
-- Server version	5.5.38-0+wheezy1-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `tbl_apps`
--

DROP TABLE IF EXISTS `tbl_apps`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_apps` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增主键',
  `version` varchar(45) DEFAULT NULL COMMENT '版本',
  `platform` int(11) NOT NULL DEFAULT '-1' COMMENT '平台',
  `create_time` int(11) DEFAULT NULL COMMENT '创建的时间',
  `path` varchar(1024) NOT NULL DEFAULT '' COMMENT '文件存储路径',
  `online` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=186 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_apps`
--

LOCK TABLES `tbl_apps` WRITE;
/*!40000 ALTER TABLE `tbl_apps` DISABLE KEYS */;
INSERT INTO `tbl_apps` VALUES (184,'1.1.1',1,1434454563,'statics/users_data/a8/7f/4/2015/06/69096345535295cb06b25b1649d234bf.apk',0),(185,'1.1',0,1434456285,'statics/users_data/16/79/6/2015/06/f15be1fdf9c3b31916223cb770445539.ipa',1);
/*!40000 ALTER TABLE `tbl_apps` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_article`
--

DROP TABLE IF EXISTS `tbl_article`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_article` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增主键',
  `uid` int(9) NOT NULL COMMENT '管理员id',
  `title` varchar(255) NOT NULL COMMENT '文章标题',
  `content` text NOT NULL COMMENT '文章正文',
  `group_id` int(11) NOT NULL COMMENT '所属的分类',
  `picture_id` int(11) NOT NULL COMMENT '文章图片对应的资源id',
  `video_id` int(11) NOT NULL COMMENT '文章视频对应的资源id',
  `file_id` int(11) NOT NULL COMMENT '文章文档对应的资源id',
  `recommand` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否推荐',
  `times` int(11) NOT NULL DEFAULT '0' COMMENT '阅读次数',
  `stick` int(11) NOT NULL DEFAULT '0' COMMENT '置顶',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建的时间',
  `update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '最后更新的时间',
  PRIMARY KEY (`id`),
  KEY `article_pid` (`group_id`),
  CONSTRAINT `article_pid` FOREIGN KEY (`group_id`) REFERENCES `tbl_article_group` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_article`
--

LOCK TABLES `tbl_article` WRITE;
/*!40000 ALTER TABLE `tbl_article` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_article` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_article_group`
--

DROP TABLE IF EXISTS `tbl_article_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_article_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增主键',
  `name` varchar(20) NOT NULL COMMENT '分类名',
  `pid` int(11) NOT NULL COMMENT '父类id',
  `picture` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否包含图片',
  `file` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否包含文件',
  `video` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否包含视频',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '创建时间',
  `module_thumb` text NOT NULL COMMENT '模块配图',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_article_group`
--

LOCK TABLES `tbl_article_group` WRITE;
/*!40000 ALTER TABLE `tbl_article_group` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_article_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_module`
--

DROP TABLE IF EXISTS `tbl_module`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_module` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增主键',
  `title` varchar(45) DEFAULT NULL COMMENT '模块名称',
  `description` varchar(45) DEFAULT NULL COMMENT '模块描述',
  `path` varchar(45) DEFAULT NULL COMMENT '模块对应的路径',
  `group_id` int(11) DEFAULT NULL COMMENT '分组id',
  `create_time` int(11) DEFAULT NULL COMMENT '创建的时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_module`
--

LOCK TABLES `tbl_module` WRITE;
/*!40000 ALTER TABLE `tbl_module` DISABLE KEYS */;
INSERT INTO `tbl_module` VALUES (1,'模块管理','管理功能模块','admin/module',1,NULL),(2,'角色管理','角色管理','admin/role',1,NULL),(3,'用户管理','用户管理','admin/user',1,NULL),(4,' 分类管理',' 公司可用分类管理','category',2,1416931832),(5,'标签管理','公司标签管理','tags',2,1416931882),(7,'人员架构管理','公司人员架构管理','relations',2,1416931976),(9,'人员管理','公司人员管理','groups',2,1416999960),(10,'分发包管理','分发包管理','admin/release',1,1417075497),(11,'报销管理','报表，报销管理','invoice',3,1418189506),(12,'报表管理','报表管理','report',3,1418189531),(14,'报销条目管理','报销条目管理','items',4,1420697669),(16,'后台任务','后台任务的运行情况','tasks',1,1421912416),(17,'客服消息管理','客服消息管理','admin/comments',1,1421989099);
/*!40000 ALTER TABLE `tbl_module` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_module_group`
--

DROP TABLE IF EXISTS `tbl_module_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_module_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增主键',
  `title` varchar(45) DEFAULT NULL COMMENT '模块分组名称',
  `description` varchar(300) DEFAULT NULL COMMENT '模块分组描述',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_module_group`
--

LOCK TABLES `tbl_module_group` WRITE;
/*!40000 ALTER TABLE `tbl_module_group` DISABLE KEYS */;
INSERT INTO `tbl_module_group` VALUES (1,'系统设置','系统级设置的相关模块',NULL),(2,'公司管理','',1416931832),(3,'报销管理','',1418189506),(4,'我的报销','',1420697669);
/*!40000 ALTER TABLE `tbl_module_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_module_tip`
--

DROP TABLE IF EXISTS `tbl_module_tip`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_module_tip` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增主键',
  `module_id` int(11) DEFAULT NULL COMMENT '模块编号',
  `module_tip` varchar(450) DEFAULT NULL COMMENT '提示内容',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `status` tinyint(4) DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_module_tip`
--

LOCK TABLES `tbl_module_tip` WRITE;
/*!40000 ALTER TABLE `tbl_module_tip` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_module_tip` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_resouce`
--

DROP TABLE IF EXISTS `tbl_resouce`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_resouce` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增主键',
  `path` varchar(4096) NOT NULL COMMENT '文件的相对路径',
  `type` int(11) NOT NULL COMMENT '文件类型:1 图片， 2 文档 3 视频',
  `creator` int(11) NOT NULL COMMENT '上传者',
  `creat_dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '上传时间',
  `status` int(11) NOT NULL COMMENT '主要针对视频，用于标记转码。',
  `hash` varchar(32) DEFAULT NULL COMMENT '文件的md5',
  `src_name` varchar(4096) DEFAULT NULL COMMENT '转码后的文件名',
  `display_name` varchar(200) DEFAULT NULL COMMENT '显示的名称',
  `src_path` text COMMENT '原始的文件路径',
  PRIMARY KEY (`id`),
  KEY `hash` (`hash`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_resouce`
--

LOCK TABLES `tbl_resouce` WRITE;
/*!40000 ALTER TABLE `tbl_resouce` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_resouce` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_role`
--

DROP TABLE IF EXISTS `tbl_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增编号',
  `name` varchar(45) DEFAULT NULL COMMENT '角色名称',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_role`
--

LOCK TABLES `tbl_role` WRITE;
/*!40000 ALTER TABLE `tbl_role` DISABLE KEYS */;
INSERT INTO `tbl_role` VALUES (1,'admin',NULL),(2,'公司用户',1416932938);
/*!40000 ALTER TABLE `tbl_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_role_module_r`
--

DROP TABLE IF EXISTS `tbl_role_module_r`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_role_module_r` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增主键',
  `role_id` int(11) DEFAULT NULL COMMENT '角色编号',
  `module_id` int(11) DEFAULT NULL COMMENT '模块编号',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_role_module_r`
--

LOCK TABLES `tbl_role_module_r` WRITE;
/*!40000 ALTER TABLE `tbl_role_module_r` DISABLE KEYS */;
INSERT INTO `tbl_role_module_r` VALUES (17,2,4,1420717386),(18,2,5,1420717386),(19,2,7,1420717386),(20,2,9,1420717386),(21,2,14,1420717386);
/*!40000 ALTER TABLE `tbl_role_module_r` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_user`
--

DROP TABLE IF EXISTS `tbl_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增主键',
  `username` varchar(48) DEFAULT NULL COMMENT '用户名',
  `password` varchar(48) DEFAULT NULL COMMENT '密码',
  `nickname` varchar(48) DEFAULT NULL COMMENT '昵称',
  `email` varchar(64) DEFAULT NULL COMMENT '邮箱',
  `pic_url` varchar(64) DEFAULT 'images/empty.jpg' COMMENT '头像',
  `role_id` int(11) DEFAULT NULL COMMENT '角色',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `status` char(2) NOT NULL DEFAULT '0' COMMENT '状态，是否锁定',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username_UNIQUE` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_user`
--

LOCK TABLES `tbl_user` WRITE;
/*!40000 ALTER TABLE `tbl_user` DISABLE KEYS */;
INSERT INTO `tbl_user` VALUES (1,'alvayang','f3649101aa4bc166beaed9139c139541','alvayang','y@rushucloud.com','images/empty.jpg',1,1415195321,'0'),(4,'antianyu','e27212a0bb8977fd2ea15e165531953b','antianyu','','images/empty.jpg',1,1418801801,'0'),(5,'gaoxinyi','881992de365f0fa30e87e1de7e7ad902','高欣艺','xinyi.gao@cloudbaoxiao.com','images/empty.jpg',1,1421915562,'0'),(6,'ljingjie','1c1f56f1fa2534751fa2c1c7ddb08175','李敬杰','jingjie.li@cloudbaoxiao.com','images/empty.jpg',1,1426669592,'0');
/*!40000 ALTER TABLE `tbl_user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-06-24 10:23:41
