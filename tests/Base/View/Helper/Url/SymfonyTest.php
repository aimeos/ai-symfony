<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2014-2025
 */


namespace Aimeos\Base\View\Helper\Url;


/**
 * Test class for \Aimeos\Base\View\Helper\Url\Symfony.
 */
class SymfonyTest extends \PHPUnit\Framework\TestCase
{
	private $object;


	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 *
	 * @access protected
	 */
	protected function setUp() : void
	{
		if( !class_exists( '\Symfony\Component\Routing\Router' ) ) {
			$this->markTestSkipped( 'Symfony\Component\Routing\Router is not available' );
		}

		$view = new \Aimeos\Base\View\Standard();

		$loc = new \Symfony\Component\Config\FileLocator( array( __DIR__ . DIRECTORY_SEPARATOR . '_testfiles' ) );
		$loader = new \Symfony\Component\Routing\Loader\PhpFileLoader( $loc );
		$router = new \Symfony\Component\Routing\Router( $loader, 'routing.php' );

		$this->object = new \Aimeos\Base\View\Helper\Url\Symfony( $view, $router, array( 'site' => 'unittest' ) );
	}


	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 *
	 * @access protected
	 */
	protected function tearDown() : void
	{
		$this->object = null;
	}


	public function testTransform()
	{
		$this->assertEquals( '/unittest/lists', $this->object->transform( 'catalog_list' ) );
	}


	public function testTransformArrays()
	{
		$this->assertEquals( '/unittest/lists?test%5B0%5D=a&test%5B1%5D=b', $this->object->transform( 'catalog_list', null, null, array( 'test' => array( 'a', 'b' ) ) ) );
	}


	public function testTransformTrailing()
	{
		$this->assertEquals( '/unittest/lists?trailing=a_b', $this->object->transform( 'catalog_list', null, null, [], array( 'a', 'b' ) ) );
	}


	public function testTransformAbsolute()
	{
		$options = array( 'absoluteUri' => true );
		$result = $this->object->transform( 'catalog_list', null, null, [], [], $options );
		$this->assertEquals( 'http://localhost/unittest/lists', $result );
	}
}
