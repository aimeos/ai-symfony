--
-- Customer database definition
--
-- License LGPLv3, http://opensource.org/licenses/LGPL-3.0
-- Copyright (c) Aimeos (aimeos.org), 2015
--


SET SESSION sql_mode='ANSI';



--
-- Table structure for `fos_user` created by Symfony doctrine
--
CREATE TABLE fos_user (
	id INT AUTO_INCREMENT NOT NULL,
	username VARCHAR(255) NOT NULL,
	username_canonical VARCHAR(255) NOT NULL,
	email VARCHAR(255) NOT NULL,
	email_canonical VARCHAR(255) NOT NULL,
	enabled TINYINT(1) NOT NULL,
	salt VARCHAR(255) NOT NULL,
	password VARCHAR(255) NOT NULL,
	last_login DATETIME DEFAULT NULL,
	locked TINYINT(1) NOT NULL,
	expired TINYINT(1) NOT NULL,
	expires_at DATETIME DEFAULT NULL,
	confirmation_token VARCHAR(255) DEFAULT NULL,
	password_requested_at DATETIME DEFAULT NULL,
	roles LONGTEXT NOT NULL COMMENT '(DC2Type:array)',
	credentials_expired TINYINT(1) NOT NULL,
	credentials_expire_at DATETIME DEFAULT NULL,
	salutation VARCHAR(8) NOT NULL,
	company VARCHAR(100) NOT NULL,
	vatid VARCHAR(32) NOT NULL,
	title VARCHAR(64) NOT NULL,
	firstname VARCHAR(64) NOT NULL,
	lastname VARCHAR(64) NOT NULL,
	address1 VARCHAR(255) NOT NULL,
	address2 VARCHAR(255) NOT NULL,
	address3 VARCHAR(255) NOT NULL,
	postal VARCHAR(16) NOT NULL,
	city VARCHAR(255) NOT NULL,
	state VARCHAR(255) NOT NULL,
	langid VARCHAR(5) DEFAULT NULL,
	countryid VARCHAR(2) DEFAULT NULL,
	telephone VARCHAR(32) NOT NULL,
	telefax VARCHAR(255) NOT NULL,
	website VARCHAR(255) NOT NULL,
	birthday DATE DEFAULT NULL,
	vdate DATE DEFAULT NULL,
	ctime DATETIME NOT NULL,
	mtime DATETIME NOT NULL,
	editor VARCHAR(255) NOT NULL,
UNIQUE INDEX UNIQ_957A647992FC23A8 (username_canonical),
UNIQUE INDEX UNIQ_957A6479A0D96FBF (email_canonical),
PRIMARY KEY(id)
) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;

--
-- Table structure for table `fos_user_address`
--
CREATE TABLE "fos_user_address" (
	-- Unique address id
	"id" INTEGER NOT NULL AUTO_INCREMENT,
	-- site id, not used
	"siteid" INTEGER NULL,
	-- reference id for customer
	"refid" INTEGER NOT NULL,
	-- company name
	"company" VARCHAR(100) NOT NULL,
	-- vatid
	"vatid" VARCHAR(32) NOT NULL,
	-- customer/supplier categorization
	"salutation" VARCHAR(8) NOT NULL,
	-- title of the customer/supplier
	"title" VARCHAR(64) NOT NULL,
	-- first name of customer/supplier
	"firstname" VARCHAR(64) NOT NULL,
	-- last name of customer/supplier
	"lastname" VARCHAR(64) NOT NULL,
	-- Depending on country, e.g. house name
	"address1" VARCHAR(255) NOT NULL,
	-- Depending on country, e.g. street
	"address2" VARCHAR(255) NOT NULL,
	-- Depending on country, e.g. county/suburb
	"address3" VARCHAR(255) NOT NULL,
	-- postal code of customer/supplier
	"postal" VARCHAR(16) NOT NULL,
	-- city name of customer/supplier
	"city" VARCHAR(255) NOT NULL,
	-- state name of customer/supplier
	"state" VARCHAR(255) NOT NULL,
	-- language id
	"langid" VARCHAR(5) NULL,
	-- Country id the customer/supplier is living in
	"countryid" CHAR(2) NULL,
	-- Telephone number of the customer/supplier
	"telephone" VARCHAR(32) NOT NULL,
	-- Email of the customer/supplier
	"email" VARCHAR(255) NOT NULL,
	-- Telefax of the customer/supplier
	"telefax" VARCHAR(255) NOT NULL,
	-- Website of the customer/supplier
	"website" VARCHAR(255) NOT NULL,
	-- Generic flag
	"flag" INTEGER NOT NULL,
	-- Position
	"pos" SMALLINT NOT NULL default 0,
	-- Date of last modification of this database entry
	"mtime" DATETIME NOT NULL,
	-- Date of creation of this database entry
	"ctime" DATETIME NOT NULL,
	-- Editor who modified this entry at last
	"editor" VARCHAR(255) NOT NULL,
CONSTRAINT "pk_fosad_id"
	PRIMARY KEY ("id")
) ENGINE=InnoDB CHARACTER SET = utf8;

CREATE INDEX "idx_fosad_refid" ON "fos_user_address" ("refid");

CREATE INDEX "idx_fosad_ln_fn" ON "fos_user_address" ("lastname", "firstname");

CREATE INDEX "idx_fosad_ad1_ad2" ON "fos_user_address" ("address1", "address2");

CREATE INDEX "idx_fosad_post_ci" ON "fos_user_address" ("postal", "city");

CREATE INDEX "idx_fosad_city" ON "fos_user_address" ("city");


--
-- Table structure for table `fos_user_list_type`
--

CREATE TABLE "fos_user_list_type" (
	-- Unique id
	"id" INTEGER NOT NULL AUTO_INCREMENT,
	-- site id
	"siteid" INTEGER NULL,
	-- domain
	"domain" VARCHAR(32) NOT NULL,
	-- code
	"code"  VARCHAR(32) NOT NULL COLLATE utf8_bin,
	-- Name of the list type
	"label" VARCHAR(255) NOT NULL,
	-- Status (0=disabled, 1=enabled, >1 for special)
	"status" SMALLINT NOT NULL,
	-- Date of last modification of this database entry
	"mtime" DATETIME NOT NULL,
	-- Date of creation of this database entry
	"ctime" DATETIME NOT NULL,
	-- Editor who modified this entry at last
	"editor" VARCHAR(255) NOT NULL,
CONSTRAINT "pk_foslity_id"
	PRIMARY KEY ("id"),
CONSTRAINT "unq_foslity_sid_dom_code"
	UNIQUE ("siteid", "domain", "code")
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE INDEX "idx_foslity_sid_status" ON "fos_user_list_type" ("siteid", "status");

CREATE INDEX "idx_foslity_sid_label" ON "fos_user_list_type" ("siteid", "label");

CREATE INDEX "idx_foslity_sid_code" ON "fos_user_list_type" ("siteid", "code");


--
-- Table structure for table `fos_user_list`
--

CREATE TABLE "fos_user_list" (
	-- Unique list id
	"id" INTEGER NOT NULL AUTO_INCREMENT,
	-- text id (parent id)
	"parentid" INTEGER NOT NULL,
	-- site id
	"siteid" INTEGER NULL,
	-- typeid
	"typeid" INTEGER NOT NULL,
	-- domain (e.g.: text, media)
	"domain" VARCHAR(32) NOT NULL,
	-- Reference of the object in given domain
	"refid" VARCHAR(32) NOT NULL,
	-- Valid from
	"start" DATETIME DEFAULT NULL,
	-- Valid until
	"end" DATETIME DEFAULT NULL,
	-- Configuration
	"config" TEXT NOT NULL,
	-- Precedence rating
	"pos" INTEGER NOT NULL,
	-- Status (0=disabled, 1=enabled, >1 for special)
	"status" SMALLINT NOT NULL,
	-- Date of last modification of this database entry
	"mtime" DATETIME NOT NULL,
	-- Date of creation of this database entry
	"ctime" DATETIME NOT NULL,
	-- Editor who modified this entry at last
	"editor" VARCHAR(255) NOT NULL,
CONSTRAINT "pk_fosli_id"
	PRIMARY KEY ("id"),
CONSTRAINT "unq_fosli_sid_dm_rid_tid_pid"
	UNIQUE ("siteid", "domain", "refid", "typeid", "parentid"),
CONSTRAINT "fk_fosli_pid"
	FOREIGN KEY ("parentid")
	REFERENCES "fos_user" ("id")
	ON UPDATE CASCADE
	ON DELETE CASCADE,
CONSTRAINT "fk_fosli_typeid"
	FOREIGN KEY ( "typeid" )
	REFERENCES "fos_user_list_type" ("id")
	ON DELETE CASCADE
	ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE INDEX "idx_fosli_sid_stat_start_end" ON "fos_user_list" ("siteid", "status", "start", "end");

CREATE INDEX "idx_fosli_pid_sid_rid_dom_tid" ON "fos_user_list" ("parentid", "siteid", "refid", "domain", "typeid");

CREATE INDEX "idx_fosli_pid_sid_start" ON "fos_user_list" ("parentid", "siteid", "start");

CREATE INDEX "idx_fosli_pid_sid_end" ON "fos_user_list" ("parentid", "siteid", "end");

CREATE INDEX "idx_fosli_pid_sid_pos" ON "fos_user_list" ("parentid", "siteid", "pos");

CREATE INDEX "idx_fosli_pid_sid_tid" ON "fos_user_list" ("parentid", "siteid", "typeid");
