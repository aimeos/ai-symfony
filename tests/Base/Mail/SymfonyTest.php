<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2023
 */


namespace Aimeos\Base\Mail;


class SymfonyTest extends \PHPUnit\Framework\TestCase
{
	private $mailer;
	private $mock;


	protected function setUp() : void
	{
		if( !class_exists( 'Symfony\Component\Mailer\MailerInterface' ) ) {
			$this->markTestSkipped( 'Class Symfony\Component\Mailer\MailerInterface not found' );
		}

		$mock = $this->getMockBuilder( 'Symfony\Component\Mailer\MailerInterface' )
			->disableOriginalConstructor()
			->getMock();

		$this->mailer = new \Aimeos\Base\Mail\Symfony( function() use ( $mock ) { return $mock; } );
		$this->mock = $mock;
	}


	public function testCreate()
	{
		$result = $this->mailer->create( 'ISO-8859-1' );
		$this->assertInstanceOf( '\\Aimeos\\Base\\Mail\\Message\\Iface', $result );
	}


	public function testSend()
	{
		$this->mock->expects( $this->once() )->method( 'send' );

		$this->mailer->send( $this->mailer->create() );
	}

}
