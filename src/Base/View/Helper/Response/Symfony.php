<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2014-2025
 * @package MW
 * @subpackage View
 */


namespace Aimeos\Base\View\Helper\Response;


/**
 * View helper class for retrieving data from Symfony responses.
 *
 * @package MW
 * @subpackage View
 */
class Symfony
	extends \Aimeos\Base\View\Helper\Response\Standard
	implements \Aimeos\Base\View\Helper\Response\Iface
{
	/**
	 * Initializes the URL view helper.
	 *
	 * @param \Aimeos\Base\View\Iface $view View instance with registered view helpers
	 */
	public function __construct( \Aimeos\Base\View\Iface $view )
	{
		$psr17Factory = new \Nyholm\Psr7\Factory\Psr17Factory();
		parent::__construct( $view, $psr17Factory->createResponse() );
	}
}
