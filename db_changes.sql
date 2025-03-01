ALTER TABLE `patient_visit` 
ADD COLUMN `counter_fk_id` INT NULL DEFAULT NULL AFTER `updated_at`,
CHANGE COLUMN `token_no` `token_no` VARCHAR(45) NOT NULL ;

CREATE TABLE `background_task` (
  `id` int NOT NULL AUTO_INCREMENT,
  `start_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `end_time` datetime DEFAULT NULL,
  `description` varchar(250) NOT NULL,
  `status` tinyint DEFAULT '2',
  `pid` int DEFAULT NULL,
  `result_data` longtext,
  `created_by` bigint NOT NULL DEFAULT '1',
  `cmd_text` varchar(545) NOT NULL,
  `uid` varchar(550) DEFAULT NULL,
  `schedule_time` datetime DEFAULT CURRENT_TIMESTAMP,
  `ref_id` bigint DEFAULT NULL,
  `type` tinyint DEFAULT '1',
  `comment_text` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uid_UNIQUE` (`uid`)
) ENGINE=InnoDB ;
ALTER TABLE `user_login` 
ADD COLUMN `counter_fk_id` INT NULL DEFAULT NULL;

CREATE TABLE `counter` (
  `id` int NOT NULL AUTO_INCREMENT,
  `counterName` varchar(145) NOT NULL,
  `status` tinyint DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `token_updated_at` datetime DEFAULT NULL,
  `last_token` varchar(45) DEFAULT NULL,
  `token_prefix` varchar(45) DEFAULT NULL,
  `initial_start_from` varchar(45) DEFAULT NULL,
  `token_seperator` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT;

CREATE TABLE `patient_treatment_step` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `patient_treatment_stepName` varchar(245) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `patient_treatment_fk_id` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT;

ALTER TABLE `patient` 
ADD COLUMN `last_visit` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `allow_sms`;

ALTER TABLE `patient_treatment_plan` 
ADD COLUMN `remarks` VARCHAR(250) NULL DEFAULT NULL AFTER `teeth_number`;
ALTER TABLE `settings` 
ADD COLUMN `logo_water_mark` VARCHAR(245) NULL DEFAULT NULL AFTER `website_url`;

CREATE TABLE `patient_category` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `patient_categoryName` VARCHAR(145) NOT NULL,
  `status` TINYINT NULL DEFAULT 1,
  `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  `discount_type` TINYINT NULL DEFAULT 1,
  `discount_value` FLOAT(10,2) NULL DEFAULT 0,
  `max_discount_amount` FLOAT(10,2) NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `patient_categoryName_UNIQUE` (`patient_categoryName` ASC));

ALTER TABLE `patient` 
ADD COLUMN `patient_category_fk_id` INT NULL DEFAULT 1 AFTER `last_visit`;