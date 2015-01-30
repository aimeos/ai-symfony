<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015
 */

return array(
	'item' => array(
		'delete' => '
			DELETE FROM "fos_user"
			WHERE :cond
		',
		'insert' => '
			INSERT INTO "fos_user" (
				"username_canonical", "username", "company", "vatid", "salutation", "title",
				"firstname", "lastname", "address1", "address2", "address3",
				"postal", "city", "state", "countryid", "langid", "telephone",
				"email_canonical", "email", "telefax", "website", "birthday", "enabled",
				"vdate", "password", "mtime", "editor", "roles", "ctime"
			) VALUES (
				?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?
			)
		',
		'update' => '
			UPDATE "fos_user"
			SET "username_canonical" = ?, "username" = ?, "company" = ?, "vatid" = ?,
				"salutation" = ?, "title" = ?, "firstname" = ?, "lastname" = ?,
				"address1" = ?, "address2" = ?, "address3" = ?, "postal" = ?,
				"city" = ?, "state" = ?, "countryid" = ?, "langid" = ?,
				"telephone" = ?, "email_canonical" = ?, "email" = ?, "telefax" = ?,
				"website" = ?, "birthday" = ?, "enabled" = ?, "vdate" = ?, "password" = ?,
				"mtime" = ?, "editor" = ?, "roles" = ?
			WHERE "id" = ?
		',
		'search' => '
			SELECT DISTINCT fos."id", fos."username_canonical" as "code", fos."username" as "label",
				fos."company", fos."vatid", fos."salutation", fos."title",
				fos."firstname", fos."lastname", fos."address1",
				fos."address2", fos."address3", fos."postal", fos."city",
				fos."state", fos."countryid", fos."langid",
				fos."telephone", fos."email_canonical", fos."telefax", fos."website",
				fos."birthday", fos."enabled" as "status", fos."vdate", fos."password",
				fos."ctime", fos."mtime", fos."editor", fos."roles"
			FROM "fos_user" AS fos
			:joins
			WHERE :cond
			/*-orderby*/ ORDER BY :order /*orderby-*/
			LIMIT :size OFFSET :start
		',
		'count' => '
			SELECT COUNT(*) AS "count"
			FROM (
				SELECT DISTINCT fos."id"
				FROM "fos_user" AS fos
				:joins
				WHERE :cond
				LIMIT 10000 OFFSET 0
			) AS list
		',
	),
);