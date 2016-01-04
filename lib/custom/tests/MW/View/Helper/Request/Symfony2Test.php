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
	}


	public function testTransform()
	{
		$view = new \Aimeos\MW\View\Standard();
		$mock = $this->getMock( '\Symfony\Component\HttpFoundation\Request' );
		$object = new \Aimeos\MW\View\Helper\Request\Symfony2( $view, $mock, array() );

		$this->assertInstanceOf( '\\Aimeos\\MW\\View\\Helper\\Request\\Symfony2', $object->transform() );
	}


	public function testGetBody()
	{
		$view = new \Aimeos\MW\View\Standard();
		$mock = $this->getMock( '\Symfony\Component\HttpFoundation\Request' );

		$mock->expects( $this->once() )->method( 'getContent' )
			->will( $this->returnValue( 'body' ) );

		$object = new \Aimeos\MW\View\Helper\Request\Symfony2( $view, $mock, array() );

		$this->assertEquals( 'body', $object->transform()->getBody() );
	}


	public function testGetClientAddress()
	{
		$view = new \Aimeos\MW\View\Standard();
		$mock = $this->getMock( '\Symfony\Component\HttpFoundation\Request' );

		$mock->expects( $this->once() )->method( 'getClientIp' )
			->will( $this->returnValue( '127.0.0.1' ) );

		$object = new \Aimeos\MW\View\Helper\Request\Symfony2( $view, $mock, array() );

		$this->assertEquals( '127.0.0.1', $object->transform()->getClientAddress() );
	}


	public function testGetTarget()
	{
		$view = new \Aimeos\MW\View\Standard();
		$mock = $this->getMock( '\Symfony\Component\HttpFoundation\Request' );

		$mock->expects( $this->once() )->method( 'get' )
			->will( $this->returnValue( 'test' ) );

		$object = new \Aimeos\MW\View\Helper\Request\Symfony2( $view, $mock, array() );

		$this->assertEquals( 'test', $object->transform()->getTarget() );
	}


	public function testGetUploadedFiles()
	{
		$view = new \Aimeos\MW\View\Standard();
		$mock = $this->getMock( '\Symfony\Component\HttpFoundation\Request' );
		$object = new \Aimeos\MW\View\Helper\Request\Symfony2( $view, $mock, array() );

		$this->assertEquals( array(), $object->transform()->getUploadedFiles() );
	}
}
