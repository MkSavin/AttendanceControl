-- phpMyAdmin SQL Dump
-- version 4.4.15.7
-- http://www.phpmyadmin.net
--
-- Language: ru
-- Хост: 127.0.0.1:3306
-- Время создания: Мар 15 2020 г., 20:41
-- Версия сервера: 5.6.31
-- Версия PHP: 7.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `attendancecontrol`
--

-- --------------------------------------------------------

--
-- Структура таблицы `attendance`
--

CREATE TABLE IF NOT EXISTS `attendance` (
  `id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `session_id` int(10) unsigned NOT NULL,
  `created_by` int(10) unsigned DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `attendance`
--

INSERT INTO `attendance` (`id`, `user_id`, `session_id`, `created_by`, `deleted`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 2, 1, NULL, 0, NULL, '2019-12-04 08:00:12', NULL),
(2, 1, 2, NULL, 0, NULL, '2019-12-08 21:19:43', NULL),
(3, 1, 1, NULL, 0, NULL, '2019-12-08 16:51:31', '2019-12-08 16:51:31'),
(5, 1, 4, NULL, 0, NULL, '2019-12-09 01:09:36', '2019-12-09 01:09:36'),
(6, 2, 4, NULL, 0, NULL, '2019-12-09 01:16:09', '2019-12-09 01:16:09'),
(7, 1, 6, NULL, 0, NULL, '2019-12-10 01:36:19', '2019-12-10 01:36:19'),
(8, 2, 8, NULL, 0, NULL, '2019-12-10 10:37:48', '2019-12-10 10:37:48'),
(9, 1, 9, NULL, 0, NULL, '2019-12-11 00:17:43', '2019-12-11 00:17:43'),
(10, 2, 9, NULL, 0, NULL, '2019-12-11 00:19:01', '2019-12-11 00:19:01'),
(11, 2, 10, NULL, 0, NULL, '2019-12-13 02:02:33', '2019-12-13 02:02:33'),
(12, 1, 10, NULL, 0, NULL, '2019-12-13 02:02:53', '2019-12-13 02:02:53'),
(13, 1, 11, NULL, 0, NULL, '2019-12-13 09:39:58', '2019-12-13 09:39:58'),
(14, 2, 11, NULL, 0, NULL, '2019-12-13 09:40:56', '2019-12-13 09:40:56'),
(15, 2, 12, NULL, 0, NULL, '2019-12-13 09:47:01', '2019-12-13 09:47:01');

-- --------------------------------------------------------

--
-- Структура таблицы `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `year` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `groups`
--

INSERT INTO `groups` (`id`, `name`, `year`) VALUES
(5, 'ВТ-1', 17),
(10, 'ВТ-1', 18),
(15, 'ВТ-1', 19),
(3, 'ИБ-1', 17),
(8, 'ИБ-1', 18),
(13, 'ИБ-1', 19),
(9, 'ИСБ-1', 17),
(4, 'ИСБ-1', 18),
(14, 'ИСБ-1', 19),
(2, 'ИСТ-1', 17),
(7, 'ИСТ-1', 18),
(12, 'ИСТ-1', 19),
(1, 'ПРИ-1', 17),
(6, 'ПРИ-1', 18),
(11, 'ПРИ-1', 19);

-- --------------------------------------------------------

--
-- Структура таблицы `migrations`
--

CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2019_09_21_152708_create_groups_table', 1),
(2, '2019_09_21_152710_create_rights_table', 1),
(3, '2019_09_21_152711_create_users_types_table', 1),
(4, '2019_09_21_152712_create_users_table', 1),
(5, '2019_09_21_152713_create_password_resets_table', 1),
(6, '2019_09_21_152714_create_types_rights_table', 1),
(7, '2019_09_21_152715_create_sessions_table', 1),
(8, '2019_09_21_152716_create_attendance_table', 1),
(9, '2019_09_21_152716_create_sessions_groups_table', 1),
(10, '2019_09_21_152720_create_foreigns', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `password_resets`
--

CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `rights`
--

CREATE TABLE IF NOT EXISTS `rights` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `rights`
--

INSERT INTO `rights` (`id`, `name`, `description`, `code`) VALUES
(1, 'Сеанс: использование', NULL, 'session.use'),
(2, 'Сеанс: использование собственного', NULL, 'session.use.own'),
(3, 'Сеанс: создание', NULL, 'session.create'),
(4, 'Сеанс: просмотр', NULL, 'session.view'),
(5, 'Сеанс: просмотр всех', NULL, 'session.view.all'),
(6, 'Сеанс: редактирование', NULL, 'session.edit'),
(7, 'Сеанс: редактирование всех', NULL, 'session.edit.all'),
(8, 'Пользователь: удаление', NULL, 'user.delete'),
(9, 'Пользователь: создание', NULL, 'user.create'),
(10, 'Пользователь: просмотр', NULL, 'user.view'),
(11, 'Пользователь: редактирование', NULL, 'user.edit');

-- --------------------------------------------------------

--
-- Структура таблицы `sessions`
--

CREATE TABLE IF NOT EXISTS `sessions` (
  `id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `creator_id` int(10) unsigned NOT NULL,
  `user_type_id` int(10) unsigned NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `activetime` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `creator_id`, `user_type_id`, `code`, `active_at`, `activetime`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 3, 'tcan9gry29w7', '2019-12-04 08:00:00', 20, '2019-12-04 07:00:00', NULL),
(2, 3, 3, 3, 'Hd4g-bRln-cGky-OXc4', '2019-12-08 21:19:33', 2000, '2019-12-08 21:09:33', NULL),
(3, 4, 4, 2, 'RkQj-AD4o-3dL3-Dl5e', '2019-12-05 21:50:18', 6000, '2019-12-05 21:40:18', NULL),
(4, 3, 3, 3, 'kRWHVEjezkJt', '2019-12-08 21:19:35', 1600, '2019-12-05 21:40:18', NULL),
(5, 1, 1, 2, 'xzbrM41eeR49', '2019-12-09 22:33:10', 1200, '2019-12-10 01:33:10', '2019-12-10 01:33:10'),
(6, 1, 1, 3, '8ZOtfMBaLZ82', '2019-12-09 22:34:38', 1200, '2019-12-10 01:34:38', '2019-12-10 01:34:38'),
(7, 2, 2, 3, 'Zg6qPlNlVbAU', '2019-12-10 10:34:00', 600, '2019-12-10 10:35:34', '2019-12-10 10:35:34'),
(8, 2, 2, 3, 'TETlqJUkNra8', '2019-12-10 07:37:11', 600, '2019-12-10 10:37:11', '2019-12-10 10:37:11'),
(9, 2, 2, 3, 'lNh9ZPJft5Xa', '2019-12-11 00:17:25', 1200, '2019-12-11 00:17:25', '2019-12-11 00:17:25'),
(10, 1, 25, 3, '92U6iprznlyb', '2019-12-13 01:20:30', 4320000, '2019-12-13 01:20:30', '2019-12-13 01:20:30'),
(11, 1, 1, 3, 'eLrAHCDe6MFU', '2019-12-13 09:39:50', 1200, '2019-12-13 09:39:50', '2019-12-13 09:39:50'),
(12, 1, 1, 3, '7y619TcwCm4r', '2019-12-13 09:46:42', 1200, '2019-12-13 09:46:42', '2019-12-13 09:46:42'),
(13, 4, 25, 2, 'h9BEfZpLie4x', '2019-12-16 19:46:28', 1200, '2019-12-16 19:46:28', '2019-12-16 19:46:28'),
(14, 4, 25, 3, 'GiZbb89VXwwA', '2019-12-16 20:30:06', 72000, '2019-12-16 20:30:06', '2019-12-16 20:30:06'),
(15, 4, 4, 2, 'WLctC0HEsOe3', '2019-12-16 21:48:55', 20, '2019-12-16 21:48:55', '2019-12-16 21:48:55');

-- --------------------------------------------------------

--
-- Структура таблицы `sessions_groups`
--

CREATE TABLE IF NOT EXISTS `sessions_groups` (
  `id` int(10) unsigned NOT NULL,
  `session_id` int(10) unsigned NOT NULL,
  `group_id` int(10) unsigned NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `sessions_groups`
--

INSERT INTO `sessions_groups` (`id`, `session_id`, `group_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 4, 1),
(4, 6, 1),
(5, 7, 1),
(6, 7, 2),
(7, 8, 1),
(8, 8, 2),
(9, 9, 1),
(10, 9, 2),
(11, 10, 1),
(12, 11, 1),
(13, 11, 2),
(14, 12, 1),
(15, 14, 1),
(16, 14, 2),
(17, 14, 4);

-- --------------------------------------------------------

--
-- Структура таблицы `types_rights`
--

CREATE TABLE IF NOT EXISTS `types_rights` (
  `id` int(10) unsigned NOT NULL,
  `user_type_id` int(10) unsigned NOT NULL,
  `right_id` int(10) unsigned NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `types_rights`
--

INSERT INTO `types_rights` (`id`, `user_type_id`, `right_id`) VALUES
(1, 1, 3),
(2, 1, 4),
(3, 1, 5),
(4, 1, 6),
(5, 1, 7),
(6, 1, 8),
(7, 1, 9),
(8, 1, 10),
(9, 1, 10),
(10, 1, 11),
(11, 2, 1),
(12, 2, 3),
(13, 2, 4),
(14, 2, 6),
(15, 2, 10),
(16, 3, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_type_id` int(10) unsigned NOT NULL,
  `group_id` int(10) unsigned DEFAULT NULL,
  `api_token` varchar(80) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `user_type_id`, `group_id`, `api_token`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Савин Максим Константинович', 'user1@elerance.com', '$2y$10$hepVl2GkXag1EhEbsJDzH.eX0..uNZfN4RJ6RvKEPnJ8HwGnJupwS', 3, 1, 'NBIpgO0ZZROwriCoLg2bZ4qmWEkMiXxopZOZ2perUNbvNWOmVQJqVtje8QCI', 'QcdC5N4I5aQrRlzZfaTjjJJzC6vHjEhHmfAy4QQLAhoA8tZQVvNKJSQLzRoG', '2019-10-04 06:00:11', '2019-10-04 06:00:11'),
(2, 'Куппе Рация Олегович', 'user2@elerance.com', '$2y$10$hepVl2GkXag1EhEbsJDzH.eX0..uNZfN4RJ6RvKEPnJ8HwGnJupwS', 3, 1, 'NBIpgO0ZZROwriCoLg2bZzr2j9CdY1tKLIRmgr0HhamNj7fvnisL5OCTYTf7', '4TUfT7TkVw4Wb5sydCN4FOpAxhlpqkZOk4rTvZ8Yr1Q49GgxiFQ8Kn3pFVkV', '2019-10-04 06:00:11', '2019-10-04 06:00:11'),
(3, 'Алексеев Реван Иванович', 'user3@elerance.com', '$2y$10$hepVl2GkXag1EhEbsJDzH.eX0..uNZfN4RJ6RvKEPnJ8HwGnJupwS', 2, NULL, 'NBIpgO0ZZROwriCoLg2bZ9MLFzQNhOWFE5HsPBIZP4Avw5mRYjuUYVfVJ05a', '4thDYWXqxKKreYgksyDXS9TgylVCViqZcugmrN1aaUUwrCUn2mczx8ttiYh7', NULL, NULL),
(4, 'Антонов Антон Хафизович', 'user4@elerance.com', '$2y$10$hepVl2GkXag1EhEbsJDzH.eX0..uNZfN4RJ6RvKEPnJ8HwGnJupwS', 1, NULL, 'NBIpgO0ZZROwriCoLg2bZyeuau7Tuhl5SWAmEUIbjgA8HEyaSBHJJCefaTnA', NULL, NULL, NULL),
(5, 'Жаравина Алёна Сергеевна', 'user5@elerance.com', '$2y$10$hepVl2GkXag1EhEbsJDzH.eX0..uNZfN4RJ6RvKEPnJ8HwGnJupwS', 3, 2, NULL, NULL, NULL, NULL),
(6, 'Шумейко Дарья Сергеевна', 'user6@elerance.com', '$2y$10$hepVl2GkXag1EhEbsJDzH.eX0..uNZfN4RJ6RvKEPnJ8HwGnJupwS', 3, 2, NULL, NULL, NULL, NULL),
(7, 'Кузин Денис Викторович', 'user7@elerance.com', '$2y$10$hepVl2GkXag1EhEbsJDzH.eX0..uNZfN4RJ6RvKEPnJ8HwGnJupwS', 3, 3, NULL, NULL, NULL, NULL),
(8, 'Бурмистров Даниил Алексеевич', 'user8@elerance.com', '$2y$10$hepVl2GkXag1EhEbsJDzH.eX0..uNZfN4RJ6RvKEPnJ8HwGnJupwS', 3, 4, NULL, NULL, NULL, NULL),
(9, 'Волченков Даниил Дмитриевич', 'user9@elerance.com', '$2y$10$hepVl2GkXag1EhEbsJDzH.eX0..uNZfN4RJ6RvKEPnJ8HwGnJupwS', 3, 5, NULL, NULL, NULL, NULL),
(10, 'Вершинин Виталий Васильевич', 'user10@elerance.com', '$2y$10$hepVl2GkXag1EhEbsJDzH.eX0..uNZfN4RJ6RvKEPnJ8HwGnJupwS', 2, NULL, NULL, NULL, NULL, NULL),
(11, 'Жигалов Илия Евгеньевич', 'user11@elerance.com', '$2y$10$hepVl2GkXag1EhEbsJDzH.eX0..uNZfN4RJ6RvKEPnJ8HwGnJupwS', 2, NULL, NULL, NULL, NULL, NULL),
(12, 'Озерова Марина Игоревна', 'user12@elerance.com', '$2y$10$hepVl2GkXag1EhEbsJDzH.eX0..uNZfN4RJ6RvKEPnJ8HwGnJupwS', 2, NULL, NULL, NULL, NULL, NULL),
(13, 'Кириллова Светлана Юрьевна', 'user13@elerance.com', '$2y$10$hepVl2GkXag1EhEbsJDzH.eX0..uNZfN4RJ6RvKEPnJ8HwGnJupwS', 2, NULL, NULL, NULL, NULL, NULL),
(14, 'Тимофеев Алексей Андреевич', 'user14@jelerance.com', '$2y$10$hepVl2GkXag1EhEbsJDzH.eX0..uNZfN4RJ6RvKEPnJ8HwGnJupwS', 2, NULL, NULL, NULL, NULL, NULL),
(15, 'Шамышева Ольга Николаевна', 'user15@elerance.com', '$2y$10$hepVl2GkXag1EhEbsJDzH.eX0..uNZfN4RJ6RvKEPnJ8HwGnJupwS', 2, NULL, NULL, NULL, NULL, NULL),
(16, 'Монахова Галина Евгеньевна', 'user16@elerance.com', '$2y$10$hepVl2GkXag1EhEbsJDzH.eX0..uNZfN4RJ6RvKEPnJ8HwGnJupwS', 2, NULL, NULL, NULL, NULL, NULL),
(17, 'Бородина Екатерина Константиновна', 'user17@elerance.com', '$2y$10$hepVl2GkXag1EhEbsJDzH.eX0..uNZfN4RJ6RvKEPnJ8HwGnJupwS', 2, NULL, NULL, NULL, NULL, NULL),
(18, 'Проскурина Галина Владимировна', 'user18@elerance.com', '$2y$10$hepVl2GkXag1EhEbsJDzH.eX0..uNZfN4RJ6RvKEPnJ8HwGnJupwS', 2, NULL, NULL, NULL, NULL, NULL),
(19, 'Койкова Татьяна Владимировна', 'user19@elerance.com', '$2y$10$hepVl2GkXag1EhEbsJDzH.eX0..uNZfN4RJ6RvKEPnJ8HwGnJupwS', 2, NULL, NULL, NULL, NULL, NULL),
(20, 'Тарасевич Ольга Дмитриевна', 'user20@elerance.com', '$2y$10$hepVl2GkXag1EhEbsJDzH.eX0..uNZfN4RJ6RvKEPnJ8HwGnJupwS', 2, NULL, NULL, NULL, NULL, NULL),
(21, 'Соловьёва Валерия Владимировна', 'user21@elerance.com', '$2y$10$hepVl2GkXag1EhEbsJDzH.eX0..uNZfN4RJ6RvKEPnJ8HwGnJupwS', 2, NULL, NULL, NULL, NULL, NULL),
(22, 'Дубровин Николай Иванович', 'user22@elerance.com', '$2y$10$hepVl2GkXag1EhEbsJDzH.eX0..uNZfN4RJ6RvKEPnJ8HwGnJupwS', 2, NULL, NULL, NULL, NULL, NULL),
(23, 'Макаров Руслан Ильич', 'user23@elerance.com', '$2y$10$hepVl2GkXag1EhEbsJDzH.eX0..uNZfN4RJ6RvKEPnJ8HwGnJupwS', 2, NULL, NULL, NULL, NULL, NULL),
(24, 'Дмитриев Михаил Александрович', 'user24@elerance.com', '$2y$10$hepVl2GkXag1EhEbsJDzH.eX0..uNZfN4RJ6RvKEPnJ8HwGnJupwS', 3, NULL, NULL, NULL, NULL, NULL),
(25, 'Расписание', 'raspisaniye@elerance.com', 'raspisaniye', 4, NULL, 'NBIpgO0ZZROwriCoLg2bZ4qmWEkMiXxopZOZ2perUNbvNWOmVQJqVtje8QCI', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `users_types`
--

CREATE TABLE IF NOT EXISTS `users_types` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bot` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users_types`
--

INSERT INTO `users_types` (`id`, `name`, `bot`) VALUES
(1, 'Спец. по кадрам', 0),
(2, 'Преподаватель', 0),
(3, 'Студент', 0),
(4, 'Расписание', 1);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attendance_user_id_foreign` (`user_id`),
  ADD KEY `attendance_created_by_foreign` (`created_by`),
  ADD KEY `attendance_session_id_foreign` (`session_id`);

--
-- Индексы таблицы `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `groups_name_year_unique` (`name`,`year`);

--
-- Индексы таблицы `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Индексы таблицы `rights`
--
ALTER TABLE `rights`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rights_code_index` (`code`);

--
-- Индексы таблицы `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_code_index` (`code`),
  ADD KEY `sessions_user_id_foreign` (`user_id`),
  ADD KEY `sessions_creator_id_foreign` (`creator_id`),
  ADD KEY `sessions_user_type_id_foreign` (`user_type_id`);

--
-- Индексы таблицы `sessions_groups`
--
ALTER TABLE `sessions_groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_groups_session_id_foreign` (`session_id`),
  ADD KEY `sessions_groups_group_id_foreign` (`group_id`);

--
-- Индексы таблицы `types_rights`
--
ALTER TABLE `types_rights`
  ADD PRIMARY KEY (`id`),
  ADD KEY `types_rights_user_type_id_foreign` (`user_type_id`),
  ADD KEY `types_rights_right_id_foreign` (`right_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_api_token_unique` (`api_token`),
  ADD KEY `users_user_type_id_foreign` (`user_type_id`),
  ADD KEY `users_group_id_foreign` (`group_id`);

--
-- Индексы таблицы `users_types`
--
ALTER TABLE `users_types`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT для таблицы `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT для таблицы `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT для таблицы `rights`
--
ALTER TABLE `rights`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT для таблицы `sessions`
--
ALTER TABLE `sessions`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT для таблицы `sessions_groups`
--
ALTER TABLE `sessions_groups`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT для таблицы `types_rights`
--
ALTER TABLE `types_rights`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT для таблицы `users_types`
--
ALTER TABLE `users_types`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE NO ACTION,
  ADD CONSTRAINT `attendance_session_id_foreign` FOREIGN KEY (`session_id`) REFERENCES `sessions` (`id`) ON DELETE NO ACTION,
  ADD CONSTRAINT `attendance_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `sessions`
--
ALTER TABLE `sessions`
  ADD CONSTRAINT `sessions_creator_id_foreign` FOREIGN KEY (`creator_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sessions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sessions_user_type_id_foreign` FOREIGN KEY (`user_type_id`) REFERENCES `users_types` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `sessions_groups`
--
ALTER TABLE `sessions_groups`
  ADD CONSTRAINT `sessions_groups_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sessions_groups_session_id_foreign` FOREIGN KEY (`session_id`) REFERENCES `sessions` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `types_rights`
--
ALTER TABLE `types_rights`
  ADD CONSTRAINT `types_rights_right_id_foreign` FOREIGN KEY (`right_id`) REFERENCES `rights` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `types_rights_user_type_id_foreign` FOREIGN KEY (`user_type_id`) REFERENCES `users_types` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `users_user_type_id_foreign` FOREIGN KEY (`user_type_id`) REFERENCES `users_types` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
