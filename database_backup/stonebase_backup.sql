-- MySQL dump 10.13  Distrib 8.0.32, for Linux (x86_64)
--
-- Host: localhost    Database: stonebase
-- ------------------------------------------------------
-- Server version	8.0.32-0ubuntu0.22.04.2

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `Review`
--

DROP TABLE IF EXISTS `Review`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Review` (
  `u_id` int NOT NULL,
  `p_id` int NOT NULL,
  `score` int NOT NULL,
  `comment` varchar(228) DEFAULT NULL,
  PRIMARY KEY (`u_id`),
  KEY `p_id_idx` (`p_id`),
  CONSTRAINT `p_id_review` FOREIGN KEY (`p_id`) REFERENCES `product` (`p_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `u_id_review` FOREIGN KEY (`u_id`) REFERENCES `user` (`u_id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Review`
--

LOCK TABLES `Review` WRITE;
/*!40000 ALTER TABLE `Review` DISABLE KEYS */;
/*!40000 ALTER TABLE `Review` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employee`
--

DROP TABLE IF EXISTS `employee`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `employee` (
  `u_id` int NOT NULL,
  `salery` int DEFAULT NULL,
  `is_manager` tinyint DEFAULT NULL,
  PRIMARY KEY (`u_id`),
  UNIQUE KEY `u_id_UNIQUE` (`u_id`),
  CONSTRAINT `u_id_employee` FOREIGN KEY (`u_id`) REFERENCES `user` (`u_id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employee`
--

LOCK TABLES `employee` WRITE;
/*!40000 ALTER TABLE `employee` DISABLE KEYS */;
INSERT INTO `employee` VALUES (0,100000,1),(1,8,0);
/*!40000 ALTER TABLE `employee` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_item`
--

DROP TABLE IF EXISTS `order_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `order_item` (
  `o_id` int NOT NULL,
  `p_id` int NOT NULL,
  `quantity` int NOT NULL,
  `entry` int NOT NULL AUTO_INCREMENT,
  `price` int NOT NULL,
  PRIMARY KEY (`entry`),
  KEY `p_id_idx` (`p_id`),
  KEY `o_id_idx` (`o_id`),
  CONSTRAINT `o_id` FOREIGN KEY (`o_id`) REFERENCES `orders` (`o_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `p_id2` FOREIGN KEY (`p_id`) REFERENCES `product` (`p_id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_item`
--

LOCK TABLES `order_item` WRITE;
/*!40000 ALTER TABLE `order_item` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders` (
  `o_id` int NOT NULL AUTO_INCREMENT,
  `u_id` int NOT NULL,
  `order_date` timestamp(2) NOT NULL,
  PRIMARY KEY (`o_id`),
  UNIQUE KEY `o_id_UNIQUE` (`o_id`),
  KEY `u_id_idx` (`u_id`),
  CONSTRAINT `u_id` FOREIGN KEY (`u_id`) REFERENCES `user` (`u_id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (4,2,'2023-03-10 12:32:05.00'),(5,2,'2023-03-10 12:32:19.00'),(6,2,'2023-03-10 12:32:43.00'),(7,0,'2023-03-10 12:34:16.00'),(8,2,'2023-03-10 17:03:38.00');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product` (
  `p_id` int NOT NULL AUTO_INCREMENT,
  `price` int NOT NULL,
  `stock` int NOT NULL,
  `name` varchar(32) NOT NULL,
  `description` varchar(256) NOT NULL,
  `image` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`p_id`),
  UNIQUE KEY `p_id_UNIQUE` (`p_id`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product`
--

LOCK TABLES `product` WRITE;
/*!40000 ALTER TABLE `product` DISABLE KEYS */;
INSERT INTO `product` VALUES (1,500,0,'Doge','Dog','Images/doge.jpg'),(2,100,2,'Hellothere','Hello','Images/hellothere.jpg'),(3,200,15,'Gigachad','Giga','Images/gigachad.jpg'),(8,200,5,'Test','Test description','Images/hellothere.jpg');
/*!40000 ALTER TABLE `product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopping_cart`
--

DROP TABLE IF EXISTS `shopping_cart`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `shopping_cart` (
  `entry` int NOT NULL AUTO_INCREMENT,
  `c_id` int NOT NULL,
  `p_id` int NOT NULL,
  `quantity` int NOT NULL,
  PRIMARY KEY (`entry`),
  UNIQUE KEY `entry_UNIQUE` (`entry`),
  KEY `c_id_idx` (`c_id`),
  KEY `p_id_idx` (`p_id`),
  CONSTRAINT `c_id` FOREIGN KEY (`c_id`) REFERENCES `user` (`u_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `p_id` FOREIGN KEY (`p_id`) REFERENCES `product` (`p_id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopping_cart`
--

LOCK TABLES `shopping_cart` WRITE;
/*!40000 ALTER TABLE `shopping_cart` DISABLE KEYS */;
INSERT INTO `shopping_cart` VALUES (7,1,1,1),(14,2,1,1);
/*!40000 ALTER TABLE `shopping_cart` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `u_id` int NOT NULL,
  `u_name` varchar(32) NOT NULL,
  `u_password` varchar(128) NOT NULL,
  `f_name` varchar(32) NOT NULL,
  `l_name` varchar(32) NOT NULL,
  `email` varchar(128) NOT NULL,
  PRIMARY KEY (`u_id`),
  UNIQUE KEY `u_id_UNIQUE` (`u_id`),
  UNIQUE KEY `u_name_UNIQUE` (`u_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (0,'manager','test_password','Elon','Musk','EM@gmail.com'),(1,'Bob','1234','Bob','Bob','BB@gmail.com'),(2,'Ted','123','Ted ','Gson','TG@gmail.com');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-03-14 12:28:10
