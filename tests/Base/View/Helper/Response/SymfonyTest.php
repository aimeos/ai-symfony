<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2025
 */


namespace Aimeos\Base\View\Helper\Response;


class SymfonyTest extends \PHPUnit\Framework\TestCase
{
	private $object;
	private $mock;


	protected function setUp() : void
	{
		$view = new \Aimeos\Base\View\Standard();
		$this->object = new \Aimeos\Base\View\Helper\Response\Symfony( $view );
	}


	public function testTransform()
	{
		$this->assertInstanceOf( '\Aimeos\Base\View\Helper\Response\Symfony', $this->object->transform() );
	}


	public function testCreateStream()
	{
		$this->assertInstanceOf( \Psr\Http\Message\StreamInterface::class, $this->object->createStream( __FILE__ ) );
	}
}
