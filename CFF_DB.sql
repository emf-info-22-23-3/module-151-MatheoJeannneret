CREATE DATABASE  IF NOT EXISTS `jeanneretm_CFF_DB` /*!40100 DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci */;
USE `jeanneretm_CFF_DB`;
-- MySQL dump 10.13  Distrib 8.0.40, for Win64 (x86_64)
--
-- Host: emf-informatique.ch    Database: jeanneretm_CFF_DB
-- ------------------------------------------------------
-- Server version	5.5.5-10.6.20-MariaDB-cll-lve

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `t_horaire`
--

DROP TABLE IF EXISTS `t_horaire`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `t_horaire` (
  `pk_horaire` int(11) NOT NULL AUTO_INCREMENT,
  `dateDepart` date NOT NULL,
  `fk_localite_depart` int(11) NOT NULL,
  `fk_localite_destination` int(11) NOT NULL,
  `fk_typeTrain` int(11) NOT NULL,
  PRIMARY KEY (`pk_horaire`),
  KEY `fk_t_horaire_t_localite1_idx` (`fk_localite_depart`),
  KEY `fk_t_horaire_t_localite2_idx` (`fk_localite_destination`),
  KEY `fk_t_horaire_t_typeTrain1_idx` (`fk_typeTrain`),
  CONSTRAINT `fk_t_horaire_t_localite1` FOREIGN KEY (`fk_localite_depart`) REFERENCES `t_localite` (`pk_localite`),
  CONSTRAINT `fk_t_horaire_t_localite2` FOREIGN KEY (`fk_localite_destination`) REFERENCES `t_localite` (`pk_localite`),
  CONSTRAINT `fk_t_horaire_t_typeTrain1` FOREIGN KEY (`fk_typeTrain`) REFERENCES `t_typeTrain` (`pk_typeTrain`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_horaire`
--

LOCK TABLES `t_horaire` WRITE;
/*!40000 ALTER TABLE `t_horaire` DISABLE KEYS */;
INSERT INTO `t_horaire` VALUES (11,'2025-05-12',60,55,12);
/*!40000 ALTER TABLE `t_horaire` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_localite`
--

DROP TABLE IF EXISTS `t_localite`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `t_localite` (
  `pk_localite` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(60) NOT NULL,
  PRIMARY KEY (`pk_localite`),
  UNIQUE KEY `nom_UNIQUE` (`nom`)
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_localite`
--

LOCK TABLES `t_localite` WRITE;
/*!40000 ALTER TABLE `t_localite` DISABLE KEYS */;
INSERT INTO `t_localite` VALUES (87,'Aarau'),(83,'Baar'),(90,'Baden'),(53,'Basel'),(79,'Bellinzona'),(55,'Bern'),(60,'Biel/Bienne'),(77,'Bulle'),(99,'Burgdorf'),(94,'Carouge'),(76,'Chur'),(92,'Dietikon'),(70,'Emmen'),(64,'Fribourg'),(52,'Genève'),(100,'Gossau'),(62,'Köniz'),(97,'Kreuzlingen'),(74,'Kriens'),(63,'La Chaux-de-Fonds'),(68,'Lancy'),(54,'Lausanne'),(85,'Locarno'),(59,'Lugano'),(57,'Luzern'),(93,'Meyrin'),(82,'Montreux'),(69,'Neuchâtel'),(80,'Olten'),(95,'Onex'),(78,'Pully'),(73,'Rapperswil-Jona'),(88,'Renens'),(91,'Riehen'),(75,'Schaffhausen'),(84,'Sierre'),(66,'Sion'),(58,'St. Gallen'),(98,'Steffisburg'),(89,'Thalwil'),(61,'Thun'),(67,'Uster'),(65,'Vernier'),(86,'Wädenswil'),(96,'Wetzikon'),(81,'Wil'),(56,'Winterthur'),(72,'Yverdon-les-Bains'),(71,'Zug'),(51,'Zürich');
/*!40000 ALTER TABLE `t_localite` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_typeTrain`
--

DROP TABLE IF EXISTS `t_typeTrain`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `t_typeTrain` (
  `pk_typeTrain` int(11) NOT NULL AUTO_INCREMENT,
  `nomComplet` varchar(30) NOT NULL,
  `abreviation` varchar(3) NOT NULL,
  PRIMARY KEY (`pk_typeTrain`),
  UNIQUE KEY `type_UNIQUE` (`nomComplet`),
  UNIQUE KEY `abreviation_UNIQUE` (`abreviation`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_typeTrain`
--

LOCK TABLES `t_typeTrain` WRITE;
/*!40000 ALTER TABLE `t_typeTrain` DISABLE KEYS */;
INSERT INTO `t_typeTrain` VALUES (12,'InterCity','IC'),(13,'InterRegio','IR'),(14,'RegioExpress','RE'),(15,'Regio','R'),(16,'S-Bahn (train de banlieue)','S'),(17,'EuroCity','EC'),(18,'EuroNight','EN'),(19,'InterCity Express','ICE'),(20,'Train à Grande Vitesse','TGV'),(21,'Railjet','RJ'),(22,'Panorama Express','PE');
/*!40000 ALTER TABLE `t_typeTrain` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_utilisateur`
--

DROP TABLE IF EXISTS `t_utilisateur`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `t_utilisateur` (
  `pk_utilisateur` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `is_admin` tinyint(1) NOT NULL,
  PRIMARY KEY (`pk_utilisateur`),
  UNIQUE KEY `nom_UNIQUE` (`nom`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_utilisateur`
--

LOCK TABLES `t_utilisateur` WRITE;
/*!40000 ALTER TABLE `t_utilisateur` DISABLE KEYS */;
INSERT INTO `t_utilisateur` VALUES (3,'jeanneret-user','$2y$10$OjAJnNKNNan5D6RJZUvLLO2TXEKNVvVH40rUgt.FHwFTSxoxEdAPS',0),(4,'jeanneret-admin','$2y$10$OjAJnNKNNan5D6RJZUvLLO2TXEKNVvVH40rUgt.FHwFTSxoxEdAPS',1);
/*!40000 ALTER TABLE `t_utilisateur` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-05-02 10:34:58
