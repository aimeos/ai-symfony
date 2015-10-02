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
	private $object;


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
		$this->object = new MW_Session_Symfony2( $session );
	}


	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 *
	 * @access protected
	 */
	protected function tearDown()
	{
		unset( $this->object );
	}


	public function testGetDefault()
	{
		$this->assertEquals( null, $this->object->get( 'notexist' ) );
	}


	public function testGetSet()
	{
		$this->object->set( 'key', 'value' );
		$this->assertEquals( 'value', $this->object->get( 'key' ) );
	}


	public function testGetSetArray()
	{
		$this->object->set( 'key', array( 'value' ) );
		$this->assertEquals( array( 'value' ), $this->object->get( 'key' ) );
	}
}
