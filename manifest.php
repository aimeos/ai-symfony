<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2014
 */

return array(
	'name' => 'ai-symfony2',
	'depends' => array(
		'aimeos-core',
	),
	'include' => array(
		'lib/custom/src',
	),
	'config' => array(
		'mysql' => array(
			'lib/custom/config/common',
			'lib/custom/config/mysql',
		),
	),
	'setup' => array(
		'lib/custom/setup',
	),
);
