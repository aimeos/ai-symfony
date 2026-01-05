<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2023-2026
 */


namespace Aimeos\Base\Mail\Message;


class SymfonyTest extends \PHPUnit\Framework\TestCase
{
	private $object;
	private $mailer;
	private $mock;


	protected function setUp() : void
	{
		if( !class_exists( 'Symfony\Component\Mime\Email' ) ) {
			$this->markTestSkipped( 'Class Symfony\Component\Mime\Email not found' );
		}

		$this->mailer = $this->getMockBuilder( 'Symfony\Component\Mailer\MailerInterface' )
			->disableOriginalConstructor()
			->getMock();

		$this->mock = $this->getMockBuilder( 'Symfony\Component\Mime\Email' )
			->disableOriginalConstructor()
			->getMock();

		$this->object = new \Aimeos\Base\Mail\Message\Symfony( $this->mailer, $this->mock, 'UTF-8' );
	}


	protected function tearDown() : void
	{
		unset( $this->object, $this->mock );
	}


	public function testFrom()
	{
		$this->mock->expects( $this->once() )->method( 'from' );

		$result = $this->object->from( 'a@b', 'test' );
		$this->assertSame( $this->object, $result );
	}


	public function testTo()
	{
		$this->mock->expects( $this->once() )->method( 'to' );

		$result = $this->object->to( 'a@b', 'test' );
		$this->assertSame( $this->object, $result );
	}


	public function testCc()
	{
		$this->mock->expects( $this->once() )->method( 'cc' );

		$result = $this->object->cc( 'a@b', 'test' );
		$this->assertSame( $this->object, $result );
	}


	public function testBcc()
	{
		$this->mock->expects( $this->once() )->method( 'bcc' );

		$result = $this->object->bcc( 'a@b', 'test' );
		$this->assertSame( $this->object, $result );
	}


	public function testReplyTo()
	{
		$this->mock->expects( $this->once() )->method( 'replyTo' );

		$result = $this->object->replyTo( 'a@b', 'test' );
		$this->assertSame( $this->object, $result );
	}


	public function testSend()
	{
		$this->mailer->expects( $this->once() )->method( 'send' );
		$this->assertSame( $this->object, $this->object->send() );
	}


	public function testSender()
	{
		$this->mock->expects( $this->once() )->method( 'sender' );

		$result = $this->object->sender( 'a@b', 'test' );
		$this->assertSame( $this->object, $result );
	}


	public function testSubject()
	{
		$this->mock->expects( $this->once() )->method( 'subject' )
			->with( $this->stringContains( 'test' ) );

		$result = $this->object->subject( 'test' );
		$this->assertSame( $this->object, $result );
	}


	public function testText()
	{
		$this->mock->expects( $this->once() )->method( 'text' )
			->with( $this->stringContains( 'test' ) );

		$result = $this->object->text( 'test' );
		$this->assertSame( $this->object, $result );
	}


	public function testHtml()
	{
		$this->mock->expects( $this->once() )->method( 'html' )
			->with( $this->stringContains( 'test' ) );

		$result = $this->object->html( 'test' );
		$this->assertSame( $this->object, $result );
	}


	public function testAttach()
	{
		$this->mock->expects( $this->once() )->method( 'attach' );

		$result = $this->object->attach( 'test', 'test.txt', 'text/plain' );
		$this->assertSame( $this->object, $result );
	}


	public function testEmbed()
	{
		$this->mock->expects( $this->once() )->method( 'embed' );

		$result = $this->object->embed( 'test', 'test.txt', 'text/plain' );
		$this->assertEquals( 'cid:test.txt', $result );
	}


	public function testObject()
	{
		$this->assertInstanceOf( 'Symfony\Component\Mime\Email', $this->object->object() );
	}
}
