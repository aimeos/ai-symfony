<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2014-2016
 * @package MW
 * @subpackage View
 */


namespace Aimeos\MW\View\Helper\Request;

use Zend\Diactoros\ServerRequestFactory;
use Zend\Diactoros\ServerRequest;
use Zend\Diactoros\Stream;


/**
 * View helper class for retrieving data from Symfony2 requests.
 *
 * @package MW
 * @subpackage View
 */
class Symfony2
	extends \Aimeos\MW\View\Helper\Request\Standard
	implements \Aimeos\MW\View\Helper\Request\Iface
{
	private $request;


	/**
	 * Initializes the URL view helper.
	 *
	 * @param \Aimeos\MW\View\Iface $view View instance with registered view helpers
	 * @param \Symfony\Component\HttpFoundation\Request $request Symfony2 request object
	 */
	public function __construct( $view, \Symfony\Component\HttpFoundation\Request $request )
	{
		$this->request = $request;

		parent::__construct( $view, $this->createRequest( $request ) );
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


	/**
	 * Returns the current page or route name
	 *
	 * @return string|null Current page or route name
	 */
	public function getTarget()
	{
		return $this->request->get( '_route' );
	}


	/**
	 * Transforms a Symfony request into a PSR-7 request object
	 *
	 * @param \Symfony\Component\HttpFoundation\Request $nativeRequest Symfony request object
	 * @return \Psr\Http\Message\ServerRequestInterface PSR-7 request object
	 */
	protected function createRequest( \Symfony\Component\HttpFoundation\Request $nativeRequest )
	{
		$files = ServerRequestFactory::normalizeFiles( $this->getFiles( $nativeRequest->files->all() ) );
		$server = ServerRequestFactory::normalizeServer( $nativeRequest->server->all() );
		$headers = $nativeRequest->headers->all();
		$cookies = $nativeRequest->cookies->all();
		$post = $nativeRequest->request->all();
		$query = $nativeRequest->query->all();
		$method = $nativeRequest->getMethod();
		$uri = $nativeRequest->getUri();

		$body = new Stream( 'php://temp', 'wb+' );
		$body->write( $nativeRequest->getContent() );

		$request = new ServerRequest( $server, $files, $uri, $method, $body, $headers, $cookies, $query, $post );

		foreach( $nativeRequest->attributes->all() as $key => $value ) {
			$request = $request->withAttribute( $key, $value );
		}

		return $request;
	}


	/**
	 * Converts Symfony uploaded files array to the PSR-7 one.
	 *
	 * @param array $files Multi-dimensional list of uploaded files from Symfony request
	 * @return array Multi-dimensional list of uploaded files as PSR-7 objects
	 */
	protected function getFiles( array $files )
	{
		$list = [];

		foreach( $files as $key => $value )
		{
			if( $value instanceof \Symfony\Component\HttpFoundation\File\UploadedFile )
			{
				$list[$key] = new \Zend\Diactoros\UploadedFile(
					$value->getRealPath(),
					$value->getSize(),
					$value->getError(),
					$value->getClientOriginalName(),
					$value->getClientMimeType()
				);
			}
			elseif( is_array( $value ) )
			{
				$list[$key] = $this->getFiles( $value );
			}
		}

		return $list;
	}
}
