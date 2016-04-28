-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 27, 2014 at 06:23 AM
-- Server version: 5.6.20
-- PHP Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `laescalera`
--

-- --------------------------------------------------------

--
-- Table structure for table `actividades`
--

CREATE TABLE IF NOT EXISTS `actividades` (
`act_idact` int(10) unsigned NOT NULL,
  `act_respo` int(10) unsigned NOT NULL,
  `act_descr` varchar(200) NOT NULL,
  `act_tipoa` int(10) unsigned NOT NULL,
  `act_feini` date NOT NULL,
  `act_fefin` date NOT NULL,
  `act_repet` int(11) NOT NULL,
  `act_esfac` char(1) NOT NULL,
  `act_tarifa` decimal(10,0) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=40 ;

--
-- Dumping data for table `actividades`
--

INSERT INTO `actividades` (`act_idact`, `act_respo`, `act_descr`, `act_tipoa`, `act_feini`, `act_fefin`, `act_repet`, `act_esfac`, `act_tarifa`) VALUES
(5, 7, 'jhgjghjgh', 1, '2014-02-01', '2014-03-01', 0, 'S', '0'),
(6, 7, 'jhgjghjgh', 1, '2014-02-01', '2014-03-01', 0, 'S', '0'),
(7, 7, 'jhgjghjgh', 1, '2014-02-01', '2014-03-01', 0, 'S', '0'),
(8, 7, 'aaaaaaa', 1, '2014-02-01', '2014-03-01', 0, 'S', '0'),
(9, 7, 'aaaaaaa', 1, '2014-02-01', '2014-03-01', 0, 'S', '0'),
(15, 7, 'Ã±Ã±Ã±Ã±Ã±Ã±Ã±', 1, '2014-10-01', '2014-10-30', 0, 'S', '0'),
(16, 7, 'Ã±Ã±Ã±Ã±Ã±Ã±Ã±', 1, '2014-10-01', '2014-10-30', 0, 'S', '0'),
(17, 7, 'tockasd', 1, '2014-02-01', '2014-03-20', 0, 'S', '0'),
(20, 6, 'satahasdd', 2, '2014-01-01', '2014-02-02', 0, 'S', '0'),
(21, 6, 'satahasdd', 2, '2014-01-01', '2014-02-02', 2, 'S', '0'),
(22, 2, 'puto', 2, '2014-03-10', '2014-03-15', 0, 'N', '0'),
(23, 7, 'sdasdasdasd', 1, '2014-01-01', '2014-01-01', 0, 'N', '0'),
(24, 7, 'sdasdasdasd', 1, '2014-04-01', '2014-04-05', 0, 'N', '0'),
(25, 7, 'sdasdasdasd', 1, '2014-04-01', '2014-04-05', 0, 'N', '0'),
(26, 7, 'sdasdasdasd', 1, '2014-04-01', '2014-04-05', 0, 'N', '0'),
(27, 7, 'sdasdasdasd', 1, '2014-04-01', '2014-04-05', 0, 'N', '0'),
(30, 7, 'esgrima', 1, '2014-11-10', '2014-11-20', 2, 'S', '0'),
(31, 5, 'Taikuando', 2, '2014-11-01', '2014-12-30', 2, 'S', '0'),
(32, 7, 'jghjghjgh', 2, '2014-11-06', '2014-11-30', 2, 'S', '0'),
(33, 6, 'dasdasdasfasd', 3, '2014-11-26', '2014-11-30', 2, 'S', '0'),
(34, 7, 'dasdfasd', 3, '2014-11-05', '2014-11-14', 2, 'N', '0'),
(36, 7, 'ddddddddddd', 2, '2014-12-06', '2014-12-14', 1, 'N', '0'),
(37, 7, 'hjkjkhkhjk', 1, '2014-11-06', '2014-11-22', 2, 'S', '0'),
(38, 10, 'jghjghjghj', 1, '2014-11-05', '2014-11-21', 1, 'N', '0'),
(39, 10, 'ghjhgjghjghj', 1, '2015-01-23', '2015-01-24', 1, 'S', '70');

-- --------------------------------------------------------

--
-- Table structure for table `actividades_dias`
--

CREATE TABLE IF NOT EXISTS `actividades_dias` (
  `acd_idact` int(10) unsigned NOT NULL,
  `acd_diaac` int(10) unsigned NOT NULL,
  `acd_horai` time NOT NULL,
  `acd_horaf` time NOT NULL,
  `acd_idaul` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `actividades_dias`
--

INSERT INTO `actividades_dias` (`acd_idact`, `acd_diaac`, `acd_horai`, `acd_horaf`, `acd_idaul`) VALUES
(15, 0, '10:00:00', '11:00:00', 1),
(16, 0, '15:00:00', '16:00:00', 1),
(17, 1, '10:00:00', '11:00:00', 1),
(17, 4, '12:00:00', '13:00:00', 1),
(17, 5, '14:00:00', '16:00:00', 1),
(20, 1, '14:00:00', '17:00:00', 1),
(21, 4, '17:00:00', '18:00:00', 1),
(22, 1, '10:00:00', '12:00:00', 1),
(22, 3, '14:00:00', '15:00:00', 1),
(23, 1, '20:00:00', '22:00:00', 1),
(24, 1, '10:00:00', '12:00:00', 1),
(25, 2, '00:00:00', '00:00:00', 1),
(26, 4, '10:00:00', '08:00:00', 1),
(27, 5, '10:00:00', '09:00:00', 1),
(28, 0, '05:00:00', '06:00:00', 1),
(29, 0, '14:00:00', '17:00:00', 1),
(30, 1, '16:00:00', '17:00:00', 1),
(30, 3, '17:00:00', '17:30:00', 2),
(31, 7, '17:00:00', '19:00:00', 1),
(32, 3, '20:00:00', '22:00:00', 1),
(33, 4, '11:00:00', '11:10:00', 1),
(33, 6, '11:00:00', '11:10:00', 2),
(34, 6, '20:00:00', '21:10:00', 2),
(34, 7, '20:00:00', '20:10:00', 1),
(35, 0, '08:00:00', '09:00:00', 2),
(36, 0, '01:00:00', '02:00:00', 1),
(37, 1, '23:00:00', '23:20:00', 1),
(38, 0, '00:00:00', '01:00:00', 1),
(39, 0, '10:00:00', '12:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `aulas`
--

CREATE TABLE IF NOT EXISTS `aulas` (
`aul_idaul` int(10) unsigned NOT NULL,
  `aul_descr` varchar(100) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `aulas`
--

INSERT INTO `aulas` (`aul_idaul`, `aul_descr`) VALUES
(1, 'Aula numero 1'),
(2, 'Aula numero 2');

-- --------------------------------------------------------

--
-- Table structure for table `pagos`
--

CREATE TABLE IF NOT EXISTS `pagos` (
`pag_numpa` int(10) unsigned NOT NULL,
  `pag_fegen` datetime NOT NULL,
  `pag_anio` int(11) NOT NULL,
  `pag_mes` int(11) NOT NULL,
  `pag_idres` int(10) unsigned NOT NULL,
  `pag_total` decimal(10,0) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `pagos`
--

INSERT INTO `pagos` (`pag_numpa`, `pag_fegen`, `pag_anio`, `pag_mes`, `pag_idres`, `pag_total`) VALUES
(6, '2014-11-27 00:00:00', 2015, 1, 10, '140'),
(7, '2014-11-27 00:00:00', 2014, 11, 7, '0'),
(8, '2014-11-27 00:00:00', 2014, 11, 5, '0');

-- --------------------------------------------------------

--
-- Table structure for table `pagos_actividades`
--

CREATE TABLE IF NOT EXISTS `pagos_actividades` (
`pac_idpac` int(10) unsigned NOT NULL,
  `pac_idact` int(10) unsigned NOT NULL,
  `pac_monto` decimal(10,0) NOT NULL,
  `pac_canti` int(11) NOT NULL,
  `pac_idpago` int(10) unsigned NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `pagos_actividades`
--

INSERT INTO `pagos_actividades` (`pac_idpac`, `pac_idact`, `pac_monto`, `pac_canti`, `pac_idpago`) VALUES
(1, 39, '140', 2, 6),
(2, 30, '0', 4, 7),
(3, 32, '0', 3, 7),
(4, 34, '0', 2, 7),
(5, 37, '0', 2, 7),
(6, 31, '0', 5, 8);

-- --------------------------------------------------------

--
-- Table structure for table `responsables`
--

CREATE TABLE IF NOT EXISTS `responsables` (
`res_idres` int(10) unsigned NOT NULL,
  `res_nombr` varchar(100) NOT NULL,
  `res_docum` varchar(30) NOT NULL,
  `res_domic` varchar(200) NOT NULL,
  `res_local` varchar(200) NOT NULL,
  `res_email` varchar(100) NOT NULL,
  `res_telef` varchar(50) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `responsables`
--

INSERT INTO `responsables` (`res_idres`, `res_nombr`, `res_docum`, `res_domic`, `res_local`, `res_email`, `res_telef`) VALUES
(1, 'Hernan Suarez', '25878542', 'La paloma 213', 'Castelar', 'algo@gmail.com', '45288751'),
(2, 'Camilo Espinoza', '24878542', 'Guemes 223', 'Castelar', 'algo@gmail.com', '45288751'),
(3, 'Federico Sanchez', '45878542', 'Laproba 777', 'Castelar', 'algo@gmail.com', '45288751'),
(4, 'Anabella Soto', '35478542', 'Calle falsa 123', 'Castelar', 'algo@gmail.com', '45288751'),
(5, 'Romina Hernandez', '25868542', 'Calle falsa 124', 'Castelar', 'algo@gmail.com', '45288751'),
(6, 'Facundo Grana', '25878592', 'Calle falsa 125', 'Castelar', 'algo@gmail.com', '45288751'),
(7, 'Serena Morena', '25879542', 'Calle falsa 123', 'Castelar', 'algo@gmail.com', '45288751'),
(8, 'Sol Lipi', '25878582', 'Calle falsa 123', 'Castelar', 'algo@gmail.com', '45288751'),
(9, 'Fabricio Longuno', '32878542', 'Calle falsa 123', 'Castelar', 'algo@gmail.com', '45288751'),
(10, 'Ignacio Shaguarma', '38878542', 'Calle falsa 123', 'Castelar', 'algo@gmail.com', '45288751');

-- --------------------------------------------------------

--
-- Table structure for table `tipoactividad`
--

CREATE TABLE IF NOT EXISTS `tipoactividad` (
`tac_tipid` int(10) unsigned NOT NULL,
  `tac_descr` varchar(200) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `tipoactividad`
--

INSERT INTO `tipoactividad` (`tac_tipid`, `tac_descr`) VALUES
(1, 'Taller'),
(2, 'Espectaculo'),
(3, 'Evento');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `actividades`
--
ALTER TABLE `actividades`
 ADD PRIMARY KEY (`act_idact`);

--
-- Indexes for table `actividades_dias`
--
ALTER TABLE `actividades_dias`
 ADD PRIMARY KEY (`acd_idact`,`acd_diaac`,`acd_horai`,`acd_idaul`);

--
-- Indexes for table `aulas`
--
ALTER TABLE `aulas`
 ADD PRIMARY KEY (`aul_idaul`);

--
-- Indexes for table `pagos`
--
ALTER TABLE `pagos`
 ADD PRIMARY KEY (`pag_numpa`);

--
-- Indexes for table `pagos_actividades`
--
ALTER TABLE `pagos_actividades`
 ADD PRIMARY KEY (`pac_idpac`);

--
-- Indexes for table `responsables`
--
ALTER TABLE `responsables`
 ADD PRIMARY KEY (`res_idres`);

--
-- Indexes for table `tipoactividad`
--
ALTER TABLE `tipoactividad`
 ADD PRIMARY KEY (`tac_tipid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `actividades`
--
ALTER TABLE `actividades`
MODIFY `act_idact` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=40;
--
-- AUTO_INCREMENT for table `aulas`
--
ALTER TABLE `aulas`
MODIFY `aul_idaul` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `pagos`
--
ALTER TABLE `pagos`
MODIFY `pag_numpa` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `pagos_actividades`
--
ALTER TABLE `pagos_actividades`
MODIFY `pac_idpac` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `responsables`
--
ALTER TABLE `responsables`
MODIFY `res_idres` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `tipoactividad`
--
ALTER TABLE `tipoactividad`
MODIFY `tac_tipid` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
