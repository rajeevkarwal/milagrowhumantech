CREATE TABLE IF NOT EXISTS `PREFIX_pet_tab` (
`id_tab` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`position` INT(10) NOT NULL,
`type` varchar(255) NOT NULL,
`active` INT(10) NOT NULL
)
CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `PREFIX_pet_tab_lang` (
`id_tab` INT(10) NOT NULL,
`id_lang` INT(10) NOT NULL,		
`name` VARCHAR(100) NOT NULL,
UNIQUE KEY `pet_tab_lang_index` (`id_tab`,`id_lang`)
)
CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `PREFIX_pet_tab_content` (
`id_tab_content` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`id_tab` INT(10) NOT NULL ,
`id_product` INT(10) NOT NULL,
`id_category` INT(10) NOT NULL
)
CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `PREFIX_pet_tab_content_lang` (
`id_tab_content` INT(10) NOT NULL,
`id_lang` INT(10) NOT NULL,		
`content` TEXT NOT NULL,
UNIQUE KEY `pet_tab_lang_index` (`id_tab_content`,`id_lang`)
)
CHARSET=utf8;