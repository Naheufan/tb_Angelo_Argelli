CREATE DATABASE  IF NOT EXISTS `tb_sujets_db` /*!40100 DEFAULT CHARACTER SET utf8 */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `tb_sujets_db`;
-- MySQL dump 10.13  Distrib 8.0.19, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: tb_sujets_db
-- ------------------------------------------------------
-- Server version	8.0.19

--
-- Sutructure de la table `suj_filiere`
--

DROP TABLE IF EXISTS `suj_filiere`;
CREATE TABLE `suj_filiere` (
  `filiere_id` int NOT NULL AUTO_INCREMENT,
  `filiere_nom` varchar(45) DEFAULT NULL,
  `filiere_acronyme` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`filiere_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Données de la table `suj_filiere`
--

LOCK TABLES `suj_filiere` WRITE;
INSERT INTO `suj_filiere` VALUES (0,'Divers','Div'),(1,'Informatique de Gestion','IG'),(2,'Information Documentaire','ID'),(3,'Economie d\'Entreprise','EE'),(4,'International Business Management','IBM');
UNLOCK TABLES;

--
-- Sutructure de la table `suj_personne`
--

DROP TABLE IF EXISTS `suj_personne`;
CREATE TABLE `suj_personne` (
  `personne_id` int NOT NULL AUTO_INCREMENT,
  `personne_nom` varchar(45) DEFAULT NULL,
  `personne_contact` varchar(45) DEFAULT NULL,
  `personne_type` enum('professeur','étudiant') DEFAULT NULL,
  `personne_filiere_id` int NOT NULL,
  `personne_user_id` int NOT NULL,
  PRIMARY KEY (`personne_id`,`personne_filiere_id`,`personne_user_id`),
  KEY `fk_suj_personne_suj_filiere1_idx` (`personne_filiere_id`),
  KEY `fk_suj_personne_user1_idx` (`personne_user_id`),
  CONSTRAINT `fk_suj_personne_suj_filiere1` FOREIGN KEY (`personne_filiere_id`) REFERENCES `suj_filiere` (`filiere_id`),
  CONSTRAINT `fk_suj_personne_user1` FOREIGN KEY (`personne_user_id`) REFERENCES `suj_user` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Données de la table `suj_personne`
--

LOCK TABLES `suj_personne` WRITE;
INSERT INTO `suj_personne` VALUES
(1,'administrateur','admin@email.ch','professeur',0,1),
(2,'Ludovic BOULET','LudBOU@email.ch','professeur',1,2),
(3,'Dimitri GARNIER','DimGAR@email.ch','professeur',1,3),
(4,'Lilian BAUDELAIRE','LilBAU@email.ch','professeur',1,4),
(5,'Arthur LEBEAU','ArtLEB@email.ch','professeur',2,5),
(6,'Alban DELCROIX','AlbDEL@email.ch','professeur',2,6),
(7,'Antoine SHARPE','AntSHA@email.ch','professeur',2,7),
(8,'Roméo SEYRÈS','RomSEY@email.ch','professeur',3,8),
(9,'Mathis ABBADIE','MatABB@email.ch','professeur',3,9),
(10,'Mathieu COUVREUR','MatCOU@email.ch','professeur',3,10),
(11,'Godefroy GUILBERT','GodGUI@email.ch','professeur',4,11),
(12,'Ginette GAGNON','GinGAG@email.ch','professeur',4,12),
(13,'Gabrielle BOSSUET','GabBOS@email.ch','professeur',4,13),
(14,'Émilienne GAUTHIER','EmiGAU@email.ch','étudiant',1,14),
(15,'Héloïse COCHET','HelCOC@email.ch','étudiant',1,15),
(16,'Sabrina CAZENAVE','SabCAZ@email.ch','étudiant',1,16),
(17,'Marie-Pierre GACHET','MarGAC@email.ch','étudiant',2,17),
(18,'Rebecca BESSETTE','RebBES@email.ch','étudiant',2,18),
(19,'Claudette CORRIVEAU','ClaCOR@email.ch','étudiant',2,19),
(20,'Romaine VEIL','RomVEI@email.ch','étudiant',3,20),
(21,'Clémentine APPELL','CleAPP@email.ch','étudiant',3,21),
(22,'Guy GIDE','GuyGID@email.ch','étudiant',3,22),
(23,'Anatole JÉGOU','AnaJEG@email.ch','étudiant',4,23),
(24,'Frank LARUE','FraLAR@email.ch','étudiant',4,24),
(25,'Émile LECOCQ','EmiLEC@email.ch','étudiant',4,25);
UNLOCK TABLES;

--
-- Sutructure de la table `suj_sujet`
--

DROP TABLE IF EXISTS `suj_sujet`;
CREATE TABLE `suj_sujet` (
  `sujet_id` int NOT NULL AUTO_INCREMENT,
  `sujet_titre` mediumtext NOT NULL,
  `sujet_resume` mediumtext NOT NULL,
  `sujet_date` datetime NOT NULL,
  `sujet_type` enum('travail pratique','travail de recherche','hybride') NOT NULL,
  `sujet_statut` enum('en attente','accepté','refusé','pris') NOT NULL DEFAULT 'en attente',
  `sujet_personne_id` int NOT NULL,
  `sujet_filiere_id` int NOT NULL,
  PRIMARY KEY (`sujet_id`),
  KEY `fk_suj_sujet_suj_personne1_idx` (`sujet_personne_id`),
  KEY `fk_suj_sujet_suj_filiere1_idx` (`sujet_filiere_id`),
  CONSTRAINT `fk_suj_sujet_suj_filiere1` FOREIGN KEY (`sujet_filiere_id`) REFERENCES `suj_filiere` (`filiere_id`),
  CONSTRAINT `fk_suj_sujet_suj_personne1` FOREIGN KEY (`sujet_personne_id`) REFERENCES `suj_personne` (`personne_id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Données de la table `suj_sujet`
--

LOCK TABLES `suj_sujet` WRITE;
INSERT INTO `suj_sujet` VALUES
(1,'Développement API REST','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin a urna eu ipsum faucibus pellentesque sit amet at mi. Praesent quis commodo ex, ut maximus metus. Fusce laoreet, metus sit amet sagittis pulvinar, arcu turpis condimentum ex, quis bibendum massa purus vitae nunc.','2020-12-06 18:12:09','travail pratique','accepté',2,1),
(3,'Analyse d\'une application C++ et refonte en ReactJS','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque neque massa, molestie ut porta non, facilisis nec ex. Fusce condimentum scelerisque imperdiet. Nulla maximus eget augue ac condimentum. Pellentesque vel lorem dolor. Mauris ac lectus fermentum, interdum velit ac, bibendum nisl. Donec sed interdum arcu, a tempus nunc. Phasellus pretium tortor lobortis metus euismod vulputate. Etiam at augue ligula. Integer pulvinar nulla nec tortor vehicula tempor. Proin consectetur convallis facilisis. Vivamus ac pretium dui, nec elementum neque. Nam rhoncus justo id felis interdum, at egestas nisl mollis. Proin ornare id neque at pulvinar. Fusce elementum ipsum lacinia mauris facilisis, sed feugiat tortor fringilla.','2020-12-06 18:16:04','travail pratique','accepté',4,1),
(4,'Analyse et recherche de l\'origine d\'une méthode de développement','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque neque massa, molestie ut porta non, facilisis nec ex. Fusce condimentum scelerisque imperdiet. Nulla maximus eget augue ac condimentum. Pellentesque vel lorem dolor. Mauris ac lectus fermentum, interdum velit ac, bibendum nisl. Donec sed interdum arcu, a tempus nunc. Phasellus pretium tortor lobortis metus euismod vulputate. Etiam at augue ligula. Integer pulvinar nulla nec tortor vehicula tempor. Proin consectetur convallis facilisis. Vivamus ac pretium dui, nec elementum neque. Nam rhoncus justo id felis interdum, at egestas nisl mollis. Proin ornare id neque at pulvinar. Fusce elementum ipsum lacinia mauris facilisis, sed feugiat tortor fringilla.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque neque massa, molestie ut porta non, facilisis nec ex. Fusce condimentum scelerisque imperdiet. Nulla maximus eget augue ac condimentum. Pellentesque vel lorem dolor. Mauris ac lectus fermentum.','2020-12-06 18:16:51','travail de recherche','accepté',4,1),
(5,'Les documents les moins consultés sont ils les moins importants?','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque neque massa, molestie ut porta non, facilisis nec ex. Fusce condimentum scelerisque imperdiet. Nulla maximus eget augue ac condimentum. Pellentesque vel lorem dolor. Mauris ac lectus fermentum, interdum velit ac, bibendum nisl. Donec sed interdum arcu, a tempus nunc. Phasellus pretium tortor lobortis metus euismod vulputate. Etiam at augue ligula. Integer pulvinar nulla nec tortor vehicula tempor. Proin consectetur convallis facilisis. Vivamus ac pretium dui, nec elementum neque. Nam rhoncus justo id felis interdum, at egestas nisl mollis. Proin ornare id neque at pulvinar. Fusce elementum ipsum lacinia mauris facilisis, sed feugiat tortor fringilla.','2020-12-06 18:17:29','travail de recherche','accepté',5,2),
(6,'Création d\'une maquette d\'application de gestion biblio','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque neque massa, molestie ut porta non, facilisis nec ex. Fusce condimentum scelerisque imperdiet. Nulla maximus eget augue ac condimentum. Pellentesque vel lorem dolor. Mauris ac lectus fermentum, interdum velit ac, bibendum nisl. Donec sed interdum arcu, a tempus nunc. Phasellus pretium tortor lobortis metus euismod vulputate. Etiam at augue ligula. Integer pulvinar nulla nec tortor vehicula tempor. Proin consectetur convallis facilisis. Vivamus ac pretium dui, nec elementum neque. Nam rhoncus justo id felis interdum, at egestas nisl mollis. Proin ornare id neque at pulvinar. Fusce elementum ipsum lacinia mauris facilisis, sed feugiat tortor fringilla.','2020-12-06 18:18:29','hybride','accepté',5,2),
(7,'Lorem ipsum dolor sit amet, consectetur adipiscing elit. ','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque neque massa, molestie ut porta non, facilisis nec ex. Fusce condimentum scelerisque imperdiet. Nulla maximus eget augue ac condimentum. Pellentesque vel lorem dolor. Mauris ac lectus fermentum, interdum velit ac, bibendum nisl. Donec sed interdum arcu, a tempus nunc. Phasellus pretium tortor lobortis metus euismod vulputate. Etiam at augue ligula. Integer pulvinar nulla nec tortor vehicula tempor. Proin consectetur convallis facilisis. Vivamus ac pretium dui, nec elementum neque. Nam rhoncus justo id felis interdum, at egestas nisl mollis. Proin ornare id neque at pulvinar. Fusce elementum ipsum lacinia mauris facilisis, sed feugiat tortor fringilla.','2020-12-06 18:19:03','travail pratique','accepté',6,2),
(8,'Lorem ipsum dolor sit amet, consectetur adipiscing elit.','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque neque massa, molestie ut porta non, facilisis nec ex. Fusce condimentum scelerisque imperdiet. Nulla maximus eget augue ac condimentum. Pellentesque vel lorem dolor. Mauris ac lectus fermentum, interdum velit ac, bibendum nisl. Donec sed interdum arcu, a tempus nunc. Phasellus pretium tortor lobortis metus euismod vulputate. Etiam at augue ligula. Integer pulvinar nulla nec tortor vehicula tempor. Proin consectetur convallis facilisis. Vivamus ac pretium dui, nec elementum neque. Nam rhoncus justo id felis interdum, at egestas nisl mollis. Proin ornare id neque at pulvinar. Fusce elementum ipsum lacinia mauris facilisis, sed feugiat tortor fringilla.','2020-12-06 18:19:37','travail de recherche','accepté',7,2),
(9,'Analyse du fonctionnement comptable des grandes entreprises','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque neque massa, molestie ut porta non, facilisis nec ex. Fusce condimentum scelerisque imperdiet. Nulla maximus eget augue ac condimentum. Pellentesque vel lorem dolor. Mauris ac lectus fermentum, interdum velit ac, bibendum nisl. Donec sed interdum arcu, a tempus nunc. Phasellus pretium tortor lobortis metus euismod vulputate. Etiam at augue ligula. Integer pulvinar nulla nec tortor vehicula tempor. Proin consectetur convallis facilisis. Vivamus ac pretium dui, nec elementum neque. Nam rhoncus justo id felis interdum, at egestas nisl mollis. Proin ornare id neque at pulvinar. Fusce elementum ipsum lacinia mauris facilisis, sed feugiat tortor fringilla.','2020-12-06 18:20:13','travail de recherche','accepté',8,3),
(10,'Lorem ipsum dolor sit amet, consectetur adipiscing elit. ','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque neque massa, molestie ut porta non, facilisis nec ex. Fusce condimentum scelerisque imperdiet. Nulla maximus eget augue ac condimentum. Pellentesque vel lorem dolor. Mauris ac lectus fermentum, interdum velit ac, bibendum nisl. Donec sed interdum arcu, a tempus nunc. Phasellus pretium tortor lobortis metus euismod vulputate. Etiam at augue ligula. Integer pulvinar nulla nec tortor vehicula tempor. Proin consectetur convallis facilisis. Vivamus ac pretium dui, nec elementum neque. Nam rhoncus justo id felis interdum, at egestas nisl mollis. Proin ornare id neque at pulvinar. Fusce elementum ipsum lacinia mauris facilisis, sed feugiat tortor fringilla.','2020-12-06 18:20:40','travail de recherche','accepté',9,3),
(11,'Phasellus pretium tortor lobortis metus euismod vulputate.','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque neque massa, molestie ut porta non, facilisis nec ex. Fusce condimentum scelerisque imperdiet. Nulla maximus eget augue ac condimentum. Pellentesque vel lorem dolor. Mauris ac lectus fermentum, interdum velit ac, bibendum nisl. Donec sed interdum arcu, a tempus nunc. Phasellus pretium tortor lobortis metus euismod vulputate. Etiam at augue ligula. Integer pulvinar nulla nec tortor vehicula tempor. Proin consectetur convallis facilisis. Vivamus ac pretium dui, nec elementum neque. Nam rhoncus justo id felis interdum, at egestas nisl mollis. Proin ornare id neque at pulvinar. Fusce elementum ipsum lacinia mauris facilisis, sed feugiat tortor fringilla.','2020-12-06 18:21:08','hybride','accepté',10,3),
(12,'Management building','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque neque massa, molestie ut porta non, facilisis nec ex. Fusce condimentum scelerisque imperdiet. Nulla maximus eget augue ac condimentum. Pellentesque vel lorem dolor. Mauris ac lectus fermentum, interdum velit ac, bibendum nisl. Donec sed interdum arcu, a tempus nunc. Phasellus pretium tortor lobortis metus euismod vulputate. Etiam at augue ligula. Integer pulvinar nulla nec tortor vehicula tempor. Proin consectetur convallis facilisis. Vivamus ac pretium dui, nec elementum neque. Nam rhoncus justo id felis interdum, at egestas nisl mollis. Proin ornare id neque at pulvinar. Fusce elementum ipsum lacinia mauris facilisis, sed feugiat tortor fringilla.','2020-12-06 18:27:47','travail pratique','accepté',11,4),
(13,'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque neque massa, molestie ut porta non, facilisis nec ex.','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque neque massa, molestie ut porta non, facilisis nec ex. Fusce condimentum scelerisque imperdiet. Nulla maximus eget augue ac condimentum. Pellentesque vel lorem dolor. Mauris ac lectus fermentum, interdum velit ac, bibendum nisl. Donec sed interdum arcu, a tempus nunc. Phasellus pretium tortor lobortis metus euismod vulputate. Etiam at augue ligula. Integer pulvinar nulla nec tortor vehicula tempor. Proin consectetur convallis facilisis. Vivamus ac pretium dui, nec elementum neque. Nam rhoncus justo id felis interdum, at egestas nisl mollis. Proin ornare id neque at pulvinar. Fusce elementum ipsum lacinia mauris facilisis, sed feugiat tortor fringilla.','2020-12-06 18:28:03','travail de recherche','accepté',11,4),
(14,'Phasellus pretium tortor','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque neque massa, molestie ut porta non, facilisis nec ex. Fusce condimentum scelerisque imperdiet. Nulla maximus eget augue ac condimentum. Pellentesque vel lorem dolor. Mauris ac lectus fermentum, interdum velit ac, bibendum nisl. Donec sed interdum arcu, a tempus nunc. Phasellus pretium tortor lobortis metus euismod vulputate. Etiam at augue ligula. Integer pulvinar nulla nec tortor vehicula tempor. Proin consectetur convallis facilisis. Vivamus ac pretium dui, nec elementum neque. Nam rhoncus justo id felis interdum, at egestas nisl mollis. Proin ornare id neque at pulvinar. Fusce elementum ipsum lacinia mauris facilisis, sed feugiat tortor fringilla.','2020-12-06 18:36:08','hybride','accepté',12,4),
(15,'développement d\'un site web pour ma maman','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque neque massa, molestie ut porta non, facilisis nec ex. Fusce condimentum scelerisque imperdiet. Nulla maximus eget augue ac condimentum. Pellentesque vel lorem dolor. Mauris ac lectus fermentum, interdum velit ac, bibendum nisl. Donec sed interdum arcu, a tempus nunc. Phasellus pretium tortor lobortis metus euismod vulputate. ','2020-12-06 18:29:38','travail pratique','refusé',14,1),
(16,'le bitcoin c\'est bien ou pas?','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque neque massa, molestie ut porta non, facilisis nec ex. Fusce condimentum scelerisque imperdiet. Nulla maximus eget augue ac condimentum. Pellentesque vel lorem dolor. Mauris ac lectus fermentum, interdum velit ac, bibendum nisl. Donec sed interdum arcu, a tempus nunc. Phasellus pretium tortor lobortis metus euismod vulputate. Etiam at augue ligula. Integer pulvinar nulla nec tortor vehicula tempor. Proin consectetur convallis facilisis. Vivamus ac pretium dui, nec elementum neque. Nam rhoncus justo id felis interdum, at egestas nisl mollis. Proin ornare id neque at pulvinar. Fusce elementum ipsum lacinia mauris facilisis, sed feugiat tortor fringilla.','2020-12-06 18:30:08','travail de recherche','accepté',15,1),
(17,'recherche et mise en pratique d\'un nouveau langage de dev','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque neque massa, molestie ut porta non, facilisis nec ex. Fusce condimentum scelerisque imperdiet. Nulla maximus eget augue ac condimentum. Pellentesque vel lorem dolor. Mauris ac lectus fermentum, interdum velit ac, bibendum nisl. Donec sed interdum arcu, a tempus nunc. Phasellus pretium tortor lobortis metus euismod vulputate. Etiam at augue ligula. Integer pulvinar nulla nec tortor vehicula tempor. Proin consectetur convallis facilisis. Vivamus ac pretium dui, nec elementum neque. Nam rhoncus justo id felis interdum, at egestas nisl mollis. Proin ornare id neque at pulvinar. Fusce elementum ipsum lacinia mauris facilisis, sed feugiat tortor fringilla.','2020-12-06 18:30:43','hybride','accepté',16,1),
(18,'pourquoi les trains sont ils toujours en retard?','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque neque massa, molestie ut porta non, facilisis nec ex. Fusce condimentum scelerisque imperdiet. Nulla maximus eget augue ac condimentum. Pellentesque vel lorem dolor. Mauris ac lectus fermentum, interdum velit ac, bibendum nisl. Donec sed interdum arcu, a tempus nunc. Phasellus pretium tortor lobortis metus euismod vulputate. Etiam at augue ligula. Integer pulvinar nulla nec tortor vehicula tempor. Proin consectetur convallis facilisis. Vivamus ac pretium dui, nec elementum neque. Nam rhoncus justo id felis interdum, at egestas nisl mollis. Proin ornare id neque at pulvinar. Fusce elementum ipsum lacinia mauris facilisis, sed feugiat tortor fringilla.','2020-12-06 18:31:10','travail de recherche','accepté',17,2),
(19,'le faisage de choses','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque neque massa, molestie ut porta non, facilisis nec ex. Fusce condimentum scelerisque imperdiet. Nulla maximus eget augue ac condimentum. Pellentesque vel lorem dolor. Mauris ac lectus fermentum, interdum velit ac, bibendum nisl. Donec sed interdum arcu, a tempus nunc. Phasellus pretium tortor lobortis metus euismod vulputate. Etiam at augue ligula. Integer pulvinar nulla nec tortor vehicula tempor. Proin consectetur convallis facilisis. Vivamus ac pretium dui, nec elementum neque. Nam rhoncus justo id felis interdum, at egestas nisl mollis. Proin ornare id neque at pulvinar. Fusce elementum ipsum lacinia mauris facilisis, sed feugiat tortor fringilla.','2020-12-06 18:31:44','hybride','refusé',18,2),
(20,'Bibliographie complète de 10 articles scientifiques','Vestibulum facilisis semper ligula, ultrices varius nunc luctus vulputate. Vivamus massa nisl, luctus ac velit sit amet, molestie pellentesque libero. In semper tempor ante nec porttitor. Donec sit amet mauris erat. Donec eget ante vel ligula rutrum commodo sed vel ligula. Vestibulum sed neque pharetra, accumsan metus sit amet, cursus augue. Curabitur lobortis mauris quis rhoncus facilisis. Phasellus pulvinar eros in urna euismod, nec dictum sapien finibus. Etiam vel libero rutrum, vehicula mauris non, aliquet purus. Integer pharetra odio et auctor aliquam. Sed at quam sit amet diam consequat suscipit. Aliquam ac facilisis augue. Nullam a faucibus lectus.','2020-12-06 18:32:41','travail pratique','accepté',19,2),
(21,'Compta de tonton','Vestibulum facilisis semper ligula, ultrices varius nunc luctus vulputate. Vivamus massa nisl, luctus ac velit sit amet, molestie pellentesque libero. In semper tempor ante nec porttitor. Donec sit amet mauris erat. Donec eget ante vel ligula rutrum commodo sed vel ligula. Vestibulum sed neque pharetra, accumsan metus sit amet, cursus augue. Curabitur lobortis mauris quis rhoncus facilisis. Phasellus pulvinar eros in urna euismod, nec dictum sapien finibus. Etiam vel libero rutrum, vehicula mauris non, aliquet purus. Integer pharetra odio et auctor aliquam. Sed at quam sit amet diam consequat suscipit. Aliquam ac facilisis augue. Nullam a faucibus lectus.','2020-12-06 18:33:00','travail pratique','refusé',20,3),
(22,'Donec sit amet mauris erat.','Vestibulum facilisis semper ligula, ultrices varius nunc luctus vulputate. Vivamus massa nisl, luctus ac velit sit amet, molestie pellentesque libero. In semper tempor ante nec porttitor. Donec sit amet mauris erat. Donec eget ante vel ligula rutrum commodo sed vel ligula. Vestibulum sed neque pharetra, accumsan metus sit amet, cursus augue. Curabitur lobortis mauris quis rhoncus facilisis. Phasellus pulvinar eros in urna euismod, nec dictum sapien finibus. Etiam vel libero rutrum, vehicula mauris non, aliquet purus. Integer pharetra odio et auctor aliquam. Sed at quam sit amet diam consequat suscipit. Aliquam ac facilisis augue. Nullam a faucibus lectus.','2020-12-06 18:33:19','hybride','pris',21,3),
(23,'GuyGIDE','Vestibulum facilisis semper ligula, ultrices varius nunc luctus vulputate. Vivamus massa nisl, luctus ac velit sit amet, molestie pellentesque libero. In semper tempor ante nec porttitor. Donec sit amet mauris erat. Donec eget ante vel ligula rutrum commodo sed vel ligula. Vestibulum sed neque pharetra, accumsan metus sit amet, cursus augue. Curabitur lobortis mauris quis rhoncus facilisis. Phasellus pulvinar eros in urna euismod, nec dictum sapien finibus. Etiam vel libero rutrum, vehicula mauris non, aliquet purus. Integer pharetra odio et auctor aliquam. Sed at quam sit amet diam consequat suscipit. Aliquam ac facilisis augue. Nullam a faucibus lectus.','2020-12-06 18:34:07','hybride','accepté',22,3),
(24,'Curabitur lobortis mauris quis rhoncus facilisis.','Vestibulum facilisis semper ligula, ultrices varius nunc luctus vulputate. Vivamus massa nisl, luctus ac velit sit amet, molestie pellentesque libero. In semper tempor ante nec porttitor. Donec sit amet mauris erat. Donec eget ante vel ligula rutrum commodo sed vel ligula. Vestibulum sed neque pharetra, accumsan metus sit amet, cursus augue. Curabitur lobortis mauris quis rhoncus facilisis. Phasellus pulvinar eros in urna euismod, nec dictum sapien finibus. Etiam vel libero rutrum, vehicula mauris non, aliquet purus. Integer pharetra odio et auctor aliquam. Sed at quam sit amet diam consequat suscipit. Aliquam ac facilisis augue. Nullam a faucibus lectus.','2020-12-06 18:34:34','hybride','accepté',23,4),
(25,'Développement d\'une application Web','Nullam quis mauris quis elit consectetur bibendum a ac nisl. Vestibulum pretium venenatis massa, ac tincidunt leo semper id. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Donec posuere venenatis leo ac elementum. Nunc eget justo sapien. In non ex commodo neque bibendum faucibus. Sed ut lorem vitae mi maximus laoreet. Phasellus maximus, lorem id convallis consequat, lectus diam imperdiet massa, vitae ultrices est sapien at leo. Donec porta dui sit amet efficitur viverra. Aliquam id sodales mi, quis tristique sem. Praesent velit est, interdum eu sem vitae, condimentum suscipit massa. Mauris eget pulvinar justo. Nullam vel turpis non neque fringilla egestas ut quis lorem.','2020-12-06 18:35:30','travail pratique','accepté',3,1),
(26,'Mauris felis turpis, dignissim non consequat vel','Pellentesque venenatis mi volutpat quam dapibus, ut convallis diam maximus. Nulla semper viverra quam id ultrices. Integer pharetra gravida risus vitae euismod. Praesent in mi nibh. Mauris felis turpis, dignissim non consequat vel, euismod sit amet arcu. Mauris suscipit quam libero, sed iaculis nulla faucibus sit amet. Nulla facilisi. Suspendisse potenti. Proin tristique nibh in lectus aliquam, nec placerat eros pellentesque. Nullam congue arcu et mollis volutpat. Ut aliquam lorem id lorem mollis commodo. Etiam scelerisque lorem ex, id mollis metus lobortis et. In dignissim ex a lorem facilisis scelerisque. Fusce cursus tincidunt justo, vitae tincidunt ipsum. Phasellus sit amet orci et arcu interdum commodo a sed risus. Cras eu urna tellus.','2020-12-06 18:36:53','travail de recherche','accepté',24,4),
(27,'Manger bleu pendant une semaine, un vrai danger pour la santé?','Nulla facilisi. Fusce vitae aliquet justo, ac porta felis. Praesent ut nunc leo. Vestibulum non magna neque. Fusce convallis ullamcorper sollicitudin. Proin dictum, diam suscipit dapibus ornare, metus risus hendrerit arcu, ut laoreet metus nisi non neque. Nulla a ante dolor. Integer quis arcu volutpat, interdum ipsum eget, ultrices enim.','2020-12-06 18:37:30','travail de recherche','refusé',25,4),
(28,'rangement des archives','Ut aliquam lorem id lorem mollis commodo. Etiam scelerisque lorem ex, id mollis metus lobortis et. In dignissim ex a lorem facilisis scelerisque. Fusce cursus tincidunt justo, vitae tincidunt ipsum. Phasellus sit amet orci et arcu interdum commodo a sed risus. Cras eu urna tellus.','2020-12-06 18:37:57','hybride','pris',1,0);
UNLOCK TABLES;

--
-- Sutructure de la table `suj_user`
--

DROP TABLE IF EXISTS `suj_user`;
CREATE TABLE `suj_user` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `user_login` varchar(45) NOT NULL,
  `user_pwd` varchar(45) NOT NULL,
  `user_type` enum('user','admin') NOT NULL DEFAULT 'user',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_login_UNIQUE` (`user_login`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- données de `suj_user`
--

LOCK TABLES `suj_user` WRITE;
INSERT INTO `suj_user` VALUES
/*administrateur (mdp = pwd (md5))*/
(1,'administrateur','9003d1df22eb4d3820015070385194c8','admin'),
/*professeurs (mdp = profPassword (md5))*/
(2,'LudovicBOULET','7f144cd86b7ef12948dd77cf9c7f8488','user'),
(3,'DimitriGARNIER','7f144cd86b7ef12948dd77cf9c7f8488','user'),
(4,'LilianBAUDELAIRE','7f144cd86b7ef12948dd77cf9c7f8488','user'),
(5,'ArthurLEBEAU','7f144cd86b7ef12948dd77cf9c7f8488','user'),
(6,'AlbanDELCROIX','7f144cd86b7ef12948dd77cf9c7f8488','user'),
(7,'AntoineSHARPE','7f144cd86b7ef12948dd77cf9c7f8488','user'),
(8,'RoméoSEYRÈS','7f144cd86b7ef12948dd77cf9c7f8488','user'),
(9,'MathisABBADIE','7f144cd86b7ef12948dd77cf9c7f8488','user'),
(10,'MathieuCOUVREUR','7f144cd86b7ef12948dd77cf9c7f8488','user'),
(11,'GodefroyGUILBERT','7f144cd86b7ef12948dd77cf9c7f8488','user'),
(12,'GinetteGAGNON','7f144cd86b7ef12948dd77cf9c7f8488','user'),
(13,'GabrielleBOSSUET','7f144cd86b7ef12948dd77cf9c7f8488','user'),
/*étudiants (mdp = etuPassword (md5))*/
(14,'ÉmilienneGAUTHIER','f2a10b6f3a95584869534bdacb1c571f','user'),
(15,'HéloïseCOCHET','f2a10b6f3a95584869534bdacb1c571f','user'),
(16,'SabrinaCAZENAVE','f2a10b6f3a95584869534bdacb1c571f','user'),
(17,'Marie-PierreGACHET','f2a10b6f3a95584869534bdacb1c571f','user'),
(18,'RebeccaBESSETTE','f2a10b6f3a95584869534bdacb1c571f','user'),
(19,'ClaudetteCORRIVEAU','f2a10b6f3a95584869534bdacb1c571f','user'),
(20,'RomaineVEIL','f2a10b6f3a95584869534bdacb1c571f','user'),
(21,'ClémentineAPPELL','f2a10b6f3a95584869534bdacb1c571f','user'),
(22,'GuyGIDE','f2a10b6f3a95584869534bdacb1c571f','user'),
(23,'AnatoleJÉGOU','f2a10b6f3a95584869534bdacb1c571f','user'),
(24,'FrankLARUE','f2a10b6f3a95584869534bdacb1c571f','user'),
(25,'ÉmileLECOCQ','f2a10b6f3a95584869534bdacb1c571f','user');
UNLOCK TABLES;

CREATE ALGORITHM=UNDEFINED DEFINER=`TBAdministrator`@`localhost`
SQL SECURITY DEFINER
VIEW `v_edit_sujet` AS select
`suj_sujet`.`sujet_id` AS `id`,
`suj_sujet`.`sujet_titre` AS `titre`,
`suj_sujet`.`sujet_resume` AS `description`,
`suj_sujet`.`sujet_date` AS `date`,
`suj_sujet`.`sujet_type` AS `type`,
`suj_sujet`.`sujet_statut` AS `statut`,
`suj_sujet`.`sujet_personne_id` AS `idPersonne`,
`suj_sujet`.`sujet_filiere_id` AS `idFiliere`
from `suj_sujet`;

CREATE ALGORITHM=UNDEFINED DEFINER=`TBAdministrator`@`localhost`
SQL SECURITY DEFINER
VIEW `v_inserting_sujet` AS select
`suj_sujet`.`sujet_id` AS `id`,
`suj_sujet`.`sujet_titre` AS `titre`,
`suj_sujet`.`sujet_resume` AS `resume`,
`suj_sujet`.`sujet_date` AS `date`,
`suj_sujet`.`sujet_type` AS `type`,
`suj_sujet`.`sujet_statut` AS `statut`,
`suj_sujet`.`sujet_personne_id` AS `idPersonne`,
`suj_sujet`.`sujet_filiere_id` AS `idFiliere`
from `suj_sujet`;

CREATE ALGORITHM=UNDEFINED DEFINER=`TBAdministrator`@`localhost`
 SQL SECURITY DEFINER
 VIEW `v_personne` AS select
 `suj_personne`.`personne_id` AS `idPersonne`,
 `suj_personne`.`personne_nom` AS `nom`,
 `suj_personne`.`personne_contact` AS `contact`,
 `suj_personne`.`personne_type` AS `type`,
 `suj_personne`.`personne_filiere_id` AS `idFiliere`,
 `suj_personne`.`personne_user_id` AS `userId`
 from `suj_personne`;

CREATE ALGORITHM=UNDEFINED DEFINER=`TBAdministrator`@`localhost`
SQL SECURITY DEFINER
VIEW `v_sujet` AS select
`suj_sujet`.`sujet_id` AS `id`,
`suj_sujet`.`sujet_titre` AS `titre`,
`suj_sujet`.`sujet_resume` AS `resume`,
date_format(`suj_sujet`.`sujet_date`,'%d/%m/%Y') AS `date`,
`suj_sujet`.`sujet_type` AS `typeSujet`,
`suj_sujet`.`sujet_statut` AS `statut`,
`suj_personne`.`personne_id` AS `idPersonne`,
`suj_personne`.`personne_nom` AS `nomPersonne`,
`suj_personne`.`personne_type` AS `typePersonne`,
`suj_personne`.`personne_contact` AS `contactPersonne`,
`filierepersonne`.`filiere_acronyme` AS `filierePersonne`,
`filieresujet`.`filiere_id` AS `idFiliere`,
`filieresujet`.`filiere_acronyme` AS `acrFiliere`,
`filieresujet`.`filiere_nom` AS `nomFiliere`
from (((`suj_sujet`
  join `suj_personne` on((`suj_personne`.`personne_id` = `suj_sujet`.`sujet_personne_id`)))
  join `suj_filiere` `filieresujet` on((`filieresujet`.`filiere_id` = `suj_sujet`.`sujet_filiere_id`)))
  join `suj_filiere` `filierepersonne` on((`suj_personne`.`personne_filiere_id` = `filierepersonne`.`filiere_id`)));

CREATE ALGORITHM=UNDEFINED DEFINER=`TBAdministrator`@`localhost`
SQL SECURITY DEFINER
VIEW `v_user` AS select
`suj_user`.`user_id` AS `id`,
`suj_user`.`user_login` AS `login`,
`suj_user`.`user_pwd` AS `pwd`,
`suj_user`.`user_type` AS `type` from `suj_user`;
