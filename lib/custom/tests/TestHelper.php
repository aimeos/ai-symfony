<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2014-2023
 */

class TestHelper
{
	private static $aimeos;
	private static $context = [];


	public static function bootstrap()
	{
		$mshop = self::getAimeos();

		$includepaths = $mshop->getIncludePaths();
		$includepaths[] = get_include_path();
		set_include_path( implode( PATH_SEPARATOR, $includepaths ) );
	}


	public static function context( $site = 'unittest' )
	{
		if( !isset( self::$context[$site] ) ) {
			self::$context[$site] = self::createContext( $site );
		}

		return clone self::$context[$site];
	}


	private static function getAimeos()
	{
		if( !isset( self::$aimeos ) )
		{
			require_once 'Bootstrap.php';
			spl_autoload_register( 'Aimeos\\Bootstrap::autoload' );

			$extdir = dirname( dirname( dirname( __DIR__ ) ) );
			self::$aimeos = new \Aimeos\Bootstrap( array( $extdir ), false );
		}

		return self::$aimeos;
	}


	/**
	 * Creates a new context item.
	 *
	 * @param string $site Unique site code
	 * @return \\Aimeos\MShop\ContextIface Context object
	 */
		private static function createContext( $site )
	{
		$ctx = new \Aimeos\MShop\Context();
		$mshop = self::getAimeos();


		$paths = $mshop->getConfigPaths( 'mysql' );
		$paths[] = __DIR__ . DIRECTORY_SEPARATOR . 'config';

		$conf = new \Aimeos\Base\Config\PHPArray( [], $paths );
		$ctx->setConfig( $conf );


		$dbm = new \Aimeos\Base\DB\Manager\PDO( $conf );
		$ctx->setDatabaseManager( $dbm );


		$logger = new \Aimeos\Base\Logger\File( $site . '.log', \Aimeos\Base\Logger\Iface::DEBUG );
		$ctx->setLogger( $logger );


		$session = new \Aimeos\Base\Session\None();
		$ctx->setSession( $session );


		$localeManager = \Aimeos\MShop\Locale\Manager\Factory::create( $ctx );
		$localeItem = $localeManager->bootstrap( $site, '', '', false );

		$ctx->setLocale( $localeItem );

		$ctx->setEditor( 'ai-symfony:lib/custom' );

		return $ctx;
	}
}
