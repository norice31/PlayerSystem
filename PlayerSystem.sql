-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Хост: localhost:3306
-- Время создания: Мар 24 2024 г., 22:37
-- Версия сервера: 11.1.2-MariaDB-1:11.1.2+maria~ubu2004
-- Версия PHP: 8.1.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `s1_sellsite`
--

-- --------------------------------------------------------

--
-- Структура таблицы `fe_active`
--

CREATE TABLE `fe_active` (
  `id` int(255) NOT NULL,
  `steam` varchar(32) NOT NULL,
  `name` varchar(255) NOT NULL,
  `active` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `fe_bans`
--

CREATE TABLE `fe_bans` (
  `id` int(255) NOT NULL,
  `admin_steamid` varchar(32) NOT NULL,
  `steamid` varchar(32) NOT NULL,
  `name` varchar(64) NOT NULL,
  `admin_name` varchar(64) NOT NULL,
  `created` int(11) NOT NULL,
  `duration` int(11) NOT NULL,
  `end` int(11) NOT NULL,
  `reason` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `fe_logs`
--

CREATE TABLE `fe_logs` (
  `id` int(255) NOT NULL,
  `steam1` varchar(255) NOT NULL,
  `name1` varchar(255) NOT NULL,
  `text` varchar(255) NOT NULL,
  `steam2` varchar(255) NOT NULL,
  `name2` varchar(255) NOT NULL,
  `server_id` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `fe_players`
--

CREATE TABLE `fe_players` (
  `steam` varchar(22) NOT NULL,
  `name` varchar(32) CHARACTER SET utf16 COLLATE utf16_general_ci DEFAULT NULL,
  `server_id` int(11) NOT NULL DEFAULT 0,
  `userid` int(11) NOT NULL,
  `entry_tile` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `fe_settings`
--

CREATE TABLE `fe_settings` (
  `admin` int(255) NOT NULL DEFAULT 1,
  `standart` int(255) NOT NULL DEFAULT 0,
  `ikstype` int(255) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `fe_settings`
--

INSERT INTO `fe_settings` (`admin`, `standart`, `ikstype`) VALUES
(1, 0, 1);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `fe_active`
--
ALTER TABLE `fe_active`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `fe_bans`
--
ALTER TABLE `fe_bans`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `fe_logs`
--
ALTER TABLE `fe_logs`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `fe_players`
--
ALTER TABLE `fe_players`
  ADD PRIMARY KEY (`steam`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `fe_active`
--
ALTER TABLE `fe_active`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `fe_bans`
--
ALTER TABLE `fe_bans`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `fe_logs`
--
ALTER TABLE `fe_logs`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
