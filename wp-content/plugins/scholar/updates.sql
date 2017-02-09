-- Старо
ALTER TABLE `sc1_sc1_tests` ADD `name` VARCHAR( 1024 ) NOT NULL AFTER `uid`;

--Нови ъпдейти
CREATE TABLE IF NOT EXISTS `sc1_sc1_areas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `area` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;

ALTER TABLE `sc1_sc1_questions` ADD `area_id` INT NOT NULL;