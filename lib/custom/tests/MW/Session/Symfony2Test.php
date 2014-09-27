<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2014
 */


/**
 * Test class for MW_Session_Symfony2.
 */
class MW_Session_Symfony2Test extends MW_Unittest_Testcase
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
		if( class_exists( 'Symfony\Component\HttpFoundation\Session\Session' ) === false ) {
			$this->markTestSkipped( 'Class Symfony\Component\HttpFoundation\Session\Session not found' );
		}

		$storage = new \Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage();
		$session = new \Symfony\Component\HttpFoundation\Session\Session( $storage );
		$this->_object = new MW_Session_Symfony2( $session );
	}


	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 *
	 * @access protected
	 */
	protected function tearDown()
	{
		unset( $this->_object );
	}


	public function testGetDefault()
	{
		$this->assertEquals( null, $this->_object->get( 'notexist' ) );
	}


	public function testGetSet()
	{
		$this->_object->set( 'key', 'value' );
		$this->assertEquals( 'value', $this->_object->get( 'key' ) );
	}


	public function testGetSetArray()
	{
		$this->_object->set( 'key', array( 'value' ) );
		$this->assertEquals( array( 'value' ), $this->_object->get( 'key' ) );
	}
}
