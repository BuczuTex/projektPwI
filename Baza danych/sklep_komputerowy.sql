-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 24 Mar 2020, 17:58
-- Wersja serwera: 10.4.11-MariaDB
-- Wersja PHP: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `sklep_komputerowy`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `admin`
--

CREATE TABLE `admin` (
  `id_admina` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `nazwa_uzytkownika` varchar(30) NOT NULL,
  `haslo` char(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `klienci`
--

CREATE TABLE `klienci` (
  `id_klienta` int(11) NOT NULL,
  `id_koszyka` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `nazwa_użytkownika` varchar(30) NOT NULL,
  `hasło` char(128) NOT NULL,
  `imie` varchar(30) NOT NULL,
  `nazwisko` varchar(30) NOT NULL,
  `miasto` varchar(50) NOT NULL,
  `adres` varchar(50) NOT NULL,
  `kod_pocztowy` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `koszyk`
--

CREATE TABLE `koszyk` (
  `id_koszyka` int(11) NOT NULL,
  `id_klienta` int(11) NOT NULL,
  `data` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `opinie`
--

CREATE TABLE `opinie` (
  `id_opinii` int(11) NOT NULL,
  `id_produktu` int(11) NOT NULL,
  `id_klienta` int(11) NOT NULL,
  `data` datetime NOT NULL,
  `tresc` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `produkty`
--

CREATE TABLE `produkty` (
  `id_produktu` int(11) NOT NULL,
  `nazwa_produktu` varchar(100) NOT NULL,
  `ilość` int(11) NOT NULL,
  `specyfikacja` text NOT NULL,
  `opis` text NOT NULL,
  `cena` int(11) NOT NULL,
  `cena_promocyjna` int(11) DEFAULT NULL,
  `zdjecie` int(11) NOT NULL COMMENT 'scieżka do zdjęcia',
  `gwarancja` int(11) NOT NULL COMMENT 'gwarancja podawana w miesiącach'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `produkty_w_koszyku`
--

CREATE TABLE `produkty_w_koszyku` (
  `id` int(11) NOT NULL,
  `id_koszyka` int(11) NOT NULL,
  `id_produktu` int(11) NOT NULL,
  `ilość` int(11) NOT NULL,
  `cena` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zamowienia`
--

CREATE TABLE `zamowienia` (
  `id_zamowienia` int(11) NOT NULL,
  `id_klienta` int(11) NOT NULL,
  `wartosc_zamowienia` int(11) NOT NULL,
  `sposob_dostawy` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admina`);

--
-- Indeksy dla tabeli `klienci`
--
ALTER TABLE `klienci`
  ADD PRIMARY KEY (`id_klienta`),
  ADD KEY `id_koszyka` (`id_koszyka`);

--
-- Indeksy dla tabeli `koszyk`
--
ALTER TABLE `koszyk`
  ADD PRIMARY KEY (`id_koszyka`),
  ADD KEY `id_klienta` (`id_klienta`);

--
-- Indeksy dla tabeli `opinie`
--
ALTER TABLE `opinie`
  ADD PRIMARY KEY (`id_opinii`),
  ADD KEY `id_produktu` (`id_produktu`),
  ADD KEY `id_klienta` (`id_klienta`);

--
-- Indeksy dla tabeli `produkty`
--
ALTER TABLE `produkty`
  ADD PRIMARY KEY (`id_produktu`);

--
-- Indeksy dla tabeli `produkty_w_koszyku`
--
ALTER TABLE `produkty_w_koszyku`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_koszyka` (`id_koszyka`),
  ADD KEY `id_produktu` (`id_produktu`);

--
-- Indeksy dla tabeli `zamowienia`
--
ALTER TABLE `zamowienia`
  ADD PRIMARY KEY (`id_zamowienia`),
  ADD KEY `id_klienta` (`id_klienta`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admina` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `klienci`
--
ALTER TABLE `klienci`
  MODIFY `id_klienta` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `koszyk`
--
ALTER TABLE `koszyk`
  MODIFY `id_koszyka` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `opinie`
--
ALTER TABLE `opinie`
  MODIFY `id_opinii` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `produkty`
--
ALTER TABLE `produkty`
  MODIFY `id_produktu` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `produkty_w_koszyku`
--
ALTER TABLE `produkty_w_koszyku`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `zamowienia`
--
ALTER TABLE `zamowienia`
  MODIFY `id_zamowienia` int(11) NOT NULL AUTO_INCREMENT;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `klienci`
--
ALTER TABLE `klienci`
  ADD CONSTRAINT `klienci_ibfk_1` FOREIGN KEY (`id_koszyka`) REFERENCES `koszyk` (`id_koszyka`);

--
-- Ograniczenia dla tabeli `koszyk`
--
ALTER TABLE `koszyk`
  ADD CONSTRAINT `koszyk_ibfk_1` FOREIGN KEY (`id_klienta`) REFERENCES `klienci` (`id_klienta`);

--
-- Ograniczenia dla tabeli `opinie`
--
ALTER TABLE `opinie`
  ADD CONSTRAINT `opinie_ibfk_1` FOREIGN KEY (`id_produktu`) REFERENCES `produkty` (`id_produktu`),
  ADD CONSTRAINT `opinie_ibfk_2` FOREIGN KEY (`id_klienta`) REFERENCES `klienci` (`id_klienta`);

--
-- Ograniczenia dla tabeli `produkty_w_koszyku`
--
ALTER TABLE `produkty_w_koszyku`
  ADD CONSTRAINT `produkty_w_koszyku_ibfk_1` FOREIGN KEY (`id_koszyka`) REFERENCES `koszyk` (`id_koszyka`),
  ADD CONSTRAINT `produkty_w_koszyku_ibfk_2` FOREIGN KEY (`id_produktu`) REFERENCES `produkty` (`id_produktu`);

--
-- Ograniczenia dla tabeli `zamowienia`
--
ALTER TABLE `zamowienia`
  ADD CONSTRAINT `zamowienia_ibfk_1` FOREIGN KEY (`id_klienta`) REFERENCES `klienci` (`id_klienta`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
