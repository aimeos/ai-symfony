<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015
 */

return array(
	'delete' => array(
		'ansi' => '
			DELETE FROM "fos_user_address"
			WHERE :cond
		',
	),
	'insert' => array(
		'ansi' => '
			INSERT INTO "fos_user_address" (
				"siteid", "parentid", "company", "vatid", "salutation", "title",
				"firstname", "lastname", "address1", "address2", "address3",
				"postal", "city", "state", "countryid", "langid", "telephone",
				"email", "telefax", "website", "flag", "pos", "mtime",
				"editor", "ctime"
			) VALUES (
				?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?
			)
		',
	),
	'update' => array(
		'ansi' => '
			UPDATE "fos_user_address"
			SET "siteid" = ?, "parentid" = ?, "company" = ?, "vatid" = ?, "salutation" = ?,
				"title" = ?, "firstname" = ?, "lastname" = ?, "address1" = ?,
				"address2" = ?, "address3" = ?, "postal" = ?, "city" = ?,
				"state" = ?, "countryid" = ?, "langid" = ?, "telephone" = ?,
				"email" = ?, "telefax" = ?, "website" = ?, "flag" = ?,
				"pos" = ?, "mtime" = ?, "editor" = ?
			WHERE "id" = ?
		',
	),
	'search' => array(
		'ansi' => '
			SELECT DISTINCT fosad."id", fosad."parentid",
				fosad."company", fosad."vatid", fosad."salutation", fosad."title",
				fosad."firstname", fosad."lastname", fosad."address1",
				fosad."address2", fosad."address3", fosad."postal",
				fosad."city", fosad."state", fosad."countryid",
				fosad."langid", fosad."telephone", fosad."email",
				fosad."telefax", fosad."website", fosad."flag",
				fosad."pos", fosad."mtime", fosad."editor", fosad."ctime"
			FROM "fos_user_address" AS fosad
			:joins
			WHERE :cond
			/*-orderby*/ ORDER BY :order /*orderby-*/
			LIMIT :size OFFSET :start
		',
	),
	'count' => array(
		'ansi' => '
			SELECT COUNT(*) AS "count"
			FROM (
				SELECT DISTINCT fosad."id"
				FROM "fos_user_address" AS fosad
				:joins
				WHERE :cond
				LIMIT 10000 OFFSET 0
			) AS list
		',
	),
	'newid' => array(
		'mysql' => 'SELECT LAST_INSERT_ID()'
	),
);
