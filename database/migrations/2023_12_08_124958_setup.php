<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared("
SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_firstname` varchar(255) DEFAULT NULL,
  `user_lastname` varchar(255) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `users` (`user_id`, `user_firstname`, `user_lastname`) VALUES
(1,	'Jan',	'Kowalski'),
(2,	'Adam',	'Nowak');

DROP TABLE IF EXISTS `estates`;
CREATE TABLE `estates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `supervisor_user_id` int(11) DEFAULT NULL,
  `street` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `building_number` varchar(16) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `zip` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `supervisor_user_id` (`supervisor_user_id`),
  CONSTRAINT `estates_ibfk_1` FOREIGN KEY (`supervisor_user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `estates` (`id`, `supervisor_user_id`, `street`, `building_number`, `city`, `zip`) VALUES
(3,	1,	'Jabłonna',	'23',	'Kraków',	'31-060'),
(8,	1,	'Grzybowska',	'12',	'Kraków',	'00-001'),
(34,	2,	'Testowa',	'3',	'Łódź',	'31-060'),
(56,	2,	'Herbaciana',	'43',	'Kraków',	'81-718'),
(57,	1,	'Kwiatowa',	'23',	'Kraków',	'31-223');


DROP TABLE IF EXISTS `users_shifts`;
CREATE TABLE `users_shifts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `substitute_user_id` int(11) NOT NULL,
  `temp_changes` json DEFAULT NULL,
  `date_from` date NOT NULL,
  `date_to` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `substitute_user_id` (`substitute_user_id`),
  CONSTRAINT `users_shifts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `users_shifts_ibfk_2` FOREIGN KEY (`substitute_user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `users_shifts_ibfk_4` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  CONSTRAINT `users_shifts_ibfk_5` FOREIGN KEY (`substitute_user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `users_shifts` (`id`, `user_id`, `substitute_user_id`, `temp_changes`, `date_from`, `date_to`) VALUES
(1,	1,	2,	NULL,	'2022-03-01',	'2022-04-02');
");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
