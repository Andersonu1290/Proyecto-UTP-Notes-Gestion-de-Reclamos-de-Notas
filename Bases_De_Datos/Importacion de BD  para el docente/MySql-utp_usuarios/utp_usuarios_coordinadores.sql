-- MySQL dump 10.13  Distrib 8.0.42, for Win64 (x86_64)
--
-- Host: localhost    Database: utp_usuarios
-- ------------------------------------------------------
-- Server version	8.0.42

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
-- Table structure for table `coordinadores`
--

DROP TABLE IF EXISTS `coordinadores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `coordinadores` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre_completo` varchar(100) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `dni` varchar(10) DEFAULT NULL,
  `area` varchar(100) DEFAULT NULL,
  `fecha_ingreso` date DEFAULT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `direccion` varchar(150) DEFAULT NULL,
  `contraseña` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `coordinadores`
--

LOCK TABLES `coordinadores` WRITE;
/*!40000 ALTER TABLE `coordinadores` DISABLE KEYS */;
INSERT INTO `coordinadores` VALUES (1,'Ana Ramos','A12345678@utp.edu.pe','71234567','Ingeniería de Sistemas','2020-03-15','987654321','Av. Los Álamos 123','ana123'),(2,'Luis Vargas','A87654321@utp.edu.pe','69874512','Administración','2019-06-10','912345678','Calle Lima 456','luisv'),(3,'Marta López','A11112222@utp.edu.pe','70123456','Contabilidad','2021-01-20','999888777','Av. Arequipa 789','marta2021'),(4,'Carlos Díaz','A22223333@utp.edu.pe','74561234','Marketing','2018-09-05','988776655','Jr. Cusco 321','carlosd'),(5,'Paula Torres','A33334444@utp.edu.pe','73219876','Derecho','2022-02-28','987123456','Av. Benavides 987','paulita'),(6,'Jorge Meza','A44445555@utp.edu.pe','72345678','Psicología','2020-07-12','986543210','Calle Tarata 159','jorge2020'),(7,'Lucía Huamán','A55556666@utp.edu.pe','71654321','Arquitectura','2017-11-23','985432167','Jr. Bolognesi 741','luciah'),(8,'Marco Paredes','A66667777@utp.edu.pe','73456789','Ingeniería Industrial','2016-08-30','984321765','Av. Javier Prado 123','marcop'),(9,'Elena Ríos','A77778888@utp.edu.pe','76543210','Medicina','2023-05-04','983210987','Calle Los Robles 654','elenita'),(10,'Raúl Herrera','A88889999@utp.edu.pe','75432109','Educación','2021-10-18','982109876','Av. Universitaria 852','raul2021');
/*!40000 ALTER TABLE `coordinadores` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-07-19 12:04:07
