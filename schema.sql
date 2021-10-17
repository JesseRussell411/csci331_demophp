-- MariaDB dump 10.19  Distrib 10.5.12-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: db60
-- ------------------------------------------------------
-- Server version	10.5.12-MariaDB

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
-- Table structure for table `friends`
--

DROP TABLE IF EXISTS `friends`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `friends` (
  `user` varchar(16) COLLATE utf8_bin DEFAULT NULL,
  `friend` varchar(16) COLLATE utf8_bin DEFAULT NULL,
  KEY `user` (`user`(6)),
  KEY `friend` (`friend`(6))
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `friends`
--

LOCK TABLES `friends` WRITE;
/*!40000 ALTER TABLE `friends` DISABLE KEYS */;
INSERT INTO `friends` VALUES ('w','garfield'),('w','garfield'),('f87','tim'),('member1','tim'),('tom','karen'),('member1','karen'),('f87','karen'),('bob','member1'),('tom','bob'),('tom','ted'),('tim','ted'),('member1','ted'),('karen','ted'),('john','ted'),('f87','ted'),('bob','ted'),('karen','tim'),('ted','karen'),('tim','karen');
/*!40000 ALTER TABLE `friends` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `marketplaceitems`
--

DROP TABLE IF EXISTS `marketplaceitems`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `marketplaceitems` (
  `user` varchar(256) COLLATE utf8_bin NOT NULL,
  `title` varchar(256) COLLATE utf8_bin NOT NULL,
  `description` text COLLATE utf8_bin NOT NULL,
  `price_cents` bigint(20) NOT NULL,
  PRIMARY KEY (`user`,`title`),
  CONSTRAINT `marketplaceitems_ibfk_1` FOREIGN KEY (`user`) REFERENCES `members` (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `marketplaceitems`
--

LOCK TABLES `marketplaceitems` WRITE;
/*!40000 ALTER TABLE `marketplaceitems` DISABLE KEYS */;
INSERT INTO `marketplaceitems` VALUES ('f87','half opened can of beans','can opener broke',700),('f87','long description test','The quick brown fox jumps over the lazy dog. The quick brown fox jumps over the lazy dog. The quick brown fox jumps over the lazy dog. The quick brown fox jumps over the lazy dog. The quick brown fox jumps over the lazy dog. The quick brown fox jumps over the lazy dog. The quick brown fox jumps over the lazy dog. The quick brown fox jumps over the lazy dog. The quick brown fox jumps over the lazy dog. The quick brown fox jumps over the lazy dog. The quick brown fox jumps over the lazy dog. The quick brown fox jumps over the lazy dog. The quick brown fox jumps over the lazy dog. The quick brown fox jumps over the lazy dog. The quick brown fox jumps over the lazy dog. The quick brown fox jumps over the lazy dog. The quick brown fox jumps over the lazy dog. The quick brown fox jumps over the lazy dog. The quick brown fox jumps over the lazy dog. The quick brown fox jumps over the lazy dog. The quick brown fox jumps over the lazy dog. The quick brown fox jumps over the lazy dog. The quick brown fox jumps over the lazy dog. The quick brown fox jumps over the lazy dog. The quick brown fox jumps over the lazy dog. The quick brown fox jumps over the lazy dog. The quick brown fox jumps over the lazy dog. The quick brown fox jumps over the lazy dog. The quick brown fox jumps over the lazy dog. The quick brown fox jumps over the lazy dog. The quick brown fox jumps over the lazy dog. The quick brown fox jumps over the lazy dog. The quick brown fox jumps over the lazy dog. The quick brown fox jumps over the lazy dog. ',100),('karen','Healing Crystal','',40004),('karen','Ionizer salt lamp','',100500),('karen','essential oils','',40004),('member1','Help I\'m trapped in a website factory!','',0),('member1','polymorphic pencil','',500),('ted','model train set','1:1 scale',555),('ted','office desk','no legs',555),('ted','pickled bread','',555),('tim','All the cement in the whole world','I bet you can\'t eat it all.',100),('tim','Pool','I have a large pool to sell. I don\'t know how you\'ll pick it up since it\'s an in-ground pool, but you can have it if you figure that out.',100004),('tim','Pool table','Actually a table in my pool, not a pool table.',10000),('tim','Quick dry water','',699),('tim','TV','No picture only sound. Great sound quality though. More than makes up for it.',1000),('tim','backpack','no straps',400),('tim','can of soda','empty',400),('tim','chair','no seat, only legs',203),('tim','dirt','why would anyone want dirt?',300),('tim','fridge','won\'t stop running',1204),('tim','garbage can','no bottom.',99),('tim','kitchen ceiling','Warning: only works in kitchens',40152),('tim','lawn mower','man',5402),('tim','php','You can have it. it\'s yours!',0),('tim','pipes','The pipe, the pipes are calling. The pipes. The pipes. Why. the pipes!',705),('tim','unicycle with 2 wheels','',55555555555500),('tim','used parachute','never opened. small stain',4404);
/*!40000 ALTER TABLE `marketplaceitems` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `members`
--

DROP TABLE IF EXISTS `members`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `members` (
  `user` varchar(256) COLLATE utf8_bin NOT NULL,
  `pass` varchar(256) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`user`),
  KEY `user` (`user`(6))
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `members`
--

LOCK TABLES `members` WRITE;
/*!40000 ALTER TABLE `members` DISABLE KEYS */;
INSERT INTO `members` VALUES ('bob','$2y$10$YFoErmvMZJWpdy.KrRMIS.i8bbdml5DR7Z7QQUJzoF/hCHR9SYjkC'),('eyespace','$2y$10$BLjrChuCTJJs6N8KMwS/LeZJR4yhXdQL9aMoYGYbcwaCO8vE6s1Iu'),('f87','$2y$10$qHZvEgeKhAJh0opHUPpU5OJAVqs1Ooq6BroGXAdxC3GFRVepSotXS'),('john','$2y$10$tJAWHyOp/8ewc7X/uOrfoOnnK67an41M51Uku/tT.dcAGaYYbhgSi'),('karen','$2y$10$51k5lVmx4RvEbGvEGG.kVeDTCH5tmnVtEEznys0At95UkTlcS.84S'),('member1','$2y$10$wY6WGAAzhuxfzJm.a8Mc9uwUcjtRuk9yKWW3pbmUpHo6UkcBhNbui'),('rob','$2y$10$SJVQldYkwjLFQT8fMRbmMeLucmjq67bifQK31PUR55adkM3DmeH2e'),('ted','$2y$10$dBjvd13KM3xbdJ4iVYyJvevW8eyeHEFE82WkbYZTdTpMQXjtf4dGK'),('teste','$2y$10$8uP4.em4Gkj.5SZiiw.bxOPuTFtjqWZu08bqXGJSfRZHJ44vcUcIa'),('tim','$2y$10$77h87hNKXsFhlksUbe/pgex4Uu5Wy6ApjLV6F5fTesPNEX1LWMGc.'),('tom','password');
/*!40000 ALTER TABLE `members` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `messages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `auth` varchar(16) COLLATE utf8_bin DEFAULT NULL,
  `recip` varchar(16) COLLATE utf8_bin DEFAULT NULL,
  `pm` char(1) COLLATE utf8_bin DEFAULT NULL,
  `time` int(10) unsigned DEFAULT NULL,
  `message` varchar(4096) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `auth` (`auth`(6)),
  KEY `recip` (`recip`(6))
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
INSERT INTO `messages` VALUES (1,'test','test','0',1632896871,'test message'),(2,'garfield','garfield','0',1633735890,'hello world'),(3,'tim','tim','0',1634324137,'eyespace?\r\nmore like eyesore!'),(4,'ted','ted','0',1634324180,'sick burn tom'),(5,'ted','ted','0',1634324192,'sick burn tom'),(6,'karen','karen','0',1634328010,'Where is the manager!');
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `profiles`
--

DROP TABLE IF EXISTS `profiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `profiles` (
  `user` varchar(16) COLLATE utf8_bin DEFAULT NULL,
  `text` varchar(4096) COLLATE utf8_bin DEFAULT NULL,
  KEY `user` (`user`(6))
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profiles`
--

LOCK TABLES `profiles` WRITE;
/*!40000 ALTER TABLE `profiles` DISABLE KEYS */;
INSERT INTO `profiles` VALUES ('garfield','I hate mondays'),('garfield','I hate mondays'),('tim','Hello, I am tim. Welcome to tim. here is tim. tim is me. I am tim. hello, My name is tim. tim. tim. tim. tim. tim. tim. tim.'),('karen','I want to speak to the manager!'),('ted','You are currently viewing my bio. Have a look. It\'s nice isn\'t it. Well. hello, I\'m ted. My name is ted. teeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeed.'),('eyespace',''),('rob','');
/*!40000 ALTER TABLE `profiles` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-10-15 17:53:33
