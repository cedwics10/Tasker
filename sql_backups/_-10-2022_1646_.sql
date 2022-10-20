-- MariaDB dump 10.19  Distrib 10.4.24-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: tasker
-- ------------------------------------------------------
-- Server version	10.4.24-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categorie` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (29,'Cuisiner'),(30,'Maison'),(31,'Programmation');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `membres`
--

DROP TABLE IF EXISTS `membres`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `membres` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(20) NOT NULL,
  `mdp` varchar(100) NOT NULL,
  `photo` varchar(200) NOT NULL,
  `role` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `membres`
--

LOCK TABLES `membres` WRITE;
/*!40000 ALTER TABLE `membres` DISABLE KEYS */;
INSERT INTO `membres` VALUES (1,'bon','$2y$10$rXc7uw8aIQ57nxakqEEYEuDFJH4rebBqty.5LemVfDfNZp8nPSJ..','',0),(2,'tonpere','$2y$10$oc5X64xVLdZmn0qScdiWU.7e/W/EPPvGDc5DUTYhD27PucflIepyS','',0),(3,'cedric123','$2y$10$gPzgldUBNqdpML3bKVHv7uGeBjij4gpNGRTt2gZp.rAco8iJKBFp2','',0),(4,'cedric1234','$2y$10$YQAKjIJSN2hnYb26PkCNQeMGcHFNuCP.XgJUiOYm0bLhGiZ08S2LO','',0),(5,'filsdeawole','$2y$10$MKHZOoP2dQ4DDBuAcEsdOOeZZHCKUiKh/JCDV3CJMhnEnNq2VYdwK','',0),(6,'tamertamer','$2y$10$JzemEKEM.LIBk4ir.p7H6eySV3nWHDJazBr8vI8TSMBRD3VwrvI5i','',0),(7,'tamertamer2','$2y$10$TpP9iMz/lb8FGvyYrH7lUeWRxkBFK9y53D1cWiYMePh1bRKBwZezG','',0),(8,'moncaporal','$2y$10$ATYWoNM/S0pVmZQuBsK12uBF30B1THZqW5jt2x2f.gCigBJ4IbQ9C','',0),(9,'moncaporal2','$2y$10$Y9w3F7coTl21YvBiPVW48.YT436cUISlrHLLqsW1XRP2IcUWChIuu','',0),(10,'moncaporal3','$2y$10$in1QUVlRUYcC/RBPOVfUr.t1JNimrpRFQeG69PNRax8tPqCJMSxIm','',0),(11,'popopopopo','$2y$10$yCU5d4aNeti8nk73JzxyBOXjkltggPjH2C6zZuhP3TBDrolYj.ZKq','',0),(12,'popopopopo2','$2y$10$qGECr7alfEvza7/AY.4VKOk5Y7XwYmBYMDwSl75hiZ5fRXG5x9bGu','',0),(13,'moncaporalmoncaporal','$2y$10$Z47F.ju4ADzH014nUjgAteKkk4IbjefmWKOo2oZX1dskpGiqxSIaO','',0),(14,'moncaporal123','$2y$10$eCW0bLnsWVdQ6zRGarR5KOD7y3h9jAWWR.IbJir2s.3ngX0b8ucky','',0),(15,'baobehbaobehbaobeh','$2y$10$.SppU4sNGVFkTKVa7q9ABujjgP9JuV9Wz.eFavntrCdDOgFUt95xe','avatars/baobehbaobehbaobeh.jpg',0),(16,'bierebierebiere2','$2y$10$qmoW.FrE68jKyzVkygMtcuGH.S00VRGSYzT1uUm1ZaZXzwE2rpK1u','avatars/bierebierebiere2.jpg',0),(17,'Moncaporalchef','$2y$10$FxM2KlQ2MtuIHkvUQ3K82uyf0PJ3MOiFxMC5kxCyYhYrFMp44yQ0y','avatars/Moncaporalchef.jpg',0),(18,'','$2y$10$FxM2KlQ2MtuIHkvUQ3K82uyf0PJ3MOiFxMC5kxCyYhYrFMp44yQ0y','avatars/Moncaporalchef.jpg',0),(19,'','$2y$10$FxM2KlQ2MtuIHkvUQ3K82uyf0PJ3MOiFxMC5kxCyYhYrFMp44yQ0y','avatars/Moncaporalchef.jpg',0);
/*!40000 ALTER TABLE `membres` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `taches`
--

DROP TABLE IF EXISTS `taches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `taches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_categorie` int(11) NOT NULL,
  `nom_tache` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `rappel` timestamp NULL DEFAULT NULL,
  `importance` tinyint(4) NOT NULL,
  `complete` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `taches` (`id_categorie`),
  CONSTRAINT `taches` FOREIGN KEY (`id_categorie`) REFERENCES `categories` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `taches`
--

LOCK TABLES `taches` WRITE;
/*!40000 ALTER TABLE `taches` DISABLE KEYS */;
INSERT INTO `taches` VALUES (22,31,'Recoder le football 2','J\'aime pas le foot ni  codé !','2022-10-12 11:36:39','2022-10-26 22:00:00',2,1),(23,31,'Coder le football 2','J\'aime pas le foot mais faut que je me force hein !','2022-10-12 11:44:20','2022-10-25 22:00:00',1,1),(24,29,'Silence mon ami','','2022-10-09 22:00:00','2022-10-01 22:00:00',3,0),(25,30,'BATIR','','2022-10-12 11:31:51','2022-10-02 22:00:00',0,0),(26,30,'CONSTRUIRE','','2022-10-10 07:57:44','2022-09-30 22:00:00',0,0),(27,30,'CONSTRUIRE 2','','2022-10-09 09:20:20','2022-10-18 22:00:00',1,1),(28,30,'DST2','','2022-10-09 22:00:00','2022-10-02 22:00:00',1,0),(30,31,'promener la mascotte','','2022-10-09 09:20:16','2022-10-08 22:00:00',0,1),(31,31,'Programmer un site','Il faut absolument programmer le site.','2022-10-11 14:41:31','2022-10-24 22:00:00',0,1);
/*!40000 ALTER TABLE `taches` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-10-20 16:46:14
