<?php

namespace Aimeos\MW\View\Helper\Request;


/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015
 */
class Symfony2Test extends \PHPUnit_Framework_TestCase
{
	private $object;
	private $mock;


	protected function setUp()
	{
		if( !class_exists( '\Symfony\Component\HttpFoundation\Request' ) ) {
			$this->markTestSkipped( '\Symfony\Component\HttpFoundation\Request is not available' );
		}

		if( !class_exists( '\Symfony\Bridge\PsrHttpMessage\Factory\DiactorosFactory' ) ) {
			$this->markTestSkipped( '\Symfony\Bridge\PsrHttpMessage\Factory\DiactorosFactory is not available' );
		}

		$view = new \Aimeos\MW\View\Standard();
		$param = array( 'HTTP_HOST' => 'localhost', 'REMOTE_ADDR' => '127.0.0.1' );
		$request = new \Symfony\Component\HttpFoundation\Request( array(), array(), array(), array(), array(), $param, 'Content' );
		$this->object = new \Aimeos\MW\View\Helper\Request\Symfony2( $view, $request );
	}


	public function testTransform()
	{
		$this->assertInstanceOf( '\Aimeos\MW\View\Helper\Request\Symfony2', $this->object->transform() );
	}


	public function testGetClientAddress()
	{
		$this->assertEquals( '127.0.0.1', $this->object->getClientAddress() );
	}


	public function testGetTarget()
	{
		$this->assertEquals( null, $this->object->getTarget() );
	}
}
