/*
SQLyog Ultimate v9.50 
MySQL - 5.6.12-log : Database - pag_seguro
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `item` */

DROP TABLE IF EXISTS `item`;

CREATE TABLE `item` (
  `itemId` int(11) NOT NULL AUTO_INCREMENT,
  `itemIdentificador` varchar(100) DEFAULT NULL,
  `itemDescricao` text,
  `itemValorUnitario` decimal(9,2) DEFAULT NULL,
  `itemQuantidade` int(11) DEFAULT NULL,
  `codigoIdentificadorDaTransacao` varchar(200) NOT NULL,
  `id_log` int(11) NOT NULL,
  PRIMARY KEY (`itemId`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Table structure for table `log` */

DROP TABLE IF EXISTS `log`;

CREATE TABLE `log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dataDaCriacaoDaTransacao` varchar(200) DEFAULT NULL,
  `codigoIdentificadorDaTransacao` varchar(200) DEFAULT NULL,
  `codigoDeReferenciaDaTransacao` varchar(200) DEFAULT NULL,
  `tipoDaTransacao` int(11) DEFAULT NULL,
  `statusDaTransacao` int(11) DEFAULT NULL,
  `origemDoCancelamento` varchar(200) DEFAULT NULL,
  `dataDoUltimoEvento` varchar(200) DEFAULT NULL,
  `tipoDoMeioDePagamentoType` int(11) DEFAULT NULL,
  `tipoDoMeioDePagamentoCode` int(11) DEFAULT NULL,
  `valorBrutoDaTransacao` decimal(9,2) DEFAULT NULL,
  `valorDoDescontoDado` decimal(9,2) DEFAULT NULL,
  `valorTotalDasTaxasCobradas` decimal(9,2) DEFAULT NULL,
  `valorLiquidoDatransacao` decimal(9,2) DEFAULT NULL,
  `dataDecredito` varchar(200) DEFAULT NULL,
  `valorExtra` decimal(9,2) DEFAULT NULL,
  `numeroDeParcelas` int(11) DEFAULT NULL,
  `numeroDeItensDaTransacao` int(11) DEFAULT NULL,
  `emailDoComprador` varchar(200) DEFAULT NULL,
  `nomecompletoDoComprador` varchar(200) DEFAULT NULL,
  `dddDoComprador` int(11) DEFAULT NULL,
  `numeroDeTelefoneDoComprador` int(11) DEFAULT NULL,
  `tipoDeFrete` int(11) DEFAULT NULL,
  `custoTotalDoFrete` decimal(9,2) DEFAULT NULL,
  `paisDoEnderecoDeEnvio` varchar(200) DEFAULT NULL,
  `estadoDoEnderecoDeEnvio` char(2) DEFAULT NULL,
  `cidadeDoEnderecoDeEnvio` varchar(200) DEFAULT NULL,
  `cepDoEnderecoDeEnvio` int(11) DEFAULT NULL,
  `bairroDoEnderecoDeEnvio` varchar(200) DEFAULT NULL,
  `nomeDaRuaDoEnderecoDeEnvio` varchar(200) DEFAULT NULL,
  `numeroDoEnderecoDeEnvio` int(11) DEFAULT NULL,
  `complementoDoEnderecoDeEnvio` varchar(200) DEFAULT NULL,
  `id_cliente_contrato` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Table structure for table `meio_pagamento` */

DROP TABLE IF EXISTS `meio_pagamento`;

CREATE TABLE `meio_pagamento` (
  `meio_pagamento_id` int(11) NOT NULL AUTO_INCREMENT,
  `meio_pagamento_codigo` int(11) DEFAULT NULL,
  `meio_pagamento_sgnificado` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`meio_pagamento_id`)
) ENGINE=MyISAM AUTO_INCREMENT=41 DEFAULT CHARSET=utf8;

/*Table structure for table `tipo_frete` */

DROP TABLE IF EXISTS `tipo_frete`;

CREATE TABLE `tipo_frete` (
  `tipo_frete_id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_frete_codigo` int(11) NOT NULL,
  `tipo_frete_significado` varchar(200) NOT NULL,
  PRIMARY KEY (`tipo_frete_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Table structure for table `tipo_pagamento` */

DROP TABLE IF EXISTS `tipo_pagamento`;

CREATE TABLE `tipo_pagamento` (
  `tipo_pagamento_id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_pagamento_codigo` int(11) NOT NULL,
  `tipo_pagamento_significado` varchar(200) NOT NULL,
  `descricao` text,
  PRIMARY KEY (`tipo_pagamento_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Table structure for table `transacao` */

DROP TABLE IF EXISTS `transacao`;

CREATE TABLE `transacao` (
  `transacao_id` int(11) NOT NULL AUTO_INCREMENT,
  `transacao_codigo` int(11) NOT NULL,
  `transacao_significado` varchar(200) NOT NULL,
  `transacao_descricoa` text NOT NULL,
  PRIMARY KEY (`transacao_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
