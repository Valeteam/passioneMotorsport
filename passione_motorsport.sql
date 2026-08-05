-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Ago 05, 2026 alle 21:06
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
(7, 'Rally del Tirreno', 'esports', '2026-08-08', 'in programma'),
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
(3, 'gare');

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
(6, 'RALLY CITTA\' DI NOALE', 'rally vinto da dfdfggf', 5, 'assets/img/news/img_6a6f65327d97d1.89370235.PNG', 1, '2026-08-02', '2026-08-02 15:41:38');

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
  `foto_profilo` mediumtext NOT NULL,
  `categoria` mediumtext NOT NULL,
  `position` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `utenti_admin`
--

INSERT INTO `utenti_admin` (`id`, `username`, `password`, `ruolo`, `creato_il`, `foto_profilo`, `categoria`, `position`) VALUES
(1, 'vale', '$2y$10$qP3J49q6o7zbdYQGCuNGAei88ZbjvMcJOB7SRowTqU2LMdR4bmb4y', 'manager', '2026-07-27 13:22:42', '', '', ''),
(2, 'saby', '$2y$10$bHPCyayNqt95K/GmKCHsVe4Lsqi7YMBZ6gQnN9JOk55pb.rWICg9i', 'membro', '2026-07-27 13:23:17', '', '', ''),
(3, 'Giovanni', '$2y$10$U0IjgkCoakRzHVNKA3nGFuG7UfW2W5.DWHlffaMhdBArizz.nTsOu', 'admin', '2026-07-27 13:23:55', '', '', '');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT per la tabella `messaggi`
--
ALTER TABLE `messaggi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT per la tabella `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT per la tabella `richieste_sponsor`
--
ALTER TABLE `richieste_sponsor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
-- Limiti per la tabella `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `news_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `categorie` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
