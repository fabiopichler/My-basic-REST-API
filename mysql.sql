
CREATE TABLE `users` (
  `id` int UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `username` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL UNIQUE KEY,
  `email` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL UNIQUE KEY,
  `password` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fullName` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bio` varchar(180) COLLATE utf8mb4_unicode_ci,
  `locality` varchar(30) COLLATE utf8mb4_unicode_ci,
  `date_birth` datetime,
  `website` varchar(80) COLLATE utf8mb4_unicode_ci,
  `date_reg` datetime DEFAULT current_timestamp(),
  `avatar` varchar(100) COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=1;

CREATE TABLE `posts` (
  `id` int UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `user_id` int UNSIGNED NOT NULL,
  `type` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT 'post',
  `title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL UNIQUE KEY,
  `date_posted` datetime DEFAULT current_timestamp(),
  `date_modified` datetime DEFAULT current_timestamp(),
  `content` text COLLATE utf8mb4_unicode_ci,
  CONSTRAINT `fk_tweets_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=1;
