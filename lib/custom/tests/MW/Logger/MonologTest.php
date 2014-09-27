<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2014
 */


/**
 * Test class for MW_Logger_Monolog.
 */
class MW_Logger_MonologTest extends MW_Unittest_Testcase
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
		if( class_exists( '\Monolog\Logger' ) === false ) {
			$this->markTestSkipped( 'Class Monolog\Logger not found' );
		}

		$log = new \Monolog\Logger( 'test' );
		$log->pushHandler( new Monolog\Handler\StreamHandler( 'monolog.log', \Monolog\Logger::INFO ) );

		$this->_object = new MW_Logger_Monolog( $log );
	}


	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 *
	 * @access protected
	 */
	protected function tearDown()
	{
		@unlink( 'monolog.log' );
	}


	public function testLog()
	{
		$this->_object->log( 'error' );
		$this->assertRegExp( '/^\[[^\]]+\] test.ERROR: error/', file_get_contents( 'monolog.log' ) );
	}


	public function testNonScalarLog()
	{
		$this->_object->log( array( 'error', 'error2', 2 ) );
		$this->assertRegExp( '/^\[[^\]]+\] test.ERROR: \["error","error2",2\]/', file_get_contents( 'monolog.log' ) );
	}


	public function testLogDebug()
	{
		$this->_object->log( 'debug', MW_Logger_Abstract::DEBUG );
		$this->assertFalse( file_exists( 'monolog.log' ) );
	}


	public function testBadPriority()
	{
		$this->setExpectedException( 'MW_Logger_Exception' );
		$this->_object->log( 'error', -1 );
	}
}
