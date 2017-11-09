-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 09 Lis 2017, 22:05
-- Wersja serwera: 10.1.25-MariaDB
-- Wersja PHP: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `vmcshop_basic`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `vmcs_logs`
--

CREATE TABLE `vmcs_logs` (
  `id` int(11) NOT NULL,
  `user` varchar(255) NOT NULL,
  `section` varchar(255) NOT NULL,
  `details` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- Struktura tabeli dla tabeli `vmcs_pages`
--

CREATE TABLE `vmcs_pages` (
  `id` int(11) NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `content` text,
  `active` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Struktura tabeli dla tabeli `vmcs_payments`
--

CREATE TABLE `vmcs_payments` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `config` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `vmcs_payments`
--

INSERT INTO `vmcs_payments` (`id`, `name`, `config`) VALUES
(1, 'MicroSMS.pl', '{\"sms\":{\"userid\":\"0\",\"percentage\":0.45}}'),
(2, 'Lvlup.pro', '{\"sms\":{\"userid\":\"0\",\"percentage\":0.45}}'),
(3, 'Homepay.pl', '{\"sms\":{\"userid\":\01\",\"apikey\":\"none\",\"percentage\":0.45}}'),
(4, 'Pukawka.pl', '{\"sms\":{\"apikey\":\"none\",\"percentage\":0.45}}'),
(5, 'PayPal', '{\"adress\":null}');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `vmcs_paypalpayments`
--

CREATE TABLE `vmcs_paypalpayments` (
  `id` int(11) NOT NULL,
  `service` int(11) NOT NULL,
  `user` varchar(255) NOT NULL,
  `txn` varchar(255) DEFAULT NULL,
  `hash` varchar(255) NOT NULL,
  `gross` double NOT NULL,
  `currency` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `fee` double DEFAULT NULL,
  `payer_name` varchar(255) DEFAULT NULL,
  `payer_mail` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `vmcs_purchases`
--

CREATE TABLE `vmcs_purchases` (
  `id` int(11) NOT NULL,
  `buyer` varchar(255) NOT NULL,
  `service` int(11) NOT NULL,
  `server` int(11) NOT NULL,
  `method` varchar(255) NOT NULL,
  `details` text NOT NULL,
  `profit` double NOT NULL,
  `date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Struktura tabeli dla tabeli `vmcs_servers`
--

CREATE TABLE `vmcs_servers` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `ip` varchar(16) NOT NULL,
  `port` int(11) NOT NULL,
  `rcon_port` int(11) NOT NULL,
  `rcon_pass` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Struktura tabeli dla tabeli `vmcs_services`
--

CREATE TABLE `vmcs_services` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `server` int(11) NOT NULL,
  `description` text,
  `image` varchar(255) NOT NULL,
  `smsConfig` text,
  `paypalCost` int(11) DEFAULT NULL,
  `commands` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Struktura tabeli dla tabeli `vmcs_settings`
--

CREATE TABLE `vmcs_settings` (
  `id` int(11) NOT NULL,
  `pageTitle` varchar(255) NOT NULL,
  `pageDesc` text,
  `pageTags` text,
  `favicon` varchar(255) DEFAULT NULL,
  `pageLogo` varchar(255) DEFAULT NULL,
  `pageBackground` varchar(255) NOT NULL DEFAULT '#ffffff',
  `pageBroadcast` text,
  `voucherPrefix` varchar(255) DEFAULT NULL,
  `voucherLength` int(11) NOT NULL,
  `pageTheme` varchar(255) NOT NULL,
  `sidebarPos` int(11) NOT NULL,
  `lastBuyersPos` int(11) NOT NULL,
  `serviceListLayout` int(11) NOT NULL,
  `smsOperator` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `vmcs_settings`
--

INSERT INTO `vmcs_settings` (`id`, `pageTitle`, `pageDesc`, `pageTags`, `favicon`, `pageLogo`, `pageBackground`, `pageBroadcast`, `voucherPrefix`, `voucherLength`, `pageTheme`, `sidebarPos`, `lastBuyersPos`, `serviceListLayout`, `smsOperator`) VALUES
(1, 'vMCShop.pro', NULL, NULL, NULL, 'https://basic.vmcshop.pro/assets/images/vmcshop.png', 'https://basic.vmcshop.pro/assets/images/background.png', NULL, 'vMCShop_', 32, 'custom', 1, 1, 1, 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `vmcs_users`
--

CREATE TABLE `vmcs_users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `lastIp` varchar(36) DEFAULT NULL,
  `lastLogin` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `vmcs_users`
--

INSERT INTO `vmcs_users` (`id`, `name`, `password`, `lastIp`, `lastLogin`) VALUES
(1, 'Admin', '$2y$10$n00dIWZTbv3riL7WxyDP3eRcGetzGo4ibK3swZ71hcw/J45.RM4vq', '127.0.0.1', '1510146045');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `vmcs_vouchers`
--

CREATE TABLE `vmcs_vouchers` (
  `id` int(11) NOT NULL,
  `service` int(11) NOT NULL,
  `code` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indexes for table `vmcs_logs`
--
ALTER TABLE `vmcs_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vmcs_pages`
--
ALTER TABLE `vmcs_pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vmcs_payments`
--
ALTER TABLE `vmcs_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vmcs_paypalpayments`
--
ALTER TABLE `vmcs_paypalpayments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vmcs_purchases`
--
ALTER TABLE `vmcs_purchases`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vmcs_servers`
--
ALTER TABLE `vmcs_servers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vmcs_services`
--
ALTER TABLE `vmcs_services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vmcs_settings`
--
ALTER TABLE `vmcs_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vmcs_users`
--
ALTER TABLE `vmcs_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vmcs_vouchers`
--
ALTER TABLE `vmcs_vouchers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `vmcs_logs`
--
ALTER TABLE `vmcs_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT dla tabeli `vmcs_pages`
--
ALTER TABLE `vmcs_pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT dla tabeli `vmcs_payments`
--
ALTER TABLE `vmcs_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT dla tabeli `vmcs_paypalpayments`
--
ALTER TABLE `vmcs_paypalpayments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT dla tabeli `vmcs_purchases`
--
ALTER TABLE `vmcs_purchases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT dla tabeli `vmcs_servers`
--
ALTER TABLE `vmcs_servers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT dla tabeli `vmcs_services`
--
ALTER TABLE `vmcs_services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT dla tabeli `vmcs_settings`
--
ALTER TABLE `vmcs_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT dla tabeli `vmcs_users`
--
ALTER TABLE `vmcs_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT dla tabeli `vmcs_vouchers`
--
ALTER TABLE `vmcs_vouchers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
