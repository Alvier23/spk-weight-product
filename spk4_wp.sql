/*
SQLyog Enterprise v13.1.1 (64 bit)
MySQL - 10.4.14-MariaDB : Database - spk4_wp
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`spk4_wp` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `spk4_wp`;

/*Table structure for table `alternatif` */

DROP TABLE IF EXISTS `alternatif`;

CREATE TABLE `alternatif` (
  `id_alter` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(128) DEFAULT NULL,
  `alternatif` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id_alter`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4;

/*Data for the table `alternatif` */

insert  into `alternatif`(`id_alter`,`code`,`alternatif`) values 
(1,'R1','SMPN 1 SURABAYA'),
(2,'R2','SMPN 6 SURABAYA'),
(3,'R3','SMPN 20 SURABAYA'),
(4,'R4','SMPN 22 SURABAYA'),
(5,'R5','SMPN 26 SURABAYA'),
(10,'R6','SMPN 12 SURABAYA'),
(11,'R7','SMPN 15 SURABAYA'),
(12,'R8','SMPN 19 SURABAYA'),
(13,'R9','SMPN 2 SURABAYA'),
(14,'R10','SMPN 3 SURABAYA');

/*Table structure for table `bobot` */

DROP TABLE IF EXISTS `bobot`;

CREATE TABLE `bobot` (
  `id_bobot` int(11) NOT NULL AUTO_INCREMENT,
  `id_alter` int(11) DEFAULT NULL,
  `c1` int(128) DEFAULT NULL,
  `c2` int(128) DEFAULT NULL,
  `c3` int(128) DEFAULT NULL,
  `c4` int(128) DEFAULT NULL,
  `c5` int(128) DEFAULT NULL,
  PRIMARY KEY (`id_bobot`),
  KEY `id_alter` (`id_alter`),
  CONSTRAINT `bobot_ibfk_1` FOREIGN KEY (`id_alter`) REFERENCES `alternatif` (`id_alter`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

/*Data for the table `bobot` */

insert  into `bobot`(`id_bobot`,`id_alter`,`c1`,`c2`,`c3`,`c4`,`c5`) values 
(1,1,37,410,80,100,4),
(2,2,39,350,75,100,4),
(3,3,40,340,70,100,4),
(4,4,37,360,65,100,4),
(5,5,39,320,70,100,4),
(6,10,40,350,80,100,4),
(7,14,40,340,75,100,4);

/*Table structure for table `kriteria` */

DROP TABLE IF EXISTS `kriteria`;

CREATE TABLE `kriteria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(32) DEFAULT NULL,
  `kriteria` varchar(256) DEFAULT NULL,
  `jenis` varchar(32) DEFAULT NULL,
  `bobot` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

/*Data for the table `kriteria` */

insert  into `kriteria`(`id`,`code`,`kriteria`,`jenis`,`bobot`) values 
(1,'C1','Jumlah Siswa Per Kelas','cost',4),
(2,'C2','Fasilitas','benefit',5),
(3,'C3','Unsur Unsur Adiwiyata','benefit',4),
(4,'C4','Presentase Siswa Lulus UN','benefit',2),
(5,'C5','Akreditasi Sekolah','benefit',3);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
