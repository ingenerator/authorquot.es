/*
 * Quick and nasty database schema migrations
 */

CREATE DATABASE IF NOT EXISTS `authorquotes`;
USE `authorquotes`;
CREATE TABLE IF NOT EXISTS `migration` (
  `version` INT NOT NULL DEFAULT 1
  );

DELIMITER $$

DROP PROCEDURE IF EXISTS `updateDBSchema`;

CREATE PROCEDURE `updateDBSchema` ()

 BEGIN

	SELECT MAX(version) INTO @CurrentDBVer FROM `migration`;


	IF @CurrentDBVer IS NULL THEN
	  BEGIN
		CREATE TABLE `recordings` (
			`id`                INT NOT NULL,
			`url`                VARCHAR(255) NOT NULL,
			`thumb_url`            VARCHAR(255) NOT NULL,
			`title`                VARCHAR(255) NOT NULL,
			`description_full`    TEXT NOT NULL,
			PRIMARY KEY (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;

		CREATE TABLE `quotes` (
			`id`                 INT(10) UNSIGNED AUTO_INCREMENT,
			`description`        VARCHAR(255),
			`speakers`            VARCHAR(255),
			`start`                INT UNSIGNED,
			`end`                INT UNSIGNED,
			`provocative`        INT UNSIGNED,
			`inspiring`            INT UNSIGNED,
			`meaningful`        INT UNSIGNED,
			`amusing`            INT UNSIGNED,
			`intriguing`        INT UNSIGNED,
			`clip_url`            VARCHAR(255),
			`created_at`        TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
			PRIMARY KEY (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;

		CREATE TABLE `authors` (
			`id`                INT UNSIGNED NOT NULL,
			`name`                VARCHAR(255),
			PRIMARY KEY (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;

		CREATE TABLE `authors_recordings` (
			`id`                INT UNSIGNED NOT NULL AUTO_INCREMENT,
			`author_id`            INT UNSIGNED NOT NULL,
			`recording_id`        INT UNSIGNED NOT NULL,
			PRIMARY KEY (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;

	  END;
	END IF;

	IF @CurrentDBVer <= 1 THEN
	  BEGIN

		ALTER TABLE `quotes`
		ADD COLUMN `recording_id` INT NOT NULL;

	  END;
	END IF;

	IF @CurrentDBVer <= 2 THEN
	  BEGIN

	    CREATE TABLE `phoneshares` (
	      `id`    INT UNSIGNED NOT NULL AUTO_INCREMENT,
	      `dest_number` VARCHAR(255),
	      `sender_number` VARCHAR(255),
	      `send_at`       DATETIME,
	      `quote_id`  INT,
	      `greeting_url` VARCHAR(255),
	      `ready` TINYINT,
	      `sent` TINYINT,
	    PRIMARY KEY (`id`)
	    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	  END;
	END IF;


	/* Update the sequence number at the end */
	INSERT INTO `migration` SET `version` = 3;

END$$

CALL `updateDBSchema`();
