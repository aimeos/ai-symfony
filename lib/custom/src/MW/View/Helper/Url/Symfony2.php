<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2014-2016
 * @package MW
 * @subpackage View
 */


namespace Aimeos\MW\View\Helper\Url;


/**
 * View helper class for building URLs using Symfony2 Router.
 *
 * @package MW
 * @subpackage View
 */
class Symfony2
	extends \Aimeos\MW\View\Helper\Url\Base
	implements \Aimeos\MW\View\Helper\Url\Iface
{
	private $router;
	private $fixed;


	/**
	 * Initializes the URL view helper.
	 *
	 * @param \Aimeos\MW\View\Iface $view View instance with registered view helpers
	 * @param Symfony\Component\Routing\RouterInterface $router Symfony2 Router implementation
	 * @param array $fixed Fixed parameters that should be added to each URL
	 */
	public function __construct( $view, \Symfony\Component\Routing\RouterInterface $router, array $fixed )
	{
		parent::__construct( $view );

		$this->router = $router;
		$this->fixed = $fixed;
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
	public function transform( $target = null, $controller = null, $action = null, array $params = [], array $trailing = [], array $config = [] )
	{
		if( !empty( $trailing ) ) {
			$params['trailing'] = join( '_', $trailing );
		}

		$params = $this->sanitize( $params );
		$refType = \Symfony\Component\Routing\Generator\UrlGeneratorInterface::ABSOLUTE_PATH;

		if( isset( $config['absoluteUri'] ) ) {
			$refType = \Symfony\Component\Routing\Generator\UrlGeneratorInterface::ABSOLUTE_URL;
		}

		return $this->router->generate( $target, $params + $this->fixed, $refType );
	}
}
