-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Фев 12 2024 г., 11:35
-- Версия сервера: 10.4.28-MariaDB
-- Версия PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `ls6eloquent`
--

-- --------------------------------------------------------

--
-- Структура таблицы `messages`
--

CREATE TABLE `messages` (
  `id` int(10) UNSIGNED NOT NULL,
  `author_id` int(10) UNSIGNED NOT NULL,
  `text` text NOT NULL,
  `image` text NOT NULL,
  `image_filename` varchar(1000) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Дамп данных таблицы `messages`
--

INSERT INTO `messages` (`id`, `author_id`, `text`, `image`, `image_filename`, `created_at`, `updated_at`) VALUES
(1, 1, 'Первый пост Бориса', '/images/company-employees-sharing-thoughts-and-ideas_74855-5469.jpg', 'company-employees-sharing-thoughts-and-ideas_74855-5469.jpg', '2024-02-12 02:39:41', NULL),
(2, 1, 'Второй пост Бориса', '', '', '2024-02-12 02:39:50', NULL),
(3, 2, 'Первый пост Андрея', '', '', '2024-02-12 02:40:23', NULL),
(4, 2, 'Второй пост Андрея', '/images/depositphotos_46633779-stock-illustration-set-of-funny-office-characters.jpg', 'depositphotos_46633779-stock-illustration-set-of-funny-office-characters.jpg', '2024-02-12 02:40:41', NULL),
(5, 2, 'Третий пост Андрея', '', '', '2024-02-12 04:07:56', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `isadmin` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `password`, `email`, `isadmin`, `created_at`, `updated_at`) VALUES
(2, 'andrey', 'b63420ddabc24a7afb288ccd239cd73a5ccfad12', 'andrey@mail.ru', 0, NULL, NULL),
(3, 'leonid', 'd4dbf6563d464af3cb4cda1be14d015be7c5a746', 'leonid@mail.ru', 0, '2024-02-12 06:17:46', NULL),
(5, 'kostya', '3e81fea2b91c088ec129da880413fd5529722dee', 'kostya@mail.ru', 0, NULL, NULL),
(6, 'kostya2', '0b68811f6c69bd4acef743eda1acafc3fe36169c', 'kostya2@mail.ru', 0, '2024-02-12 06:26:28', NULL);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
