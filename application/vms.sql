-- MySQL dump 10.13  Distrib 5.5.32, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: mincms
-- ------------------------------------------------------
-- Server version   5.5.32-0ubuntu0.12.04.1
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO,NO_TABLE_OPTIONS' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

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
);
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
);
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_article_group`
--

LOCK TABLES `tbl_article_group` WRITE;
/*!40000 ALTER TABLE `tbl_article_group` DISABLE KEYS */;
INSERT INTO `tbl_article_group` VALUES (2,'????',-1,0,0,1,'2014-11-05 16:28:08','');
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
);
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_module`
--

LOCK TABLES `tbl_module` WRITE;
/*!40000 ALTER TABLE `tbl_module` DISABLE KEYS */;
INSERT INTO `tbl_module` VALUES (1,'????','??????','admin/module',1,NULL),(2,'????','????','admin/role',1,NULL),(3,'????','????','admin/user',1,NULL);
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
);
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_module_group`
--

LOCK TABLES `tbl_module_group` WRITE;
/*!40000 ALTER TABLE `tbl_module_group` DISABLE KEYS */;
INSERT INTO `tbl_module_group` VALUES (1,'????','??????????',NULL),(2,'CMS??','',1415204598);
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
);
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
);
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
);
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_role`
--

LOCK TABLES `tbl_role` WRITE;
/*!40000 ALTER TABLE `tbl_role` DISABLE KEYS */;
INSERT INTO `tbl_role` VALUES (1,'admin',NULL),(2,'test',1415260078);
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
);
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_role_module_r`
--

LOCK TABLES `tbl_role_module_r` WRITE;
/*!40000 ALTER TABLE `tbl_role_module_r` DISABLE KEYS */;
INSERT INTO `tbl_role_module_r` VALUES (1,2,3,1415260078);
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
);
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_user`
--

LOCK TABLES `tbl_user` WRITE;
/*!40000 ALTER TABLE `tbl_user` DISABLE KEYS */;
INSERT INTO `tbl_user` VALUES (1,'alvayang','f3649101aa4bc166beaed9139c139541','alvayang','y@rushucloud.com','images/empty.jpg',1,1415195321,'0'),(2,'test','098f6bcd4621d373cade4e832627b4f6','test','test@1in1.cn','images/empty.jpg',2,1415261020,'0');
/*!40000 ALTER TABLE `tbl_user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-11-21 20:05:26
