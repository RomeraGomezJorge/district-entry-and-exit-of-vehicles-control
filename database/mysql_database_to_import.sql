-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 21-01-2021 a las 01:01:00
-- Versión del servidor: 5.7.24
-- Versión de PHP: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `new_police`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `district`
--

CREATE TABLE `district` (
  `id` char(36) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `createAt` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `district_entry_and_exit_of_vehicles_control`
--

CREATE TABLE `district_entry_and_exit_of_vehicles_control` (
  `id` char(36) NOT NULL,
  `name_of_the_driver.` varchar(100) NOT NULL,
  `surname_of_the_driver` varchar(100) NOT NULL,
  `identity_card` int(11) NOT NULL,
  `license_plate` int(100) NOT NULL,
  `vehicle_body_type_id` char(36) NOT NULL,
  `vehicle_maker_name_id` char(36) NOT NULL,
  `model_of_vehicle_id` char(36) NOT NULL,
  `vehicle_color_id` char(36) NOT NULL,
  `trip_origin_id` char(36) NOT NULL,
  `trip_destination_id` char(36) NOT NULL,
  `reason_for_trip` varchar(255) NOT NULL,
  `traffic_police_booth_id` char(36) NOT NULL,
  `createAt` datetime NOT NULL,
  `updateAt` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `model_of_vehicle`
--

CREATE TABLE `model_of_vehicle` (
  `id` char(36) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `vehicle_make_name_id` char(36) NOT NULL,
  `createAt` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `role`
--

CREATE TABLE `role` (
  `id` char(36) CHARACTER SET utf8mb4 NOT NULL,
  `description` varchar(100) CHARACTER SET utf8mb4 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `role`
--

INSERT INTO `role` (`id`, `description`) VALUES
('ROLE_ADMIN', 'nulla');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `traffic_police_booth`
--

CREATE TABLE `traffic_police_booth` (
  `id` char(36) NOT NULL,
  `description` varchar(100) NOT NULL,
  `createAt` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `traffic_police_booth`
--

INSERT INTO `traffic_police_booth` (`id`, `description`, `createAt`) VALUES
('067abbbb-0222-484b-b24a-93180ba9b1e4', 'fdsgfdsgdfg', '2021-01-19 23:54:43'),
('086eb020-a6f3-46e5-93a2-413279e83c04', 'sdfdsafdsafd', '2021-01-20 00:47:09'),
('0a6ce05f-e4ad-41bc-9547-8f25b061d93d', 'saepe', '2021-01-17 19:20:45'),
('0d7cb9d4-b18f-4adc-b285-a4f261fbfb2f', 'test ashsjs', '2021-01-20 01:45:26'),
('107b5595-950c-4c8b-9d6c-3ffef89f968d', 'dsfdsdsfds', '2021-01-20 01:43:12'),
('1402e72d-2d15-4bac-89a9-ccb6d7e92fdb', 'dsfdsfddsfd', '2021-01-20 03:49:42'),
('14bc7b34-1d75-4805-b907-8c9f05acd98c', 'dsfdsfdsfdsfdsa', '2021-01-20 02:59:01'),
('1961c527-a5b4-4adf-a04e-877be2b4716c', 'dsafds', '2021-01-20 01:19:49'),
('1be1f8aa-4a4e-4fa6-9c8c-81e6bcf133a9', 'Hdjskdkwisjs', '2021-01-20 02:35:41'),
('2446d25e-7de8-4305-9c35-10a81141d62c', 'dsfdsaf', '2021-01-20 02:46:27'),
('24f4c4a9-f5d6-42f8-a8cd-2ccbe4332b18', '-.-', '2021-01-20 02:48:20'),
('25ace701-7694-47b4-ac00-86c06bde2834', 'sdfaadsfadsf', '2021-01-20 00:51:43'),
('2815e1c0-f433-405a-adcf-76b48486b16a', 'fds fdf df d f', '2021-01-20 02:42:19'),
('2e01ef94-be83-42ac-a2ec-218d203e7926', 'dfdsfds434343', '2021-01-20 02:57:20'),
('2f5632f2-a798-4465-9df9-af1495c03d49', 'dsfdsfdsafdsfdasfdasf', '2021-01-20 02:31:47'),
('2ff9d606-f421-4959-ab44-a6eb4f191683', 'dfdfdsf', '2021-01-20 02:59:39'),
('3070e077-903c-4e74-97d2-081bb97fa763', 'dsfdsfds', '2021-01-20 01:40:15'),
('37af658b-38d1-4cee-8e7c-568c5fed6111', 'test as', '2021-01-20 00:54:28'),
('3a3b3cb2-afd7-4a2f-a81a-e07aab425863', 'ada cagar!', '2021-01-20 02:51:36'),
('3cd76405-e5b0-4d61-8e35-29624897af75', 'dsfdsf', '2021-01-19 23:29:09'),
('466cd7c7-5ade-4c66-8890-e2b6bd09ae7a', 'dsafdsafds', '2021-01-20 01:04:08'),
('46fcb20a-74b6-467b-ba23-d4df088f8659', 'dsfadsafasd', '2021-01-20 02:41:48'),
('49c999cc-715b-43bb-b69e-821f7cbda462', 'fdsfdsfds', '2021-01-20 02:33:34'),
('4ba93257-535a-4883-bcef-064c48dc3655', 'dsfdss', '2021-01-20 01:40:36'),
('4c3a65d3-7b05-4dae-b8cd-57734f4da1e0', 'yeah mother fucker!', '2021-01-20 02:35:02'),
('4e120469-4f4f-4cec-94c8-bca8b3f5c58c', 'dsafdsfdsfdsfdsf', '2021-01-20 01:43:26'),
('51745230-73b6-4702-869a-240d3fd110b9', 'gfhgfhg', '2021-01-19 23:37:16'),
('519364e5-186d-4775-a46e-b4a6d723ef2f', 'yeah mother fucker!vb', '2021-01-20 02:45:44'),
('53a52df6-1260-445a-9c5a-9f5581e14b46', 'sdafdsfds', '2021-01-20 01:18:41'),
('54a66b29-b54f-4d30-bd91-7cf1831ef2bb', 'sadfdsafdsafd', '2021-01-20 01:04:41'),
('57281c90-7f5e-455d-b424-e8e6475ec4f2', 'fdsgdfgdf', '2021-01-20 01:23:08'),
('5cb74fb4-f93b-4bf6-81ba-f40e57329e83', 'dsfdsfsdafdsaf', '2021-01-19 23:43:57'),
('65c330bd-9892-4eea-8e74-b154ef236e8a', 'prueba', '2021-01-20 02:59:28'),
('674fd391-4356-44ad-8c02-aed1120b1b50', 'puta m', '2021-01-20 02:52:07'),
('677dcdcc-0564-494d-828d-f44a81aa39a6', 'dsaf dsfdsfds', '2021-01-20 02:41:54'),
('698e0012-e322-46f0-9230-bbd5238289c5', 'dfdsf', '2021-01-19 23:27:46'),
('69d46238-cb10-405f-a734-1343164a6749', 'fddfdfdfd', '2021-01-20 01:24:10'),
('6c91bd67-c681-40f6-a002-8242cf0ff775', 'sadfdsf', '2021-01-19 23:27:14'),
('6d44923b-25d2-443f-b4b9-174b01db7f98', 'Hshshd', '2021-01-20 00:56:11'),
('6dd777c8-7fa2-4ad1-8405-ec188c2b8c8c', 'sadfdasf', '2021-01-20 00:52:24'),
('6e19186c-2d78-495f-a29a-3322d1caf297', 'asdsadsadsa', '2021-01-19 23:28:48'),
('792fc384-4373-4ef1-993d-94d148011c28', 'dsfsdafads', '2021-01-20 01:28:31'),
('7c5bddf9-5f47-4da2-9393-79dffe26bd19', 'dsfdsafdsafdsaf', '2021-01-20 02:45:12'),
('7c80f412-06fc-40e0-abb0-dcba90f41605', 'vaya saber uno', '2021-01-20 01:33:22'),
('7e4fb3a6-b015-43be-8409-47c2ef386555', 'sadfdjjh', '2021-01-20 02:46:13'),
('7eda915b-fd0e-45b1-af74-fd0d3073d969', 'sdafdsfdsfds', '2021-01-20 02:44:50'),
('80a8398c-cf93-4834-a9d5-44c4c764d3ec', 'asdfdfds', '2021-01-20 01:12:42'),
('81161486-f192-448e-abf9-e6db0312ff1b', 'dsfdsdsfdsfd', '2021-01-20 02:24:54'),
('81174a15-f750-4059-9473-519f24976ce5', 'dsfdsfdf dfdf df ', '2021-01-20 02:42:02'),
('8294fdf0-e021-43c0-bb47-dbbff6e85780', 'dsfsdafdasf', '2021-01-20 00:45:22'),
('88288fa7-66aa-48ed-a20c-25f66af0863c', 'pruebaa', '2021-01-20 04:24:25'),
('8c28bc8b-9b4a-4c0f-be26-9a90b05b40e9', 'dsfds', '2021-01-20 00:15:05'),
('8fb3ea9d-9c3c-48ae-9c69-5cd7ecdb24f6', 'sdsadsa', '2021-01-20 02:30:40'),
('907ca01b-f49e-423b-9a45-26f6a409f22b', 'sdfdsf', '2021-01-20 01:34:02'),
('94d221a9-4fbd-42f4-9865-4e2e3d9b9d8b', 'dfsgfdg', '2021-01-19 23:25:59'),
('963d3be5-8afe-4253-82dc-e79e7bbcb0ed', 'dfsdfe43434', '2021-01-20 02:59:14'),
('987d996b-3287-4ade-9331-db479fa2a79e', 'test as dfd', '2021-01-20 04:38:08'),
('a2a10d14-8a56-476b-a775-a43c9f176aa5', 'dsafdasfdsaf', '2021-01-20 00:45:34'),
('a6360258-15dd-4d7f-a3c6-93074c97faa7', 'sdafdsafds', '2021-01-20 01:04:01'),
('a67d1fb6-b5f6-40cf-be42-e37d525f41f4', 'dsfadsafdsafdsaf df dsfd', '2021-01-20 02:31:55'),
('a8c8d9e9-2233-42cf-8e01-1c116145fa93', 'yeah mother fucker!bnbv', '2021-01-20 02:45:58'),
('ab4bfc2d-98eb-4b57-9474-4d10a942ade6', 'sdfdsfd', '2021-01-20 01:38:54'),
('ad00dcfc-eb5c-4ee7-a7de-a9c9b3a99700', '!!!!!!!!!!!!!!!!!!', '2021-01-20 02:47:34'),
('ad378179-c7db-40b0-b3d3-18db163b7402', 'fdsfds', '2021-01-20 01:38:46'),
('ad4f6863-e158-4bdc-b349-5ff81191f313', 'dsafdsafdsf', '2021-01-20 01:07:57'),
('b04e24ad-5cf7-4700-ba09-d88799ccffa9', 'dsdsfdfda', '2021-01-20 00:51:37'),
('b4123727-00d5-4cb8-a86b-5302b8b6ffb9', 'dsfdsfdfsafdas', '2021-01-20 01:23:47'),
('b429df57-552a-48a6-a82c-ffade3a621dd', 'fdsafdshjh', '2021-01-20 03:41:10'),
('b7007561-d374-4eee-a11f-2ba0743429f3', 'sadfd', '2021-01-20 02:35:30'),
('c10968d1-271e-4bfb-84fb-f7a3c9b37ba5', 'adsfdsafdsf', '2021-01-20 00:46:56'),
('c32eb2f0-e870-4ec5-8c80-041a01068734', 'la concha de la lolra', '2021-01-20 02:51:47'),
('c39f964f-14a0-4dd1-8129-e6c4c45fe64a', 'fdsafds', '2021-01-20 02:46:37'),
('c56ccffa-2c18-4fda-af0c-da82e077a8bc', 'dsfdsafds', '2021-01-20 01:25:38'),
('d2f91ed6-f852-4c1e-bc81-87d3e1a878f1', 'dfsgfdgfd', '2021-01-20 00:48:20'),
('d82649a8-44fb-4927-bdd6-1a429f30a1b8', 'dasdsad', '2021-01-20 02:57:06'),
('db6d7eea-c538-423c-a6ab-624fb4d83f48', 'dfdsfdsfdsf', '2021-01-19 23:53:53'),
('dbb1112d-9aaa-4cdb-9743-91af2b6c23aa', 'dsfdssdds', '2021-01-20 01:36:05'),
('dc41fed9-3b43-43d5-ac38-f1c1ac4fc303', 'hgfhgf', '2021-01-20 00:56:22'),
('e1b73400-7824-46a0-8421-1a66ea95c4f9', 'Qñqñqñlwlwso', '2021-01-20 02:35:52'),
('e1e60dd7-b92b-4bdc-87b4-5a1d2ae13104', 'safdsfds', '2021-01-20 00:47:15'),
('e3de7833-ea3a-40dc-b1f8-ef795b2c0140', 'dsfdsfdsf', '2021-01-20 01:02:46'),
('e4beb1a1-15e9-4336-86c8-da5ee588488d', 'dsafadsfds', '2021-01-20 01:08:04'),
('e5ce9469-dfec-4f75-8e7c-bc7ec96c1ac2', 'sdafdsfdsfd', '2021-01-20 02:44:42'),
('eb3ab587-0586-4d9b-bc9d-3509fe7038d5', 'dsfdsfds fdfdsfsadf', '2021-01-20 02:33:46'),
('f13e5cbd-2cd2-48a5-bc8a-a569d937f8c2', 'dsafdsf', '2021-01-19 23:27:03'),
('f51d83e5-e27a-499c-80a7-ea3f66d63cc8', 'dsfdsaf bdjdjd', '2021-01-20 02:35:17'),
('f54bcb2b-f281-4338-928f-3adf3c2715d6', 'dsafdsfdsfds', '2021-01-19 23:55:33'),
('f8edae00-33b6-45c8-9a7e-ed1d13dd5bf4', 'dsfdsfdsdsfdsafd', '2021-01-20 02:31:27'),
('f963868c-67e3-459d-ac66-49b49f99b9ac', 'ggfhfgh', '2021-01-19 05:51:48'),
('fc787481-aa60-4fad-b6d3-41444f021e57', 'dfgfdgfd', '2021-01-20 00:59:51'),
('fd3337e0-94c3-4989-8608-30d226c82495', 'dsfdasf', '2021-01-20 01:23:31'),
('fd9075c3-b651-457e-9f1a-cd7b9ed2f69d', 'fdgfdsg', '2021-01-20 01:18:12');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `id` char(36) CHARACTER SET utf8mb4 NOT NULL,
  `username` varchar(100) CHARACTER SET utf8mb4 NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `role_id` char(36) CHARACTER SET utf8mb4 NOT NULL,
  `createAt` datetime NOT NULL,
  `updateAt` datetime DEFAULT NULL,
  `isActive` tinyint(1) NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 NOT NULL,
  `surname` varchar(100) NOT NULL,
  `trafficPoliceBooth_id` char(36) CHARACTER SET utf8mb4 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password`, `role_id`, `createAt`, `updateAt`, `isActive`, `name`, `surname`, `trafficPoliceBooth_id`) VALUES
('a4859887-fd63-424b-8563-5fccdb0251e5', 'lvilte', 'dolorem@hotmil.xom', '$2y$13$e3TYTIvKHki0V95ryZ/vOu/K586HbKKkCKxfhechN.xW15qV.YJwG', 'ROLE_ADMIN', '2021-01-20 04:35:57', '2021-01-20 04:38:49', 1, 'Miguel angel asis', 'asfsadf', '067abbbb-0222-484b-b24a-93180ba9b1e4'),
('e414e66f-aae0-4c4d-8fb3-1e576ff49296', 'cherza', 'cherza05@hotmail.comm', '$2y$13$zSce8.WFjceZ9Hi8roGJZuAjeoNyWEfvNXyLrKuONeM7B/aMZzBnq', 'ROLE_ADMIN', '2021-01-18 17:55:57', '2021-01-18 18:06:50', 0, 'Jorge', 'Romera', '0a6ce05f-e4ad-41bc-9547-8f25b061d93d');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehicle_body_type`
--

CREATE TABLE `vehicle_body_type` (
  `id` char(36) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `image` varchar(100) NOT NULL,
  `createAt` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehicle_color`
--

CREATE TABLE `vehicle_color` (
  `id` char(36) NOT NULL,
  `name` varchar(100) NOT NULL,
  `code` varchar(100) NOT NULL,
  `createAt` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehicle_maker_name`
--

CREATE TABLE `vehicle_maker_name` (
  `id` char(36) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `logo_image` varchar(100) NOT NULL,
  `createAt` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `district`
--
ALTER TABLE `district`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `district_entry_and_exit_of_vehicles_control`
--
ALTER TABLE `district_entry_and_exit_of_vehicles_control`
  ADD PRIMARY KEY (`id`),
  ADD KEY `trip_origin` (`trip_origin_id`),
  ADD KEY `vehicle_body_type` (`vehicle_body_type_id`) USING BTREE,
  ADD KEY `trip_destination` (`trip_destination_id`),
  ADD KEY `vehicle_color` (`vehicle_color_id`),
  ADD KEY `vehicle_maker_name` (`vehicle_maker_name_id`),
  ADD KEY `model_of_vehicle` (`model_of_vehicle_id`),
  ADD KEY `traffic_police_booth` (`traffic_police_booth_id`) USING BTREE;

--
-- Indices de la tabla `model_of_vehicle`
--
ALTER TABLE `model_of_vehicle`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vehicle_make_name` (`vehicle_make_name_id`);

--
-- Indices de la tabla `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `description` (`description`);

--
-- Indices de la tabla `traffic_police_booth`
--
ALTER TABLE `traffic_police_booth`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`) USING BTREE,
  ADD UNIQUE KEY `userName` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `role_id` (`id`),
  ADD KEY `role_id_2` (`role_id`),
  ADD KEY `id_trafficPoliceBooth` (`trafficPoliceBooth_id`);

--
-- Indices de la tabla `vehicle_body_type`
--
ALTER TABLE `vehicle_body_type`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `vehicle_color`
--
ALTER TABLE `vehicle_color`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `vehicle_maker_name`
--
ALTER TABLE `vehicle_maker_name`
  ADD PRIMARY KEY (`id`);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `district_entry_and_exit_of_vehicles_control`
--
ALTER TABLE `district_entry_and_exit_of_vehicles_control`
  ADD CONSTRAINT `district_entry_and_exit_of_vehicles_control_ibfk_1` FOREIGN KEY (`trip_origin_id`) REFERENCES `district` (`id`),
  ADD CONSTRAINT `district_entry_and_exit_of_vehicles_control_ibfk_2` FOREIGN KEY (`vehicle_body_type_id`) REFERENCES `vehicle_body_type` (`id`),
  ADD CONSTRAINT `district_entry_and_exit_of_vehicles_control_ibfk_3` FOREIGN KEY (`trip_destination_id`) REFERENCES `district` (`id`),
  ADD CONSTRAINT `district_entry_and_exit_of_vehicles_control_ibfk_4` FOREIGN KEY (`vehicle_color_id`) REFERENCES `vehicle_color` (`id`),
  ADD CONSTRAINT `district_entry_and_exit_of_vehicles_control_ibfk_5` FOREIGN KEY (`vehicle_maker_name_id`) REFERENCES `vehicle_maker_name` (`id`),
  ADD CONSTRAINT `district_entry_and_exit_of_vehicles_control_ibfk_6` FOREIGN KEY (`model_of_vehicle_id`) REFERENCES `model_of_vehicle` (`id`),
  ADD CONSTRAINT `district_entry_and_exit_of_vehicles_control_ibfk_7` FOREIGN KEY (`traffic_police_booth_id`) REFERENCES `traffic_police_booth` (`id`);

--
-- Filtros para la tabla `model_of_vehicle`
--
ALTER TABLE `model_of_vehicle`
  ADD CONSTRAINT `model_of_vehicle_ibfk_1` FOREIGN KEY (`vehicle_make_name_id`) REFERENCES `vehicle_maker_name` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`),
  ADD CONSTRAINT `user_ibfk_2` FOREIGN KEY (`trafficPoliceBooth_id`) REFERENCES `traffic_police_booth` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
