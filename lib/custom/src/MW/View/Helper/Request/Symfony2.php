<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2014-2015
 * @package MW
 * @subpackage View
 */


/**
 * View helper class for retrieving data from Symfony2 requests.
 *
 * @package MW
 * @subpackage View
 */
class MW_View_Helper_Request_Symfony2
	extends MW_View_Helper_Abstract
	implements MW_View_Helper_Interface
{
	private $request;


	/**
	 * Initializes the URL view helper.
	 *
	 * @param MW_View_Interface $view View instance with registered view helpers
	 * @param \Symfony\Component\HttpFoundation\Request $request Symfony2 request object
	 */
	public function __construct( $view, \Symfony\Component\HttpFoundation\Request $request )
	{
		parent::__construct( $view );

		$this->request = $request;
	}


	/**
	 * Returns the request view helper.
	 *
	 * @return MW_View_Helper_Interface Request view helper
	 */
	public function transform()
	{
		return $this;
	}


	/**
	 * Returns the request body.
	 *
	 * @return string Request body
	 */
	public function getBody()
	{
		return $this->request->getContent();
	}


	/**
	 * Returns the client IP address.
	 *
	 * @return string Client IP address
	 */
	public function getClientAddress()
	{
		return $this->request->getClientIp();
	}
}
