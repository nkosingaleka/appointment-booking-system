CREATE DATABASE appointment_booking_system;

USE `appointment_booking_system`;

CREATE TABLE `facility` (
  `id` VARCHAR(36),
  `name` VARCHAR(70) NOT NULL,
  `building_name` VARCHAR(35),
  `building_no` VARCHAR(5),
  `street` VARCHAR(70) NOT NULL,
  `city` VARCHAR(60) NOT NULL,
  `county` VARCHAR(30) NOT NULL,
  `postcode` VARCHAR(8) NOT NULL,
  `tel_no` VARCHAR(15) NOT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `role` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `description` VARCHAR(70),
  PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `account` (
  `id` VARCHAR(36),
  `email` VARCHAR(255) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `role_id` INT DEFAULT 3 NOT NULL,
  `verified` BOOLEAN DEFAULT FALSE,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`role_id`) REFERENCES `role` (`id`)
);

CREATE TABLE IF NOT EXISTS `staff` (
  `id` VARCHAR(36),
  `title` VARCHAR(35) NOT NULL,
  `forename` VARCHAR(35) NOT NULL,
  `surname` VARCHAR(35) NOT NULL,
  `sex` CHAR(1) NOT NULL,
  `job_title` VARCHAR(70),
  `facility_id` VARCHAR(36),
  PRIMARY KEY (`id`),
  FOREIGN KEY (`id`) REFERENCES `account` (`id`),
  FOREIGN KEY (`facility_id`) REFERENCES `facility` (`id`)
);

CREATE TABLE IF NOT EXISTS `next_of_kin` (
  `id` VARCHAR(36),
  `relationship` VARCHAR(15) NOT NULL,
  `title` VARCHAR(35) NOT NULL,
  `forename` VARCHAR(35) NOT NULL,
  `surname` VARCHAR(35) NOT NULL,
  `house_name` VARCHAR(35),
  `house_no` VARCHAR(5),
  `street` VARCHAR(70) NOT NULL,
  `city` VARCHAR(60) NOT NULL,
  `county` VARCHAR(30) NOT NULL,
  `postcode` VARCHAR(8) NOT NULL,
  `tel_no` VARCHAR(15),
  `mob_no` VARCHAR(15),
  PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `patient` (
  `id` VARCHAR(36),
  `title` VARCHAR(35) NOT NULL,
  `forename` VARCHAR(35) NOT NULL,
  `surname` VARCHAR(35) NOT NULL,
  `sex` CHAR(1) NOT NULL,
  `date_of_birth` DATE NOT NULL,
  `house_name` VARCHAR(35),
  `house_no` VARCHAR(5),
  `street` VARCHAR(70) NOT NULL,
  `city` VARCHAR(60) NOT NULL,
  `county` VARCHAR(30) NOT NULL,
  `postcode` VARCHAR(8) NOT NULL,
  `tel_no` VARCHAR(15),
  `mob_no` VARCHAR(15),
  `next_of_kin` VARCHAR(36) NOT NULL,
  `NHS_no` CHAR(10) UNIQUE,
  `HC_no` CHAR(10) UNIQUE,
  `contact_by_email` BOOLEAN,
  `contact_by_text` BOOLEAN,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`id`) REFERENCES `account` (`id`),
  FOREIGN KEY (`next_of_kin`) REFERENCES `next_of_kin` (`id`)
);

CREATE TABLE IF NOT EXISTS `request` (
  `id` VARCHAR(36),
  `p_cancellation_reason` VARCHAR(255),
  `r_cancellation_reason` VARCHAR(255),
  `reviewer_id` VARCHAR(36),
  `patient_id` VARCHAR(36),    
  PRIMARY KEY (`id`),
  FOREIGN KEY (`reviewer_id`) REFERENCES `staff` (`id`),
  FOREIGN KEY (`patient_id`) REFERENCES `patient` (`id`)
);

CREATE TABLE IF NOT EXISTS `room` (
  `id` VARCHAR(36),
  `title` VARCHAR(35),
  `notes` TEXT,
  `facility_id` VARCHAR(36),    
  PRIMARY KEY (`id`),
  FOREIGN KEY (`facility_id`) REFERENCES `facility` (`id`)
);
