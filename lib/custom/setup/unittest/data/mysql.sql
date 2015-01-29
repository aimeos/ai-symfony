--
-- License LGPLv3, http://opensource.org/licenses/LGPL-3.0
-- Copyright (c) Aimeos (aimeos.org), 2015
--


-- Do not enable for setup as this hides errors
-- SET NAMES 'utf8';


START TRANSACTION;


SET @siteid = ( SELECT `id` FROM `mshop_locale_site` WHERE `code` = 'unittest' );

--
-- Typo3 tables
--
DELETE FROM `fos_user` WHERE `website` = 'unittest.aimeos.org';
DELETE FROM `fos_user_address` WHERE `website` = 'unittest.aimeos.org';


--
-- Fos users
--
INSERT INTO `fos_user` ( `username_canonical`, `username`, `salutation`, `company`, `vatid`, `title`, `firstname`, `lastname`, `address1`, `address2`, `postal`, `city`, `state`, `langid`, `countryid`, `telephone`, `email`, `email_canonical`, `telefax`, `website`, `birthday`, `enabled`, `password`, `mtime`, `ctime`, `editor`)
	VALUES ( 'unitCustomer1', 'unitCustomer1', 'mr', 'ABC GmbH', 'DE999999999', 'Dr.', 'Max', 'Mustermann', 'Musterstraße', '1a', '20001', 'Musterstadt', 'Hamburg', 'de', 'DEU', '01234567890', 'unitCustomer1@aimeos.org', 'unitCustomer1@aimeos.org', '01234567890', 'unittest.aimeos.org', '1970-01-01 00:00:00', '1', '5f4dcc3b5aa765d61d8327deb882cf99', '2001-01-01 00:00:00', '2000-01-01 00:00:00', 'ai-symfony:unittest' );
INSERT INTO `fos_user` ( `username_canonical`, `username`, `salutation`, `company`, `vatid`, `title`, `firstname`, `lastname`, `address1`, `address2`, `postal`, `city`, `state`, `langid`, `countryid`, `telephone`, `email`, `email_canonical`, `telefax`, `website`, `birthday`, `enabled`, `password`, `mtime`, `ctime`, `editor`)
	VALUES ( 'unitCustomer2', 'unitCustomer2', 'mrs', 'ABC GmbH', 'DE999999999', 'Prof. Dr.', 'Erika', 'Mustermann', 'Heidestraße', '17', '45632', 'Köln', '', 'de', 'DEU', '09876543210', 'unitCustomer2@aimeos.org', 'unitCustomer2@aimeos.org', '09876543210', 'unittest.aimeos.org', '1970-01-01 00:00:00', '0', '5f4dcc3b5aa765d61d8327deb882cf99', '2001-01-01 00:00:00', '2000-01-01 00:00:00', 'ai-symfony:unittest' );
INSERT INTO `fos_user` ( `username_canonical`, `username`, `salutation`, `company`, `vatid`, `title`, `firstname`, `lastname`, `address1`, `address2`, `postal`, `city`, `state`, `langid`, `countryid`, `telephone`, `email`, `email_canonical`, `telefax`, `website`, `birthday`, `enabled`, `password`, `mtime`, `ctime`, `editor`)
	VALUES ( 'unitCustomer3', 'unitCustomer3', 'mr', 'ABC GmbH', 'DE999999999', '', 'Franz-Xaver', 'Gabler', 'Phantasiestraße', '2', '23643', 'Berlin', 'Berlin', 'de', 'DEU', '01234509876', 'unitCustomer3@aimeos.org', 'unitCustomer3@aimeos.org', '055544333212', 'unittest.aimeos.org', '1970-01-01 00:00:00', '1', '5f4dcc3b5aa765d61d8327deb882cf99', '2001-01-01 00:00:00', '2000-01-01 00:00:00', 'ai-symfony:unittest' );


COMMIT;
