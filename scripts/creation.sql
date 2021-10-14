CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `company` varchar(32) NOT NULL,
  `hash` varchar(32) NOT NULL,
  `active` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `email` (`email`);

ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;
























CREATE TABLE `work_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company` varchar(32) NOT NULL,
  `given_id` varchar(12) DEFAULT NULL,
  `supervisor` int(11) DEFAULT 0,
  `applicant` int(11) DEFAULT 0,
  `responsable` int(11) DEFAULT 0,
  `priority` int(11) DEFAULT 0,
  `status` int(11) DEFAULT 0,
  `equipment` int(11) DEFAULT NULL,
  `title` varchar(128) DEFAULT NULL,
  `description` varchar(1024) DEFAULT NULL,
  `worker_notes` varchar(1024) DEFAULT NULL,
  `date_created` date NOT NULL DEFAULT curdate(),
  `date_finished` date DEFAULT NULL,
  `date_start` date DEFAULT NULL,
  `date_limit` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


ALTER TABLE `work_orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

ALTER TABLE `work_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;