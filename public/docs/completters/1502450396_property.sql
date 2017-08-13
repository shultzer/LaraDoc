-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Май 04 2017 г., 13:35
-- Версия сервера: 5.7.16-log
-- Версия PHP: 7.1.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `property`
--

-- --------------------------------------------------------

--
-- Структура таблицы `Letters`
--

CREATE TABLE `Letters` (
  `id` int(255) NOT NULL,
  `letternum` varchar(255) NOT NULL,
  `letterdate` varchar(255) NOT NULL,
  `letterpath` varchar(255) NOT NULL,
  `company` varchar(255) NOT NULL,
  `property` varchar(255) NOT NULL,
  `reason` int(3) DEFAULT NULL,
  `time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `Letters`
--

INSERT INTO `Letters` (`id`, `letternum`, `letterdate`, `letterpath`, `company`, `property`, `reason`, `time`) VALUES
(29, '1', '20.02.2017', 'doc/16042017/22-02-38.PDF', 'brestenergo', 'vl110', 0, '2017-04-16 19:34:01'),
(30, '2', '12.03.2017', 'doc/16042017/ГПО линии ВЛ.doc', 'vitebskenergo', 'vl35', 0, '2017-04-16 19:34:26'),
(31, '3', '20.02.2017', 'doc/16042017/Письмо РУПАМ по регистрации.doc', 'grodnoenergo', 'vl10', 0, '2017-04-16 19:44:54'),
(32, '3', '20.02.2017', 'doc/16042017/Письмо РУПАМ по регистрации.doc', 'grodnoenergo', 'vl10', 0, '2017-04-16 20:21:02'),
(33, '4', '12.03.2017', 'doc/16042017/Таблица РУПАМ.xlsx', 'mogilevenergo', 'vl6', 0, '2017-04-16 20:21:33');

-- --------------------------------------------------------

--
-- Структура таблицы `Orders`
--

CREATE TABLE `Orders` (
  `letternum` varchar(255) NOT NULL,
  `ordersdate` varchar(255) NOT NULL,
  `ordersnum` varchar(255) NOT NULL,
  `orderpath` varchar(255) NOT NULL,
  `company` varchar(255) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `Orders`
--

INSERT INTO `Orders` (`letternum`, `ordersdate`, `ordersnum`, `orderpath`, `company`, `date`) VALUES
('1', '2017-04-17', '12', 'orders/17042017/Докладная  по залогу.docx', 'beltei', '2017-04-17 19:58:17');

-- --------------------------------------------------------

--
-- Структура таблицы `Reports`
--

CREATE TABLE `Reports` (
  `ordersnum` varchar(255) NOT NULL,
  `reportsnum` varchar(255) NOT NULL,
  `reportsdate` varchar(255) NOT NULL,
  `company` varchar(255) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `reportpath` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `Uniqueorders`
--

CREATE TABLE `Uniqueorders` (
  `ordersnum` varchar(255) NOT NULL,
  `ordersdate` varchar(255) NOT NULL,
  `company` varchar(255) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id` int(255) NOT NULL,
  `orderpath` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `Uniqueorders`
--

INSERT INTO `Uniqueorders` (`ordersnum`, `ordersdate`, `company`, `date`, `id`, `orderpath`) VALUES
('12', '2017-04-17', 'beltei', '2017-04-17 19:58:18', 1, 'orders/17042017/Докладная  по залогу.docx');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `Letters`
--
ALTER TABLE `Letters`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `Orders`
--
ALTER TABLE `Orders`
  ADD PRIMARY KEY (`letternum`);

--
-- Индексы таблицы `Reports`
--
ALTER TABLE `Reports`
  ADD PRIMARY KEY (`ordersnum`);

--
-- Индексы таблицы `Uniqueorders`
--
ALTER TABLE `Uniqueorders`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `Letters`
--
ALTER TABLE `Letters`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT для таблицы `Uniqueorders`
--
ALTER TABLE `Uniqueorders`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
