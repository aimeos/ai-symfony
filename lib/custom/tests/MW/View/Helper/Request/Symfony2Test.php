<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2021
 */


namespace Aimeos\MW\View\Helper\Request;


class Symfony2Test extends \PHPUnit\Framework\TestCase
{
	private $object;
	private $mock;


	protected function setUp() : void
	{
		$view = new \Aimeos\MW\View\Standard();
		$files = array( 'test' => array( 'file' => array(
			'name' => 'test.txt',
			'type' => 'text/plain',
			'tmp_name' => tempnam( sys_get_temp_dir(), 'ai-symfony_' ),
			'error' => UPLOAD_ERR_OK,
			'size' => 123
		) ) );
		$param = array( 'HTTP_HOST' => 'localhost', 'REMOTE_ADDR' => '127.0.0.1' );
		$request = new \Symfony\Component\HttpFoundation\Request( [], [], [], [], $files, $param, 'Content' );
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
