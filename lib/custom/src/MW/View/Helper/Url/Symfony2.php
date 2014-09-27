<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2014
 * @package MW
 * @subpackage View
 */


/**
 * View helper class for building URLs using Symfony2 Router.
 *
 * @package MW
 * @subpackage View
 */
class MW_View_Helper_Url_Symfony2
	extends MW_View_Helper_Abstract
	implements MW_View_Helper_Interface
{
	private $_router;


	/**
	 * Initializes the URL view helper.
	 *
	 * @param MW_View_Interface $view View instance with registered view helpers
	 * @param Symfony\Component\Routing\RouterInterface $router Symfony2 Router implementation
	 */
	public function __construct( $view, \Symfony\Component\Routing\RouterInterface $router )
	{
		parent::__construct( $view );

		$this->_router = $router;
	}


	/**
	 * Returns the URL assembled from the given arguments.
	 *
	 * @param string|null $target Route or page which should be the target of the link (if any)
	 * @param string|null $controller Name of the controller which should be part of the link (if any)
	 * @param string|null $action Name of the action which should be part of the link (if any)
	 * @param array $params Associative list of parameters that should be part of the URL
	 * @param array $trailing Trailing URL parts that are not relevant to identify the resource (for pretty URLs)
	 * @param array $config Additional configuration parameter per URL
	 * @return string Complete URL that can be used in the template
	 */
	public function transform( $target = null, $controller = null, $action = null, array $params = array(), array $trailing = array(), array $config = array() )
	{
		if( !empty( $trailing ) ) {
			$params['trailing'] = str_replace( '/', '_', join( '_', $trailing ) );
		}

		$refType = Symfony\Component\Routing\Generator\UrlGeneratorInterface::ABSOLUTE_PATH;

		if( isset( $config['absoluteUri'] ) ) {
			$refType = Symfony\Component\Routing\Generator\UrlGeneratorInterface::ABSOLUTE_URL;
		}

		return $this->_router->generate( $target, $params, $refType );
	}
}