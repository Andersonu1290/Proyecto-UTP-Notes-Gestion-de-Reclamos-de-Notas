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
-- Table structure for table `profesores`
--

DROP TABLE IF EXISTS `profesores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `profesores` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre_completo` varchar(100) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `dni` varchar(10) DEFAULT NULL,
  `especialidad` varchar(100) DEFAULT NULL,
  `fecha_ingreso` date DEFAULT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `direccion` varchar(150) DEFAULT NULL,
  `contraseña` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profesores`
--

LOCK TABLES `profesores` WRITE;
/*!40000 ALTER TABLE `profesores` DISABLE KEYS */;
INSERT INTO `profesores` VALUES (1,'Adriano Ramos','C87349102@utp.edu.pe','98564529','Matematicas','2020-09-16','+51 928439535','Av Tupac Amaru 987, Comas','ju3ddrq4zg1r'),(2,'Maite Soto','C19283746@utp.edu.pe','52423929','Biologia','2018-04-25','+51 935002537','Jr Rufino Torrico 109, Cercado de Lima','m058c7gjrkqv'),(3,'Diego Alvarado','C65094837@utp.edu.pe','57365221','Quimica','2020-04-15','+51 931882520','Av San Luis 210, San Borja','0gcxt23x860y'),(4,'Paulette Caceres','C30192874@utp.edu.pe','10658032','Fisica','2020-11-26','+51 985609191','Calle Roma 321, San Isidro','h0e8qzakdjjb'),(5,'Salvador Quispe','C98765432@utp.edu.pe','95180573','Biologia','2021-07-01','+51 930219071','Av Abancay 432, Cercado de Lima','doxgqy9lu1zo'),(6,'Cristina Vasquez','C54321098@utp.edu.pe','51160328','Fisica','2022-01-31','+51 949846538','Calle Los Laureles 567, Surco','vewopnz73d4g'),(7,'Luis Mendoza','C23456789@utp.edu.pe','79152495','Ciencias de la Computacion','2020-08-26','+51 937340332','Jr De La Union 456, Cercado de Lima','ojkkzt25eafj'),(8,'Sofia Rojas','C78901234@utp.edu.pe','72978023','Ingenieria','2021-05-29','+51 981009291','Calle Las Begonias 789, San Isidro','9912rug4967u'),(9,'Carlos Quispe','C45678901@utp.edu.pe','60417728','Ciencias de la Computacion','2019-07-04','+51 992883484','Av Tacna 101, Cercado de Lima','muw256aepwqw'),(10,'Maria Vargas','C01234567@utp.edu.pe','83316293','Ciencias de la Computacion','2020-10-18','+51 942584850','Jr Cajamarca 234, BreÃ±a, Lima, Peru','uj52y2uvyp1b'),(11,'Pedro Cardenas','C89012345@utp.edu.pe','56767517','Matematicas','2022-01-21','+51 958721017','Calle Alcanfores 567, Miraflores','ngq4za28fpyv'),(12,'Laura Flores','C67890123@utp.edu.pe','63394777','Biologia','2019-07-01','+51 948118404','Av Arequipa 890, Lince','tsdaoeljcjnz'),(13,'Diego Soto','C34567890@utp.edu.pe','76916303','Quimica','2019-09-15','+51 911345694','Jr Risso 112, Lince','avev0ttnyf08'),(14,'Valeria Ramos','C90123456@utp.edu.pe','80746714','Ingenieria','2021-06-14','+51 917144624','Av Javier Prado Este 345, San Borja','kpv7h9af93k8'),(15,'Gabriel Herrera','C56789012@utp.edu.pe','87360344','Biologia','2018-06-30','+51 947218926','Calle Los Robles 678, La Molina','hkuppptzw1ns'),(16,'Camila Paredes','C12345678@utp.edu.pe','61842914','Biologia','2022-11-25','+51 983500944','Av La Marina 901, San Miguel','10plr22y9fs9'),(17,'Ricardo Salazar','C78901234@utp.edu.pe','35743894','Fisica','2021-02-08','+51 901237519','Jr Zorritos 210, BreÃ±a','hd4i21byt6wc'),(18,'Fatima Benites','C45678901@utp.edu.pe','22553045','Ciencias Ambientales','2022-01-27','+51 932435170','Calle Tarata 321, Miraflores','h3l8kfwg9zdt'),(19,'Alejandro Castro','C01234567@utp.edu.pe','74987042','Ingenieria Informatica','2022-04-12','+51 905905840','Av Colonial 432, Cercado de Lima','quo78srl1k1j'),(20,'Daniela Ortiz','C89012345@utp.edu.pe','29427725','Ciencias Economicas','2020-05-29','+51 960849916','Jr Garcilaso de la Vega 543, Magdalena del Mar','vad4q2sv2zvz'),(21,'Juan Vargas','C67890123@utp.edu.pe','79326446','Matematicas','2018-02-09','+51 956146107','Av Salaverry 654, Jesus Maria','xfw6y6x9pyvj'),(22,'Luciana Romero','C34567890@utp.edu.pe','21199986','Ciencias de la Computacion','2018-11-04','+51 945981792','Calle Cantuarias 765, Miraflores','06yx938x5wn0'),(23,'Sebastian Gil','C90123456@utp.edu.pe','18432872','Ciencias Ambientales','2019-05-24','+51 988082089','Av Benavides 876, Santiago de Surco','iwtuae16x9up'),(24,'Andrea Pizarro','C56789012@utp.edu.pe','89873378','Quimica','2019-08-29','+51 926780762','Jr Huancayo 987, La Victoria','q55cc6mqs3i3'),(25,'Jose Miranda','C12345678@utp.edu.pe','91700952','Fisica','2019-01-12','+51 995188432','Av Angamos Este 109, Surquillo','hs1nerytxllm'),(26,'Isabella Leon','C87654321@utp.edu.pe','80405345','Ingenieria Informatica','2019-04-24','+51 978859311','Jr Trujillo 210, Rimac','1g7jyltm2re6'),(27,'Angel Torres','C23456789@utp.edu.pe','45194861','Biologia','2019-08-14','+51 935243920','Av Sucre 321, Pueblo Libre','mou2vcp6vsf0'),(28,'Ximena Luna','C78901234@utp.edu.pe','86245153','Ciencias Ambientales','2018-10-05','+51 976801369','Calle Berlin 432, Miraflores','90m4fe9kgfk3'),(29,'Mateo Solis','C45678901@utp.edu.pe','65856333','Ciencias de la Computacion','2021-09-02','+51 964533996','Jr Puno 543, Cercado de Lima','dvf8z6cup1sf'),(30,'Emilia Rios','C01234567@utp.edu.pe','20664603','Biologia','2021-01-14','+51 914016089','Av Primavera 654, Santiago de Surco','wp0mguf17idr'),(31,'Fabrizio Guzman','C89012345@utp.edu.pe','96625576','Ingenieria','2019-03-29','+51 977120990','Calle General Mendiburu 765, Miraflores','g91y0p07wr8u'),(32,'Renata Vidal','C67890123@utp.edu.pe','35266078','Ciencias de la Computacion','2018-12-28','+51 990877129','Jr Callao 876, Cercado de Lima','uyh669h4gjqt'),(33,'Joaquin PeÃ±a','C34567890@utp.edu.pe','87997584','Matematicas','2019-02-27','+51 956447808','Av Dos de Mayo 987, San Isidro','zjhbtoln25ra'),(34,'Mariana Chavez','C90123456@utp.edu.pe','85340508','Biologia','2019-09-05','+51 952789527','Calle Los Jazmines 109, San Isidro','w75k8u3p2jo1'),(35,'Nicolas Delgado','C56789012@utp.edu.pe','14229945','Ingenieria Informatica','2020-03-26','+51 935583669','Av Brasil 210, Pueblo Libre','cc9q4a243gz1'),(36,'Fernanda Quispe','C12345678@utp.edu.pe','47744220','Ingenieria','2020-10-22','+51 961430949','Jr Ica 321, Cercado de Lima','h8elmpv6q9ym'),(37,'Martin NuÃ±ez','C87654321@utp.edu.pe','63908741','Matematicas','2020-12-11','+51 912156191','Av Faustino Sanchez Carrion 432, San Isidro','529q7hffohpj'),(38,'Antonella Bustamante','C23456789@utp.edu.pe','35110517','Ciencias Ambientales','2018-11-11','+51 903195903','Calle Schell 543, Miraflores','onqwizrk6p3z'),(39,'Benjamin Galvez','C78901234@utp.edu.pe','61983525','Estadistica','2022-09-28','+51 980060999','Av Wilson 654, Cercado de Lima','60vcrhrf5q2v'),(40,'Florencia Zapata','C45678901@utp.edu.pe','43082479','Ciencias Economicas','2020-10-11','+51 990695438','Jr Napo 765, BreÃ±a','a02fk6en9m5u'),(41,'Santiago Morales','C01234567@utp.edu.pe','53660471','Ingenieria Informatica','2018-12-08','+51 945986466','Av La Paz 876, Miraflores','vlr5gjb601b8'),(42,'Victoria Salas','C89012345@utp.edu.pe','12137891','Ciencias de la Computacion','2019-01-07','+51 976303731','Calle Los Faisanes 987, Chorrillos','jmd8xd3cqynr'),(43,'Felipe Acosta','C67890123@utp.edu.pe','97964494','Matematicas','2018-11-06','+51 969174996','Av Pachacutec 109, Villa El Salvador','rdoafh5b0k1g'),(44,'Luciana Sanchez','C34567890@utp.edu.pe','36323461','Estadistica','2021-01-18','+51 902645007','Jr Cuzco 210, Cercado de Lima','cnrgtqxfo96f'),(45,'Gabriel Vasquez','C90123456@utp.edu.pe','62092669','Ciencias de la Computacion','2019-08-20','+51 926866599','Av El Polo 321, Santiago de Surco','2yyepopt55p8'),(46,'Zoe Mendoza','C56789012@utp.edu.pe','81537903','Quimica','2021-06-15','+51 934653495','Calle Colon 432, Miraflores','icdfgw3cqg68'),(47,'Gonzalo Davila','C12345678@utp.edu.pe','83614980','Estadistica','2018-06-26','+51 956295074','Av Peru 543, San Martin de Porres','n7h0b2o4shmv'),(48,'Isidora Guerra','C87654321@utp.edu.pe','26009953','Biologia','2019-04-19','+51 941523097','Jr Moquegua 654, Cercado de Lima','w65r0bhsjo8v'),(49,'Franco Loyola','C23456789@utp.edu.pe','99283721','Ciencias Economicas','2022-06-14','+51 987937950','Av Jose Pardo 765, Miraflores','vd0txjid6k67'),(50,'Valentina Cordova','C78901234@utp.edu.pe','92438165','Ingenieria Informatica','2022-06-07','+51 920303782','Calle Los Pinos 876, La Molina','2ghbfoehtf62');
/*!40000 ALTER TABLE `profesores` ENABLE KEYS */;
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
