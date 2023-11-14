-- MariaDB dump 10.19  Distrib 10.4.28-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: aadb
-- ------------------------------------------------------
-- Server version	10.4.28-MariaDB

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


CREATE DATABASE IF NOT EXISTS aadb CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE aadb;

DROP TABLE IF EXISTS `AAcourse`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `AAcourse` (
  `course_id` int(11) NOT NULL AUTO_INCREMENT,
  `initials` varchar(10) NOT NULL,
  `name` varchar(70) NOT NULL,
  PRIMARY KEY (`course_id`),
  KEY `AACourse_Index_Cource_Id` (`course_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

DROP TABLE IF EXISTS `AASubject`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `AASubject` (
  `course_id` int(11) NOT NULL,
  `initials` varchar(10) NOT NULL,
  `name` varchar(70) NOT NULL,
  PRIMARY KEY (`course_id`,`initials`),
  CONSTRAINT `AASubject_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `AAcourse` (`course_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

DROP TABLE IF EXISTS `AAStudents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `AAStudents` (
  `student_ar` varchar(20) NOT NULL,
  `name` varchar(70) NOT NULL,
  `email` varchar(50) NOT NULL,
  PRIMARY KEY (`student_ar`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

DROP TABLE IF EXISTS `AAEnrolled`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `AAEnrolled` (
  `course_id` int(11) NOT NULL,
  `subject_id` varchar(10) NOT NULL,
  `student_ar` varchar(20) NOT NULL,
  PRIMARY KEY (`course_id`,`subject_id`,`student_ar`),
  KEY `student_ar` (`student_ar`),
  CONSTRAINT `AAEnrolled_ibfk_1` FOREIGN KEY (`course_id`, `subject_id`) REFERENCES `aasubject` (`course_id`, `initials`),
  CONSTRAINT `AAEnrolled_ibfk_2` FOREIGN KEY (`student_ar`) REFERENCES `aastudents` (`student_ar`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

DROP TABLE IF EXISTS `AALogin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `AALogin` (
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `temppassword` varchar(50) NOT NULL,
  PRIMARY KEY (`username`),
  CONSTRAINT `AALogin_ibfk_1` FOREIGN KEY (`username`) REFERENCES `aastudents` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

DROP TABLE IF EXISTS `AAAssignments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `AAAssignments` (
  `course_id` int(11) NOT NULL,
  `subject_id` varchar(10) NOT NULL,
  `assignment_id` varchar(10) NOT NULL,
  `content` longblob NOT NULL,
  PRIMARY KEY (`course_id`,`subject_id`,`assignment_id`),
  CONSTRAINT `AAAssignments_ibfk_1` FOREIGN KEY (`course_id`, `subject_id`) REFERENCES `aasubject` (`course_id`, `initials`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

DROP TABLE IF EXISTS `AAAssignmentsfinished`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `AAAssignmentsfinished` (
  `course_id` int(11) NOT NULL,
  `subject_id` varchar(10) NOT NULL,
  `assignment_id` varchar(10) NOT NULL,
  `student_ar` varchar(20) NOT NULL,
  `content` longblob NOT NULL,
  PRIMARY KEY (`course_id`,`subject_id`,`assignment_id`,`student_ar`),
  KEY `student_ar` (`student_ar`),
  CONSTRAINT `AAAssignmentsFinished_ibfk_1` FOREIGN KEY (`course_id`, `subject_id`, `assignment_id`) REFERENCES `AAAssignments` (`course_id`, `subject_id`, `assignment_id`),
  CONSTRAINT `AAAssignmentssfinished_ibfk_2` FOREIGN KEY (`student_ar`) REFERENCES `AAEnrolled` (`student_ar`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

DROP TABLE IF EXISTS `AATempPassword`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `AATempPassword` (
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  PRIMARY KEY (`username`),
  CONSTRAINT `AATempPassword_ibfk_1` FOREIGN KEY (`username`) REFERENCES `AALogin` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;


/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-10-16 15:06:16

insert into aadb.aacourse values (2,'ADS-AMS','Análise e Desenvolvimento de Sistemas Articulação Médio Superior');
insert into aadb.aasubject values (2,'IED008','Estrutura de Dados');
insert into aadb.aasubject values (2,'ILP063','Técnicas Avançadas de Programação');
insert into aadb.aastudents values ('0000000000000','Antonio Tadeu Maffeis','tadeu.maffeis@fatec.sp.gov.br');
insert into aadb.aaenrolled values (2,'IED008','0000000000000') ;
insert into aadb.aaenrolled values (2,'ILP063','0000000000000') ;
insert into aadb.aalogin values ('tadeu.maffeis@fatec.sp.gov.br','',0);