-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Ago 08, 2026 alle 14:27
-- Versione del server: 10.4.32-MariaDB
-- Versione PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `passione_motorsport`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `calendario`
--

CREATE TABLE `calendario` (
  `id` int(11) NOT NULL,
  `nome` varchar(150) NOT NULL,
  `reparto` enum('esports','reale') NOT NULL,
  `data_gara` date NOT NULL,
  `stato` enum('in programma','prossima','disputata') NOT NULL DEFAULT 'in programma'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `calendario`
--

INSERT INTO `calendario` (`id`, `nome`, `reparto`, `data_gara`, `stato`) VALUES
(7, 'Rally del Tirreno', 'esports', '2026-08-08', 'prossima'),
(8, 'Rally Bassano', 'reale', '2026-10-29', 'in programma');

-- --------------------------------------------------------

--
-- Struttura della tabella `candidature`
--

CREATE TABLE `candidature` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `reparto` enum('esports','reale') NOT NULL,
  `esperienza` text NOT NULL,
  `stato` enum('da leggere','letto','risposto') NOT NULL DEFAULT 'da leggere',
  `creato_il` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `categorie`
--

CREATE TABLE `categorie` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `categorie`
--

INSERT INTO `categorie` (`id`, `nome`) VALUES
(5, 'community'),
(6, 'e-rally'),
(3, 'gare');

-- --------------------------------------------------------

--
-- Struttura della tabella `categorie_setup`
--

CREATE TABLE `categorie_setup` (
  `id` int(11) NOT NULL,
  `slug` varchar(30) NOT NULL,
  `nome` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `categorie_setup`
--

INSERT INTO `categorie_setup` (`id`, `slug`, `nome`) VALUES
(1, 'rally2', 'Rally2'),
(2, 'rally3', 'Rally3'),
(3, 'rally4', 'Rally4'),
(4, 's1600', 'S1600'),
(5, 's2000', 'S2000');

-- --------------------------------------------------------

--
-- Struttura della tabella `gare_setup`
--

CREATE TABLE `gare_setup` (
  `id` int(11) NOT NULL,
  `categoria_id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `creato_il` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `gare_setup`
--

INSERT INTO `gare_setup` (`id`, `categoria_id`, `nome`, `creato_il`) VALUES
(2, 1, 'MonteCarlo', '2026-08-08 12:00:28'),
(3, 2, 'MonteCarlo', '2026-08-08 12:00:33'),
(4, 3, 'MonteCarlo', '2026-08-08 12:00:37'),
(6, 5, 'MonteCarlo', '2026-08-08 12:00:43'),
(7, 4, 'MonteCarlo', '2026-08-08 12:00:55');

-- --------------------------------------------------------

--
-- Struttura della tabella `messaggi`
--

CREATE TABLE `messaggi` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `motivo` varchar(100) NOT NULL,
  `messaggio` text NOT NULL,
  `stato` enum('da leggere','letto','risposto') NOT NULL DEFAULT 'da leggere',
  `creato_il` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `titolo` varchar(150) NOT NULL,
  `descrizione` text NOT NULL,
  `categoria_id` int(11) DEFAULT NULL,
  `immagine` varchar(255) DEFAULT NULL,
  `in_evidenza` tinyint(1) DEFAULT 0,
  `data_pubblicazione` date NOT NULL,
  `creato_il` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `news`
--

INSERT INTO `news` (`id`, `titolo`, `descrizione`, `categoria_id`, `immagine`, `in_evidenza`, `data_pubblicazione`, `creato_il`) VALUES
(8, 'RALLY CITTA\' DI NOALE', 'dsfsdfsdf', 6, 'assets/img/news/img_6a7718a872f6d3.98167967.PNG', 1, '2026-08-09', '2026-08-08 11:53:12');

-- --------------------------------------------------------

--
-- Struttura della tabella `richieste_sponsor`
--

CREATE TABLE `richieste_sponsor` (
  `id` int(11) NOT NULL,
  `azienda` varchar(150) NOT NULL,
  `referente` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `messaggio` text NOT NULL,
  `stato` enum('da leggere','letto','risposto') NOT NULL DEFAULT 'da leggere',
  `creato_il` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `setup_parametri`
--

CREATE TABLE `setup_parametri` (
  `id` int(11) NOT NULL,
  `gruppo` varchar(50) NOT NULL,
  `etichetta` varchar(150) NOT NULL,
  `unita` varchar(20) DEFAULT NULL,
  `ordine` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `setup_parametri`
--

INSERT INTO `setup_parametri` (`id`, `gruppo`, `etichetta`, `unita`, `ordine`) VALUES
(1, 'Assetto', 'Angolo di convergenza (anteriore)', '°', 1),
(2, 'Assetto', 'Angolo di campanatura (anteriore)', '°', 2),
(3, 'Assetto', 'Angolo di convergenza (posteriore)', '°', 3),
(4, 'Assetto', 'Angolo di campanatura (posteriore)', '°', 4),
(5, 'Frenata', 'Potenza frenante', 'N-m', 1),
(6, 'Frenata', 'Bilanciamento freni', '%', 2),
(7, 'Frenata', 'Forza del freno a mano', 'N-m', 3),
(8, 'Marce', '1ª marcia', NULL, 1),
(9, 'Marce', '2ª marcia', NULL, 2),
(10, 'Marce', '3ª marcia', NULL, 3),
(11, 'Marce', '4ª marcia', NULL, 4),
(12, 'Marce', '5ª marcia', NULL, 5),
(13, 'Marce', 'Rapporto finale', NULL, 6),
(14, 'Differenziali', 'Bloccaggio differenziale LSD accel. (ant.)', '%', 1),
(15, 'Differenziali', 'Bloccaggio differenziale LSD frenata (ant.)', '%', 2),
(16, 'Differenziali', 'Precarico differenziale LSD (ant.)', 'N-m', 3),
(17, 'Differenziali', 'Bloccaggio differenziale LSD accel. (post.)', '%', 4),
(18, 'Differenziali', 'Bloccaggio differenziale LSD frenata (post.)', '%', 5),
(19, 'Differenziali', 'Precarico differenziale LSD (post.)', 'N-m', 6),
(20, 'Ammortizzatori', 'Compressione lenta (anteriore)', NULL, 1),
(21, 'Ammortizzatori', 'Compressione veloce (anteriore)', NULL, 2),
(22, 'Ammortizzatori', 'Rapporto di compressione (anteriore)', 'm/s', 3),
(23, 'Ammortizzatori', 'Estensione lenta (anteriore)', NULL, 4),
(24, 'Ammortizzatori', 'Compressione lenta (posteriore)', NULL, 5),
(25, 'Ammortizzatori', 'Compressione veloce (posteriore)', NULL, 6),
(26, 'Ammortizzatori', 'Rapporto di compressione (posteriore)', 'm/s', 7),
(27, 'Ammortizzatori', 'Estensione lenta (posteriore)', NULL, 8),
(28, 'Molle', 'Altezza da terra (anteriore)', 'mm', 1),
(29, 'Molle', 'Flessibilità molla (anteriore)', 'N/mm', 2),
(30, 'Molle', 'Barra stabilizzatrice (anteriore)', 'N/mm', 3),
(31, 'Molle', 'Altezza da terra (posteriore)', 'mm', 4),
(32, 'Molle', 'Flessibilità molla (posteriore)', 'N/mm', 5),
(33, 'Molle', 'Barra stabilizzatrice (posteriore)', 'N/mm', 6);

-- --------------------------------------------------------

--
-- Struttura della tabella `setup_valori`
--

CREATE TABLE `setup_valori` (
  `id` int(11) NOT NULL,
  `gara_id` int(11) NOT NULL,
  `parametro_id` int(11) NOT NULL,
  `valore` decimal(10,3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `setup_valori`
--

INSERT INTO `setup_valori` (`id`, `gara_id`, `parametro_id`, `valore`) VALUES
(34, 2, 1, NULL),
(35, 2, 2, NULL),
(36, 2, 3, NULL),
(37, 2, 4, NULL),
(38, 2, 5, NULL),
(39, 2, 6, NULL),
(40, 2, 7, NULL),
(41, 2, 8, NULL),
(42, 2, 9, NULL),
(43, 2, 10, NULL),
(44, 2, 11, NULL),
(45, 2, 12, NULL),
(46, 2, 13, NULL),
(47, 2, 14, NULL),
(48, 2, 15, NULL),
(49, 2, 16, NULL),
(50, 2, 17, NULL),
(51, 2, 18, NULL),
(52, 2, 19, NULL),
(53, 2, 20, NULL),
(54, 2, 21, NULL),
(55, 2, 22, NULL),
(56, 2, 23, NULL),
(57, 2, 24, NULL),
(58, 2, 25, NULL),
(59, 2, 26, NULL),
(60, 2, 27, NULL),
(61, 2, 28, NULL),
(62, 2, 29, NULL),
(63, 2, 30, NULL),
(64, 2, 31, NULL),
(65, 2, 32, NULL),
(66, 2, 33, NULL),
(67, 3, 1, NULL),
(68, 3, 2, NULL),
(69, 3, 3, NULL),
(70, 3, 4, NULL),
(71, 3, 5, NULL),
(72, 3, 6, NULL),
(73, 3, 7, NULL),
(74, 3, 8, NULL),
(75, 3, 9, NULL),
(76, 3, 10, NULL),
(77, 3, 11, NULL),
(78, 3, 12, NULL),
(79, 3, 13, NULL),
(80, 3, 14, NULL),
(81, 3, 15, NULL),
(82, 3, 16, NULL),
(83, 3, 17, NULL),
(84, 3, 18, NULL),
(85, 3, 19, NULL),
(86, 3, 20, NULL),
(87, 3, 21, NULL),
(88, 3, 22, NULL),
(89, 3, 23, NULL),
(90, 3, 24, NULL),
(91, 3, 25, NULL),
(92, 3, 26, NULL),
(93, 3, 27, NULL),
(94, 3, 28, NULL),
(95, 3, 29, NULL),
(96, 3, 30, NULL),
(97, 3, 31, NULL),
(98, 3, 32, NULL),
(99, 3, 33, NULL),
(100, 4, 1, NULL),
(101, 4, 2, NULL),
(102, 4, 3, NULL),
(103, 4, 4, NULL),
(104, 4, 5, NULL),
(105, 4, 6, NULL),
(106, 4, 7, NULL),
(107, 4, 8, NULL),
(108, 4, 9, NULL),
(109, 4, 10, NULL),
(110, 4, 11, NULL),
(111, 4, 12, NULL),
(112, 4, 13, NULL),
(113, 4, 14, NULL),
(114, 4, 15, NULL),
(115, 4, 16, NULL),
(116, 4, 17, NULL),
(117, 4, 18, NULL),
(118, 4, 19, NULL),
(119, 4, 20, NULL),
(120, 4, 21, NULL),
(121, 4, 22, NULL),
(122, 4, 23, NULL),
(123, 4, 24, NULL),
(124, 4, 25, NULL),
(125, 4, 26, NULL),
(126, 4, 27, NULL),
(127, 4, 28, NULL),
(128, 4, 29, NULL),
(129, 4, 30, NULL),
(130, 4, 31, NULL),
(131, 4, 32, NULL),
(132, 4, 33, NULL),
(166, 6, 1, NULL),
(167, 6, 2, NULL),
(168, 6, 3, NULL),
(169, 6, 4, NULL),
(170, 6, 5, NULL),
(171, 6, 6, NULL),
(172, 6, 7, NULL),
(173, 6, 8, NULL),
(174, 6, 9, NULL),
(175, 6, 10, NULL),
(176, 6, 11, NULL),
(177, 6, 12, NULL),
(178, 6, 13, NULL),
(179, 6, 14, NULL),
(180, 6, 15, NULL),
(181, 6, 16, NULL),
(182, 6, 17, NULL),
(183, 6, 18, NULL),
(184, 6, 19, NULL),
(185, 6, 20, NULL),
(186, 6, 21, NULL),
(187, 6, 22, NULL),
(188, 6, 23, NULL),
(189, 6, 24, NULL),
(190, 6, 25, NULL),
(191, 6, 26, NULL),
(192, 6, 27, NULL),
(193, 6, 28, NULL),
(194, 6, 29, NULL),
(195, 6, 30, NULL),
(196, 6, 31, NULL),
(197, 6, 32, NULL),
(198, 6, 33, NULL),
(199, 7, 1, NULL),
(200, 7, 2, NULL),
(201, 7, 3, NULL),
(202, 7, 4, NULL),
(203, 7, 5, NULL),
(204, 7, 6, NULL),
(205, 7, 7, NULL),
(206, 7, 8, NULL),
(207, 7, 9, NULL),
(208, 7, 10, NULL),
(209, 7, 11, NULL),
(210, 7, 12, NULL),
(211, 7, 13, NULL),
(212, 7, 14, NULL),
(213, 7, 15, NULL),
(214, 7, 16, NULL),
(215, 7, 17, NULL),
(216, 7, 18, NULL),
(217, 7, 19, NULL),
(218, 7, 20, NULL),
(219, 7, 21, NULL),
(220, 7, 22, NULL),
(221, 7, 23, NULL),
(222, 7, 24, NULL),
(223, 7, 25, NULL),
(224, 7, 26, NULL),
(225, 7, 27, NULL),
(226, 7, 28, NULL),
(227, 7, 29, NULL),
(228, 7, 30, NULL),
(229, 7, 31, NULL),
(230, 7, 32, NULL),
(231, 7, 33, NULL);

-- --------------------------------------------------------

--
-- Struttura della tabella `sponsor`
--

CREATE TABLE `sponsor` (
  `id` int(11) NOT NULL,
  `nome` varchar(150) NOT NULL,
  `livello` enum('supporter','official partner','tech partner') NOT NULL,
  `logo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `sponsor`
--

INSERT INTO `sponsor` (`id`, `nome`, `livello`, `logo`) VALUES
(4, 'GlobalRallyNetwork', 'tech partner', 'assets/img/sponsor/img_6a6f72963cf272.21810348.png'),
(5, 'OfficinaTech', 'supporter', 'assets/img/sponsor/img_6a6f72b1b59a12.39431901.png'),
(6, 'eb', 'official partner', 'assets/img/sponsor/img_6a6f72c163f659.18708010.png');

-- --------------------------------------------------------

--
-- Struttura della tabella `utenti_admin`
--

CREATE TABLE `utenti_admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `ruolo` enum('admin','manager','membro') NOT NULL DEFAULT 'membro',
  `creato_il` timestamp NOT NULL DEFAULT current_timestamp(),
  `foto_profilo` varchar(255) DEFAULT NULL,
  `categoria` varchar(50) DEFAULT NULL,
  `ultima_posizione` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `utenti_admin`
--

INSERT INTO `utenti_admin` (`id`, `username`, `password`, `ruolo`, `creato_il`, `foto_profilo`, `categoria`, `ultima_posizione`) VALUES
(1, 'vale', '$2y$10$qP3J49q6o7zbdYQGCuNGAei88ZbjvMcJOB7SRowTqU2LMdR4bmb4y', 'manager', '2026-07-27 13:22:42', 'assets/img/piloti/img_6a73a6f23b5fe8.06679885.png', 'Rally3', '2°categoria'),
(2, 'saby', '$2y$10$bHPCyayNqt95K/GmKCHsVe4Lsqi7YMBZ6gQnN9JOk55pb.rWICg9i', 'membro', '2026-07-27 13:23:17', 'assets/img/piloti/img_6a7719cc972506.52691016.jpg', 'Rally4', '1°categoria'),
(3, 'Giovanni', '$2y$10$U0IjgkCoakRzHVNKA3nGFuG7UfW2W5.DWHlffaMhdBArizz.nTsOu', 'admin', '2026-07-27 13:23:55', NULL, NULL, NULL);

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `calendario`
--
ALTER TABLE `calendario`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `candidature`
--
ALTER TABLE `candidature`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome` (`nome`);

--
-- Indici per le tabelle `categorie_setup`
--
ALTER TABLE `categorie_setup`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indici per le tabelle `gare_setup`
--
ALTER TABLE `gare_setup`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categoria_id` (`categoria_id`);

--
-- Indici per le tabelle `messaggi`
--
ALTER TABLE `messaggi`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categoria_id` (`categoria_id`);

--
-- Indici per le tabelle `richieste_sponsor`
--
ALTER TABLE `richieste_sponsor`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `setup_parametri`
--
ALTER TABLE `setup_parametri`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `setup_valori`
--
ALTER TABLE `setup_valori`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unico_gara_parametro` (`gara_id`,`parametro_id`),
  ADD KEY `parametro_id` (`parametro_id`);

--
-- Indici per le tabelle `sponsor`
--
ALTER TABLE `sponsor`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `utenti_admin`
--
ALTER TABLE `utenti_admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `calendario`
--
ALTER TABLE `calendario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT per la tabella `candidature`
--
ALTER TABLE `candidature`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT per la tabella `categorie`
--
ALTER TABLE `categorie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT per la tabella `categorie_setup`
--
ALTER TABLE `categorie_setup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT per la tabella `gare_setup`
--
ALTER TABLE `gare_setup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT per la tabella `messaggi`
--
ALTER TABLE `messaggi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT per la tabella `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT per la tabella `richieste_sponsor`
--
ALTER TABLE `richieste_sponsor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT per la tabella `setup_parametri`
--
ALTER TABLE `setup_parametri`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT per la tabella `setup_valori`
--
ALTER TABLE `setup_valori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=232;

--
-- AUTO_INCREMENT per la tabella `sponsor`
--
ALTER TABLE `sponsor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT per la tabella `utenti_admin`
--
ALTER TABLE `utenti_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `gare_setup`
--
ALTER TABLE `gare_setup`
  ADD CONSTRAINT `gare_setup_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `categorie_setup` (`id`) ON DELETE CASCADE;

--
-- Limiti per la tabella `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `news_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `categorie` (`id`) ON DELETE SET NULL;

--
-- Limiti per la tabella `setup_valori`
--
ALTER TABLE `setup_valori`
  ADD CONSTRAINT `setup_valori_ibfk_1` FOREIGN KEY (`gara_id`) REFERENCES `gare_setup` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `setup_valori_ibfk_2` FOREIGN KEY (`parametro_id`) REFERENCES `setup_parametri` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
