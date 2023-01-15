<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2014-2023
 * @package MW
 * @subpackage View
 */


namespace Aimeos\Base\View\Helper\Request;


/**
 * View helper class for retrieving data from Symfony requests.
 *
 * @package MW
 * @subpackage View
 */
class Symfony
	extends \Aimeos\Base\View\Helper\Request\Standard
	implements \Aimeos\Base\View\Helper\Request\Iface
{
	private $request;


	/**
	 * Initializes the URL view helper.
	 *
	 * @param \Aimeos\Base\View\Iface $view View instance with registered view helpers
	 * @param \Symfony\Component\HttpFoundation\Request $request Symfony request object
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
	public function getClientAddress() : string
	{
		return $this->request->getClientIp();
	}


	/**
	 * Returns the current page or route name
	 *
	 * @return string|null Current page or route name
	 */
	public function getTarget() : ?string
	{
		return $this->request->get( '_route' );
	}


	/**
	 * Transforms a Symfony request into a PSR-7 request object
	 *
	 * @param \Symfony\Component\HttpFoundation\Request $nativeRequest Symfony request object
	 * @return \Psr\Http\Message\ServerRequestInterface PSR-7 request object
	 */
	protected function createRequest( \Symfony\Component\HttpFoundation\Request $nativeRequest ) : \Psr\Http\Message\ServerRequestInterface
	{
		$files = $this->getFiles( $nativeRequest->files->all() );
		$headers = $nativeRequest->headers->all();
		$server = $nativeRequest->server->all();
		$method = $nativeRequest->getMethod();
		$uri = $nativeRequest->getUri();

		$request = new \Nyholm\Psr7\ServerRequest( $method, $uri, $headers, $nativeRequest->getContent(), '1.1', $server );
		$request = $request->withCookieParams( $nativeRequest->cookies->all() )
			->withParsedBody( $nativeRequest->request->all() )
			->withQueryParams( $nativeRequest->query->all() )
			->withUploadedFiles( $files );

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
	protected function getFiles( array $files ) : array
	{
		$list = [];
		$psr17Factory = new \Nyholm\Psr7\Factory\Psr17Factory();

		foreach( $files as $key => $value )
		{
			if( $value instanceof \Symfony\Component\HttpFoundation\File\UploadedFile )
			{
				$list[$key] = $psr17Factory->createUploadedFile(
					$psr17Factory->createStreamFromFile( $value->getRealPath() ),
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
