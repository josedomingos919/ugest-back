CREATE DATABASE  IF NOT EXISTS `ift_faturacao` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `ift_faturacao`;
-- MySQL dump 10.13  Distrib 5.7.9, for Win64 (x86_64)
--
-- Host: localhost    Database: ift_faturacao
-- ------------------------------------------------------
-- Server version	5.5.5-10.3.29-MariaDB-0ubuntu0.20.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `artigo`
--

DROP TABLE IF EXISTS `artigos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `artigos` (
  `art_id` int(11) NOT NULL AUTO_INCREMENT,
  `art_designacao` varchar(45) NOT NULL,
  `art_estado_id` int(11) NOT NULL,
  `art_tipoArtigo_id` int(11) NOT NULL,
  `art_stock_minimo` int(11) DEFAULT NULL,
  `art_stock_real` int(11) DEFAULT NULL,
  PRIMARY KEY (`art_id`),
  KEY `art_estado_id` (`art_estado_id`),
  CONSTRAINT `artigo_ibfk_1` FOREIGN KEY (`art_estado_id`) REFERENCES `estados` (`est_id`),
  CONSTRAINT `artigo_ibfk_2` FOREIGN KEY (`art_estado_id`) REFERENCES `estados` (`est_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `artigo`
--

LOCK TABLES `artigos` WRITE;
/*!40000 ALTER TABLE `artigos` DISABLE KEYS */;
/*!40000 ALTER TABLE `artigos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categoria`
--

DROP TABLE IF EXISTS `categorias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categorias` (
  `catg_id` int(11) NOT NULL AUTO_INCREMENT,
  `catg_designacao` varchar(100) NOT NULL,
  `catg_subcategoria_id` int(11) DEFAULT NULL,
  `catg_estado_id` int(11) NOT NULL,
  PRIMARY KEY (`catg_id`),
  UNIQUE KEY `catg_designacao` (`catg_designacao`),
  KEY `catg_subcategoria_id` (`catg_subcategoria_id`),
  KEY `catg_estado_id` (`catg_estado_id`),
  CONSTRAINT `categoria_ibfk_1` FOREIGN KEY (`catg_subcategoria_id`) REFERENCES `subcategorias` (`scat_id`),
  CONSTRAINT `categoria_ibfk_2` FOREIGN KEY (`catg_estado_id`) REFERENCES `estados` (`est_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categoria`
--

LOCK TABLES `categorias` WRITE;
/*!40000 ALTER TABLE `categorias` DISABLE KEYS */;
/*!40000 ALTER TABLE `categorias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contacto`
--

DROP TABLE IF EXISTS `contactos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contactos` (
  `cont_id` int(11) NOT NULL AUTO_INCREMENT,
  `cont_email` varchar(100) DEFAULT NULL,
  `cont_fax` varchar(100) DEFAULT NULL,
  `cont_telefone` varchar(100) DEFAULT NULL,
  `cont_telemovel` varchar(100) NOT NULL,
  `cont_principal` enum('true','false') NOT NULL DEFAULT 'false',
  `cont_estado_id` int(11) NOT NULL,
  `cont_pessoa_id` int(11) NOT NULL,
  PRIMARY KEY (`cont_id`),
  KEY `cont_pessoa_id` (`cont_pessoa_id`),
  KEY `cont_estado_id` (`cont_estado_id`),
  CONSTRAINT `contacto_ibfk_1` FOREIGN KEY (`cont_pessoa_id`) REFERENCES `pessoas` (`pes_id`),
  CONSTRAINT `contacto_ibfk_2` FOREIGN KEY (`cont_estado_id`) REFERENCES `estados` (`est_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contacto`
--

LOCK TABLES `contactos` WRITE;
/*!40000 ALTER TABLE `contactos` DISABLE KEYS */;
/*!40000 ALTER TABLE `contactos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `endereco`
--

DROP TABLE IF EXISTS `enderecos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `enderecos` (
  `end_id` int(11) NOT NULL AUTO_INCREMENT,
  `end_morada` varchar(100) NOT NULL,
  `end_localidade` varchar(100) DEFAULT NULL,
  `end_codigo_postal` varchar(45) DEFAULT NULL,
  `end_latitude` double DEFAULT NULL,
  `end_longitude` double DEFAULT NULL,
  `end_principal` enum('true','false') NOT NULL DEFAULT 'false',
  `end_estado_id` int(11) NOT NULL,
  `end_pessoa_id` int(11) NOT NULL,
  PRIMARY KEY (`end_id`),
  KEY `end_pessoa_id` (`end_pessoa_id`),
  KEY `end_estado_id` (`end_estado_id`),
  CONSTRAINT `endereco_ibfk_1` FOREIGN KEY (`end_pessoa_id`) REFERENCES `pessoas` (`pes_id`),
  CONSTRAINT `endereco_ibfk_2` FOREIGN KEY (`end_estado_id`) REFERENCES `estados` (`est_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `endereco`
--

LOCK TABLES `enderecos` WRITE;
/*!40000 ALTER TABLE `enderecos` DISABLE KEYS */;
/*!40000 ALTER TABLE `enderecos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estado`
--

DROP TABLE IF EXISTS `estados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `estados` (
  `est_id` int(11) NOT NULL AUTO_INCREMENT,
  `est_designacao` varchar(45) NOT NULL,
  `est_data_criacao` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`est_id`),
  UNIQUE KEY `est_designacao_UNIQUE` (`est_designacao`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estado`
--

LOCK TABLES `estados` WRITE;
/*!40000 ALTER TABLE `estados` DISABLE KEYS */;
/*!40000 ALTER TABLE `estados` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `historicoStock`
--

DROP TABLE IF EXISTS `historicoStocks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `historicoStocks` (
  `hst_id` int(11) NOT NULL AUTO_INCREMENT,
  `hst_tipo` enum('Entrada','Saida','Saida Stock Minimo','Quebra') NOT NULL,
  `hst_quantidade` int(11) NOT NULL DEFAULT 0,
  `hst_data_entrada` datetime NOT NULL,
  `hst_preco_compra` double NOT NULL,
  `hst_data_regitro` datetime DEFAULT current_timestamp(),
  `hst_estado` int(11) NOT NULL,
  PRIMARY KEY (`hst_id`),
  KEY `hst_estado` (`hst_estado`),
  CONSTRAINT `historicoStock_ibfk_1` FOREIGN KEY (`hst_estado`) REFERENCES `estados` (`est_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `historicoStock`
--

LOCK TABLES `historicoStocks` WRITE;
/*!40000 ALTER TABLE `historicoStocks` DISABLE KEYS */;
/*!40000 ALTER TABLE `historicoStocks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nivelAcesso`
--

DROP TABLE IF EXISTS `nivelAcessos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nivelAcessos` (
  `niv_id` int(11) NOT NULL AUTO_INCREMENT,
  `niv_designacao` varchar(100) NOT NULL,
  `niv_estado_id` int(11) NOT NULL,
  PRIMARY KEY (`niv_id`),
  KEY `niv_estado_id` (`niv_estado_id`),
  CONSTRAINT `nivelAcesso_ibfk_1` FOREIGN KEY (`niv_estado_id`) REFERENCES `estados` (`est_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nivelAcesso`
--

LOCK TABLES `nivelAcessos` WRITE;
/*!40000 ALTER TABLE `nivelAcessos` DISABLE KEYS */;
/*!40000 ALTER TABLE `nivelAcessos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `papel`
--

DROP TABLE IF EXISTS `papeis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `papeis` (
  `pap_id` int(11) NOT NULL AUTO_INCREMENT,
  `pap_designacao` varchar(100) NOT NULL,
  `pap_estado_id` int(11) NOT NULL,
  PRIMARY KEY (`pap_id`),
  KEY `pap_estado_id` (`pap_estado_id`),
  CONSTRAINT `papel_ibfk_1` FOREIGN KEY (`pap_estado_id`) REFERENCES `estados` (`est_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `papel`
--

LOCK TABLES `papeis` WRITE;
/*!40000 ALTER TABLE `papeis` DISABLE KEYS */;
/*!40000 ALTER TABLE `papeis` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `papelPessoa`
--

DROP TABLE IF EXISTS `papelPessoas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `papelPessoas` (
  `ppa_id` int(11) NOT NULL AUTO_INCREMENT,
  `ppa_designacao` varchar(100) NOT NULL,
  `ppa_principal` enum('true','false') NOT NULL DEFAULT 'false',
  `ppa_estado_id` int(11) NOT NULL,
  `ppa_pessoa_id` int(11) NOT NULL,
  `ppa_papel_id` int(11) NOT NULL,
  PRIMARY KEY (`ppa_id`),
  KEY `ppa_papel_id` (`ppa_papel_id`),
  KEY `ppa_pessoa_id` (`ppa_pessoa_id`),
  KEY `ppa_estado_id` (`ppa_estado_id`),
  CONSTRAINT `papelPessoa_ibfk_1` FOREIGN KEY (`ppa_papel_id`) REFERENCES `papeis` (`pap_id`),
  CONSTRAINT `papelPessoa_ibfk_2` FOREIGN KEY (`ppa_pessoa_id`) REFERENCES `pessoas` (`pes_id`),
  CONSTRAINT `papelPessoa_ibfk_3` FOREIGN KEY (`ppa_estado_id`) REFERENCES `estados` (`est_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `papelPessoa`
--

LOCK TABLES `papelPessoas` WRITE;
/*!40000 ALTER TABLE `papelPessoas` DISABLE KEYS */;
/*!40000 ALTER TABLE `papelPessoas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permicoesNivelTable`
--

DROP TABLE IF EXISTS `permicoesNivelTables`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permicoesNivelTables` (
  `pnt_id` int(11) NOT NULL AUTO_INCREMENT,
  `pnt_ler` enum('sim','não') DEFAULT 'sim',
  `pnt_escrever` enum('sim','não') DEFAULT 'sim',
  `pnt_eliminar` enum('sim','não') DEFAULT 'não',
  `pnt_nivelAcesso_id` int(11) NOT NULL,
  `pnt_estado_id` int(11) NOT NULL,
  PRIMARY KEY (`pnt_id`),
  KEY `pnt_nivelAcesso_id` (`pnt_nivelAcesso_id`),
  KEY `pnt_estado_id` (`pnt_estado_id`),
  CONSTRAINT `permicoesNivelTable_ibfk_1` FOREIGN KEY (`pnt_nivelAcesso_id`) REFERENCES `nivelAcessos` (`niv_id`),
  CONSTRAINT `permicoesNivelTable_ibfk_2` FOREIGN KEY (`pnt_estado_id`) REFERENCES `estados` (`est_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permicoesNivelTable`
--

LOCK TABLES `permicoesNivelTables` WRITE;
/*!40000 ALTER TABLE `permicoesNivelTables` DISABLE KEYS */;
/*!40000 ALTER TABLE `permicoesNivelTables` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pessoa`
--

DROP TABLE IF EXISTS `pessoas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pessoas` (
  `pes_id` int(11) NOT NULL AUTO_INCREMENT,
  `pes_nome` varchar(100) NOT NULL,
  `pes_nif` varchar(100) NOT NULL,
  `pes_genero` enum('masculino','feminino') DEFAULT NULL,
  `pes_estado_civil` enum('casado/a','solteiro/a','viuvo/a') DEFAULT NULL,
  `pes_estado_id` int(11) NOT NULL,
  `pes_data_nascimento` date DEFAULT NULL,
  PRIMARY KEY (`pes_id`),
  UNIQUE KEY `pes_nif` (`pes_nif`),
  KEY `pes_estado_id` (`pes_estado_id`),
  CONSTRAINT `pessoa_ibfk_1` FOREIGN KEY (`pes_estado_id`) REFERENCES `estados` (`est_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pessoa`
--

LOCK TABLES `pessoas` WRITE;
/*!40000 ALTER TABLE `pessoas` DISABLE KEYS */;
/*!40000 ALTER TABLE `pessoas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subcategoria`
--

DROP TABLE IF EXISTS `subcategorias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subcategorias` (
  `scat_id` int(11) NOT NULL AUTO_INCREMENT,
  `scat_designacao` varchar(100) NOT NULL,
  `scat_estado_id` int(11) NOT NULL,
  PRIMARY KEY (`scat_id`),
  UNIQUE KEY `scat_designacao` (`scat_designacao`),
  KEY `scat_estado_id` (`scat_estado_id`),
  CONSTRAINT `subcategoria_ibfk_1` FOREIGN KEY (`scat_estado_id`) REFERENCES `estados` (`est_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subcategoria`
--

LOCK TABLES `subcategorias` WRITE;
/*!40000 ALTER TABLE `subcategorias` DISABLE KEYS */;
/*!40000 ALTER TABLE `subcategorias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `taxa`
--

DROP TABLE IF EXISTS `taxas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `taxas` (
  `tax_id` int(11) NOT NULL AUTO_INCREMENT,
  `tax_tipo` enum('imposto','encargo','desconto') NOT NULL,
  `tax_descricao` varchar(100) NOT NULL,
  `tax_preco` double DEFAULT 0,
  `tax_percentagem` double DEFAULT 0,
  `tax_data_regitro` datetime DEFAULT current_timestamp(),
  `tax_estado` int(11) NOT NULL,
  PRIMARY KEY (`tax_id`),
  KEY `tax_estado` (`tax_estado`),
  CONSTRAINT `taxa_ibfk_1` FOREIGN KEY (`tax_estado`) REFERENCES `estados` (`est_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `taxa`
--

LOCK TABLES `taxas` WRITE;
/*!40000 ALTER TABLE `taxas` DISABLE KEYS */;
/*!40000 ALTER TABLE `taxas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `taxaArtigo`
--

DROP TABLE IF EXISTS `taxaArtigos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `taxaArtigos` (
  `trt_id` int(11) NOT NULL AUTO_INCREMENT,
  `trt_art_id` int(11) NOT NULL,
  `trt_taxa_id` int(11) NOT NULL,
  `trt_estado` int(11) NOT NULL,
  PRIMARY KEY (`trt_id`),
  KEY `trt_art_id` (`trt_art_id`),
  KEY `trt_taxa_id` (`trt_taxa_id`),
  KEY `trt_estado` (`trt_estado`),
  CONSTRAINT `taxaArtigo_ibfk_1` FOREIGN KEY (`trt_art_id`) REFERENCES `artigos` (`art_id`),
  CONSTRAINT `taxaArtigo_ibfk_2` FOREIGN KEY (`trt_taxa_id`) REFERENCES `taxas` (`tax_id`),
  CONSTRAINT `taxaArtigo_ibfk_3` FOREIGN KEY (`trt_estado`) REFERENCES `estados` (`est_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `taxaArtigo`
--

LOCK TABLES `taxaArtigos` WRITE;
/*!40000 ALTER TABLE `taxaArtigos` DISABLE KEYS */;
/*!40000 ALTER TABLE `taxaArtigos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `taxaCompra`
--

DROP TABLE IF EXISTS `taxaCompras`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `taxaCompras` (
  `tcm_id` int(11) NOT NULL AUTO_INCREMENT,
  `tcm_historicoStock_id` int(11) NOT NULL,
  `tcm_taxa_id` int(11) NOT NULL,
  `tcm_estado` int(11) NOT NULL,
  PRIMARY KEY (`tcm_id`),
  KEY `tcm_historicoStock_id` (`tcm_historicoStock_id`),
  KEY `tcm_taxa_id` (`tcm_taxa_id`),
  KEY `tcm_estado` (`tcm_estado`),
  CONSTRAINT `taxaCompra_ibfk_1` FOREIGN KEY (`tcm_historicoStock_id`) REFERENCES `historicoStocks` (`hst_id`),
  CONSTRAINT `taxaCompra_ibfk_2` FOREIGN KEY (`tcm_taxa_id`) REFERENCES `taxas` (`tax_id`),
  CONSTRAINT `taxaCompra_ibfk_3` FOREIGN KEY (`tcm_estado`) REFERENCES `estados` (`est_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `taxaCompra`
--

LOCK TABLES `taxaCompras` WRITE;
/*!40000 ALTER TABLE `taxaCompras` DISABLE KEYS */;
/*!40000 ALTER TABLE `taxaCompras` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `taxaVenda`
--

DROP TABLE IF EXISTS `taxaVendas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `taxaVendas` (
  `tvn_id` int(11) NOT NULL AUTO_INCREMENT,
  `tvn_estado` int(11) NOT NULL,
  `tvn_venda_id` int(11) DEFAULT NULL,
  `tvn_artigo_id` int(11) DEFAULT NULL,
  `tvn_taxa_id` int(11) DEFAULT NULL,
  `tvn_percentagem` double DEFAULT NULL,
  `tvn_valor` double DEFAULT NULL,
  `tvn_data_registrar` datetime NOT NULL DEFAULT current_timestamp(),
  `tvn_descricao` text DEFAULT NULL,
  PRIMARY KEY (`tvn_id`),
  KEY `tvn_artigo_id` (`tvn_artigo_id`),
  KEY `tvn_taxa_id` (`tvn_taxa_id`),
  KEY `tvn_venda_id` (`tvn_venda_id`),
  KEY `tvn_estado` (`tvn_estado`),
  CONSTRAINT `taxaVenda_ibfk_1` FOREIGN KEY (`tvn_artigo_id`) REFERENCES `artigos` (`art_id`),
  CONSTRAINT `taxaVenda_ibfk_2` FOREIGN KEY (`tvn_taxa_id`) REFERENCES `taxas` (`tax_id`),
  CONSTRAINT `taxaVenda_ibfk_3` FOREIGN KEY (`tvn_venda_id`) REFERENCES `vendas` (`ven_id`),
  CONSTRAINT `taxaVenda_ibfk_4` FOREIGN KEY (`tvn_estado`) REFERENCES `estados` (`est_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `taxaVenda`
--

LOCK TABLES `taxaVendas` WRITE;
/*!40000 ALTER TABLE `taxaVendas` DISABLE KEYS */;
/*!40000 ALTER TABLE `taxaVendas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipoArtigo`
--

DROP TABLE IF EXISTS `tipoArtigos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipoArtigos` (
  `tip_id` int(11) NOT NULL AUTO_INCREMENT,
  `tip_designacao` varchar(45) NOT NULL,
  `tip_estado_id` int(11) NOT NULL,
  PRIMARY KEY (`tip_id`),
  KEY `tip_estado_id` (`tip_estado_id`),
  CONSTRAINT `tipoArtigo_ibfk_1` FOREIGN KEY (`tip_estado_id`) REFERENCES `estados` (`est_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipoArtigo`
--

LOCK TABLES `tipoArtigos` WRITE;
/*!40000 ALTER TABLE `tipoArtigos` DISABLE KEYS */;
/*!40000 ALTER TABLE `tipoArtigos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarios` (
  `usu_id` int(11) NOT NULL AUTO_INCREMENT,
  `usu_username` varchar(45) NOT NULL,
  `usu_password` varchar(100) NOT NULL,
  `usu_pessoa_id` int(11) NOT NULL,
  `usu_nivelAcesso_id` int(11) NOT NULL,
  `usu_estado_id` int(11) NOT NULL,
  PRIMARY KEY (`usu_id`),
  UNIQUE KEY `usu_username` (`usu_username`),
  KEY `usu_nivelAcesso_id` (`usu_nivelAcesso_id`),
  KEY `usu_estado_id` (`usu_estado_id`),
  CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`usu_nivelAcesso_id`) REFERENCES `nivelAcessos` (`niv_id`),
  CONSTRAINT `usuario_ibfk_2` FOREIGN KEY (`usu_estado_id`) REFERENCES `estados` (`est_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `venda`
--

DROP TABLE IF EXISTS `vendas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vendas` (
  `ven_id` int(11) NOT NULL AUTO_INCREMENT,
  `ven_art_id` int(11) NOT NULL,
  `ven_total` double NOT NULL DEFAULT 0,
  `ven_quantidade` int(11) NOT NULL DEFAULT 0,
  `ven_troco` double NOT NULL DEFAULT 0,
  `ven_valor_pago` double NOT NULL DEFAULT 0,
  `ven_cliente_id` int(11) NOT NULL,
  `ven_estado` int(11) NOT NULL,
  `ven_descricao` text DEFAULT NULL,
  `ven_data_venda` datetime NOT NULL DEFAULT current_timestamp(),
  `ven_data_registrar` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`ven_id`),
  KEY `ven_cliente_id` (`ven_cliente_id`),
  KEY `ven_art_id` (`ven_art_id`),
  KEY `ven_estado` (`ven_estado`),
  CONSTRAINT `venda_ibfk_1` FOREIGN KEY (`ven_cliente_id`) REFERENCES `pessoas` (`pes_id`),
  CONSTRAINT `venda_ibfk_2` FOREIGN KEY (`ven_art_id`) REFERENCES `artigos` (`art_id`),
  CONSTRAINT `venda_ibfk_3` FOREIGN KEY (`ven_estado`) REFERENCES `estados` (`est_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `venda`
--

LOCK TABLES `vendas` WRITE;
/*!40000 ALTER TABLE `vendas` DISABLE KEYS */;
/*!40000 ALTER TABLE `vendas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'ift_faturacao'
--

--
-- Dumping routines for database 'ift_faturacao'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-07-19  9:23:02
