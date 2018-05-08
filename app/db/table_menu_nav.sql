/*
SQLyog Community v8.3 
MySQL - 5.5.5-10.1.30-MariaDB : Database - pulsa
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `menu_nav` */

DROP TABLE IF EXISTS `menu_nav`;

CREATE TABLE `menu_nav` (
  `menu_id` int(5) NOT NULL AUTO_INCREMENT,
  `submenu_id` int(5) DEFAULT NULL,
  `menu` varchar(50) DEFAULT NULL,
  `url` varchar(50) DEFAULT NULL,
  `icon_nav` varchar(20) DEFAULT NULL,
  `isParent` enum('1','0') DEFAULT NULL,
  PRIMARY KEY (`menu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

/*Data for the table `menu_nav` */

insert  into `menu_nav`(`menu_id`,`submenu_id`,`menu`,`url`,`icon_nav`,`isParent`) values (1,0,'Master','#','fa-database','1'),(2,0,'Pendonor','Pendonor','fa-user','0'),(3,0,'Donor Darah','#','fa-tint','1'),(4,3,'Pemeriksaan Pendonor','PemeriksaanPendonor','fa-circle-o nav-icon','0'),(5,3,'Pengambilan Darah','PengambilanDarah','fa-circle-o nav-icon','0'),(6,0,'Pengolahan Darah','#','fa-check-circle','1'),(7,6,'Data Screening','DataScreening','fa-circle-o nav-icon','0'),(8,6,'Data Komponen','DataKomponen','fa-circle-o nav-icon','0'),(9,6,'Data Cross Match','DataCrossMatch','fa-circle-o nav-icon','0'),(10,0,'Permintaan Darah','#','fa-shopping-cart','1'),(11,10,'Reguler','PermintaanDarahRegulaer','fa-circle-o nav-icon','0'),(12,10,'Dropping','PermintaanDarahDropping','fa-circle-o nav-icon','0'),(13,1,'Master Golongan Darah','MasterData/GolonganDarah','fa-circle-o nav-icon','0'),(14,0,'Manage Menu','Menu','fa-angellist','0'),(15,1,'Master Kantong Darah','MasterData/KantongDarah','fa-circle-o nav-icon','0');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
