/*
SQLyog Community Edition- MySQL GUI v8.05 
MySQL - 5.1.37 : Database - akk
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

CREATE DATABASE /*!32312 IF NOT EXISTS*/`akk` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `akk`;

/*Table structure for table `akk_category` */

DROP TABLE IF EXISTS `akk_category`;

CREATE TABLE `akk_category` (
  `category_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category_name` varchar(128) DEFAULT NULL,
  `date_added` int(10) DEFAULT NULL,
  `added_by` int(10) DEFAULT NULL,
  `date_modified` int(10) DEFAULT NULL,
  `modified_by` int(10) DEFAULT NULL,
  `date_deleted` int(10) DEFAULT NULL,
  `deleted_by` int(10) DEFAULT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

/*Table structure for table `akk_district` */

DROP TABLE IF EXISTS `akk_district`;

CREATE TABLE `akk_district` (
  `district_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `district_name` varchar(128) DEFAULT NULL,
  `region_id` int(10) DEFAULT NULL,
  `date_added` int(10) DEFAULT NULL,
  `added_by` int(10) DEFAULT NULL,
  `date_modified` int(10) DEFAULT NULL,
  `modified_by` int(10) DEFAULT NULL,
  `date_deleted` int(10) DEFAULT NULL,
  `deleted_by` int(10) DEFAULT NULL,
  PRIMARY KEY (`district_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2740 DEFAULT CHARSET=latin1;

/*Table structure for table `akk_isite` */

DROP TABLE IF EXISTS `akk_isite`;

CREATE TABLE `akk_isite` (
  `isite_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cell_site_id` varchar(128) DEFAULT NULL,
  `isite_name` varchar(128) DEFAULT NULL,
  `district_id` int(10) DEFAULT NULL,
  `date_added` int(10) DEFAULT NULL,
  `added_by` int(10) DEFAULT NULL,
  `date_modified` int(10) DEFAULT NULL,
  `modified_by` int(10) DEFAULT NULL,
  `date_deleted` int(10) DEFAULT NULL,
  `deleted_by` int(10) DEFAULT NULL,
  PRIMARY KEY (`isite_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6952 DEFAULT CHARSET=latin1;

/*Table structure for table `akk_isite_issue` */

DROP TABLE IF EXISTS `akk_isite_issue`;

CREATE TABLE `akk_isite_issue` (
  `isite_issue_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `isite_id` int(10) DEFAULT NULL,
  `issue_id` int(10) DEFAULT NULL,
  `response` int(1) DEFAULT NULL,
  `image_url` varchar(128) DEFAULT NULL,
  `date_added` int(10) DEFAULT NULL,
  `added_by` int(10) DEFAULT NULL,
  `date_modified` int(10) DEFAULT NULL,
  `modified_by` int(10) DEFAULT NULL,
  `date_deleted` int(10) DEFAULT NULL,
  `deleted_by` int(10) DEFAULT NULL,
  PRIMARY KEY (`isite_issue_id`),
  KEY `NewIndex1` (`isite_id`,`issue_id`)
) ENGINE=MyISAM AUTO_INCREMENT=940726 DEFAULT CHARSET=latin1;

/*Table structure for table `akk_isite_operator` */

DROP TABLE IF EXISTS `akk_isite_operator`;

CREATE TABLE `akk_isite_operator` (
  `isite_operator_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `isite_id` int(10) DEFAULT NULL,
  `operator_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`isite_operator_id`),
  KEY `NewIndex1` (`isite_id`,`operator_id`)
) ENGINE=MyISAM AUTO_INCREMENT=30632 DEFAULT CHARSET=latin1;

/*Table structure for table `akk_issue` */

DROP TABLE IF EXISTS `akk_issue`;

CREATE TABLE `akk_issue` (
  `issue_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `issue_text` varchar(256) DEFAULT NULL,
  `category_id` int(10) DEFAULT NULL,
  `non_compliant_response` int(1) DEFAULT NULL,
  `excel_column` int(2) DEFAULT NULL,
  `date_added` int(10) DEFAULT NULL,
  `added_by` int(10) DEFAULT NULL,
  `date_modified` int(10) DEFAULT NULL,
  `modified_by` int(10) DEFAULT NULL,
  `date_deleted` int(10) DEFAULT NULL,
  `deleted_by` int(10) DEFAULT NULL,
  PRIMARY KEY (`issue_id`)
) ENGINE=MyISAM AUTO_INCREMENT=46 DEFAULT CHARSET=latin1;

/*Table structure for table `akk_operator` */

DROP TABLE IF EXISTS `akk_operator`;

CREATE TABLE `akk_operator` (
  `operator_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `operator_name` varchar(128) DEFAULT NULL,
  `date_added` int(10) DEFAULT NULL,
  `added_by` int(10) DEFAULT NULL,
  `date_modified` int(10) DEFAULT NULL,
  `modified_by` int(10) DEFAULT NULL,
  `date_deleted` int(10) DEFAULT NULL,
  `deleted_by` int(10) DEFAULT NULL,
  PRIMARY KEY (`operator_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

/*Table structure for table `akk_psite` */

DROP TABLE IF EXISTS `akk_psite`;

CREATE TABLE `akk_psite` (
  `psite_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cell_site_id` varchar(128) DEFAULT NULL,
  `psite_name` varchar(128) DEFAULT NULL,
  `district_id` int(10) DEFAULT NULL,
  `f1` decimal(15,9) DEFAULT NULL,
  `pd1` decimal(15,9) DEFAULT NULL,
  `ic1` decimal(15,9) DEFAULT NULL,
  `f2` decimal(15,9) DEFAULT NULL,
  `pd2` decimal(15,9) DEFAULT NULL,
  `ic2` decimal(15,9) DEFAULT NULL,
  `f3` decimal(15,9) DEFAULT NULL,
  `pd3` decimal(15,9) DEFAULT NULL,
  `ic3` decimal(15,9) DEFAULT NULL,
  `f4` decimal(15,9) DEFAULT NULL,
  `pd4` decimal(15,9) DEFAULT NULL,
  `ic4` decimal(15,9) DEFAULT NULL,
  `f5` decimal(15,9) DEFAULT NULL,
  `pd5` decimal(15,9) DEFAULT NULL,
  `ic5` decimal(15,9) DEFAULT NULL,
  `f6` decimal(15,9) DEFAULT NULL,
  `pd6` decimal(15,9) DEFAULT NULL,
  `ic6` decimal(15,9) DEFAULT NULL,
  `f7` decimal(15,9) DEFAULT NULL,
  `pd7` decimal(15,9) DEFAULT NULL,
  `ic7` decimal(15,9) DEFAULT NULL,
  `f8` decimal(15,9) DEFAULT NULL,
  `pd8` decimal(15,9) DEFAULT NULL,
  `ic8` decimal(15,9) DEFAULT NULL,
  `f9` decimal(15,9) DEFAULT NULL,
  `pd9` decimal(15,9) DEFAULT NULL,
  `ic9` decimal(15,9) DEFAULT NULL,
  `f10` decimal(15,9) DEFAULT NULL,
  `pd10` decimal(15,9) DEFAULT NULL,
  `ic10` decimal(15,9) DEFAULT NULL,
  `date_added` int(10) DEFAULT NULL,
  `added_by` int(10) DEFAULT NULL,
  `date_modified` int(10) DEFAULT NULL,
  `modified_by` int(10) DEFAULT NULL,
  `date_deleted` int(10) DEFAULT NULL,
  `deleted_by` int(10) DEFAULT NULL,
  PRIMARY KEY (`psite_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5563 DEFAULT CHARSET=latin1;

/*Table structure for table `akk_psite_operator` */

DROP TABLE IF EXISTS `akk_psite_operator`;

CREATE TABLE `akk_psite_operator` (
  `psite_operator_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `psite_id` int(10) DEFAULT NULL,
  `operator_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`psite_operator_id`)
) ENGINE=MyISAM AUTO_INCREMENT=38935 DEFAULT CHARSET=latin1;

/*Table structure for table `akk_region` */

DROP TABLE IF EXISTS `akk_region`;

CREATE TABLE `akk_region` (
  `region_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `region_name` varchar(128) DEFAULT NULL,
  `date_added` int(10) DEFAULT NULL,
  `added_by` int(10) DEFAULT NULL,
  `date_modified` int(10) DEFAULT NULL,
  `modified_by` int(10) DEFAULT NULL,
  `date_deleted` int(10) DEFAULT NULL,
  `deleted_by` int(10) DEFAULT NULL,
  PRIMARY KEY (`region_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

/*Table structure for table `akk_user` */

DROP TABLE IF EXISTS `akk_user`;

CREATE TABLE `akk_user` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(128) DEFAULT NULL,
  `password` varchar(128) DEFAULT NULL,
  `user_type_id` int(1) DEFAULT NULL,
  `is_active` int(1) DEFAULT NULL,
  `date_added` int(10) DEFAULT NULL,
  `added_by` int(10) DEFAULT NULL,
  `date_modified` int(10) DEFAULT NULL,
  `modified_by` int(10) DEFAULT NULL,
  `date_deleted` int(10) DEFAULT NULL,
  `deleted_by` int(10) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
