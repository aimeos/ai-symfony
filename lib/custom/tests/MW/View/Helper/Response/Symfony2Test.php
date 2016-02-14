<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2016
 */


namespace Aimeos\MW\View\Helper\Response;


class Symfony2Test extends \PHPUnit_Framework_TestCase
{
	private $object;
	private $mock;


	protected function setUp()
	{
		if( !class_exists( '\Symfony\Component\HttpFoundation\Response' ) ) {
			$this->markTestSkipped( '\Symfony\Component\HttpFoundation\Response is not available' );
		}

		if( !class_exists( '\Symfony\Bridge\PsrHttpMessage\Factory\DiactorosFactory' ) ) {
			$this->markTestSkipped( '\Symfony\Bridge\PsrHttpMessage\Factory\DiactorosFactory is not available' );
		}

		$view = new \Aimeos\MW\View\Standard();
		$request = new \Symfony\Component\HttpFoundation\Response( 'Content' );
		$this->object = new \Aimeos\MW\View\Helper\Response\Symfony2( $view, $request );
	}


	public function testTransform()
	{
		$this->assertInstanceOf( '\Aimeos\MW\View\Helper\Response\Symfony2', $this->object->transform() );
	}


	public function testCreateStream()
	{
		$this->assertInstanceOf( '\Psr\Http\Message\StreamInterface', $this->object->createStream( __FILE__ ) );
	}
}
