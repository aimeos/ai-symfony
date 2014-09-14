<?php

/**
 * Test class for MW_View_Helper_Url_Symfony2.
 *
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 */
class MW_View_Helper_Url_Symfony2Test extends MW_Unittest_Testcase
{
	private $_object;


	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 *
	 * @access protected
	 */
	protected function setUp()
	{
		if( !class_exists( '\Symfony\Component\Routing\Router' ) ) {
			$this->markTestSkipped( 'Symfony\Component\Routing\Router is not available' );
		}

		$view = new MW_View_Default();

		$loc = new \Symfony\Component\Config\FileLocator( array( __DIR__ . DIRECTORY_SEPARATOR . '_testfiles' ) );
		$loader = new \Symfony\Component\Routing\Loader\PhpFileLoader( $loc );
		$router = new \Symfony\Component\Routing\Router( $loader, 'routing.php' );

		$this->_object = new MW_View_Helper_Url_Symfony2( $view, $router );
	}


	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 *
	 * @access protected
	 */
	protected function tearDown()
	{
		$this->_object = null;
	}


	public function testTransform()
	{
		$this->assertEquals( '/list', $this->_object->transform( 'catalog_list' ) );
	}


	public function testTransformSlashes()
	{
		$this->assertEquals( '/list?test=a%2Fb', $this->_object->transform( 'catalog_list', null, null, array( 'test' => 'a/b' ) ) );
	}


	public function testTransformArrays()
	{
		$this->assertEquals( '/list?test%5B0%5D=a&test%5B1%5D=b', $this->_object->transform( 'catalog_list', null, null, array( 'test' => array( 'a', 'b' ) ) ) );
	}


	public function testTransformTrailing()
	{
		$this->assertEquals( '/list?trailing=a_b', $this->_object->transform( 'catalog_list', null, null, array(), array( 'a', 'b' ) ) );
	}


	public function testTransformAbsolute()
	{
		$options = array( 'absoluteUri' => true );
		$result = $this->_object->transform( 'catalog_list', null, null, array(), array(), $options );
		$this->assertEquals( 'http://localhost/list', $result );
	}
}
