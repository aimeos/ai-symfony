<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2024
 */


namespace Aimeos\Base\Mail\Manager;


class SymfonyTest extends \PHPUnit\Framework\TestCase
{
	private $mock;


	protected function setUp() : void
	{
		if( !interface_exists( 'Symfony\Component\Mailer\MailerInterface' ) ) {
			$this->markTestSkipped( 'Class Symfony\Component\Mailer\MailerInterface not found' );
		}

		$this->mock = $this->getMockBuilder( 'Symfony\Component\Mailer\MailerInterface' )
			->disableOriginalConstructor()
			->getMock();
	}


	public function testGet()
	{
		$object = new \Aimeos\Base\Mail\Manager\Symfony( fn() => $this->mock );
		$this->assertInstanceOf( \Aimeos\Base\Mail\Iface::class, $object->get( '' ) );
	}
}
