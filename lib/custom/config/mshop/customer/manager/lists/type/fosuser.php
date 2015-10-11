<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015
 */

return array(
	'insert' => array(
		'ansi' => '
			INSERT INTO "fos_user_list_type"( "siteid", "code", "domain", "label", "status",
				"mtime", "editor", "ctime" )
			VALUES ( ?, ?, ?, ?, ?, ?, ?, ? )
		',
	),
	'update' => array(
		'ansi' => '
			UPDATE "fos_user_list_type"
			SET "siteid"=?, "code" = ?, "domain" = ?, "label" = ?, "status" = ?, "mtime" = ?, "editor" = ?
			WHERE "id" = ?
		',
	),
	'delete' => array(
		'ansi' => '
			DELETE FROM "fos_user_list_type"
			WHERE :cond AND siteid = ?
		',
	),
	'search' => array(
		'ansi' => '
			SELECT foslity."id", foslity."siteid", foslity."code",
				foslity."domain", foslity."label", foslity."status",
				foslity."mtime", foslity."editor", foslity."ctime"
			FROM "fos_user_list_type" AS foslity
			:joins
			WHERE
				:cond
			/*-orderby*/ ORDER BY :order /*orderby-*/
			LIMIT :size OFFSET :start
		',
	),
	'count' => array(
		'ansi' => '
			SELECT COUNT(*) AS "count"
			FROM (
				SELECT DISTINCT foslity."id"
				FROM "fos_user_list_type" AS foslity
				:joins
				WHERE :cond
				LIMIT 10000 OFFSET 0
			) AS LIST
		',
	),
	'newid' => array(
		'mysql' => 'SELECT LAST_INSERT_ID()'
	),
);
