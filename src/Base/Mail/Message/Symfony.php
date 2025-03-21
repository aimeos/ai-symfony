<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2023-2025
 * @package Base
 * @subpackage Mail
 */


namespace Aimeos\Base\Mail\Message;


/**
 * Symfony implementation for creating e-mails.
 *
 * @package Base
 * @subpackage Mail
 */
class Symfony implements \Aimeos\Base\Mail\Message\Iface
{
	private \Symfony\Component\Mailer\MailerInterface $mailer;
	private \Symfony\Component\Mime\Email $object;
	private string $charset;


	/**
	 * Initializes the message instance.
	 *
	 * @param \Symfony\Component\Mailer\MailerInterface $mailer Symfony mailer object
	 * @param string $charset Default charset of the message
	 */
	public function __construct( \Symfony\Component\Mailer\MailerInterface $mailer, \Symfony\Component\Mime\Email $object, string $charset )
	{
		$this->mailer = $mailer;
		$this->object = $object;
		$this->charset = $charset;
	}


	/**
	 * Adds a source e-mail address of the message.
	 *
	 * @param string $email Source e-mail address
	 * @param string|null $name Name of the user sending the e-mail or null for no name
	 * @return \Aimeos\Base\Mail\Message\Iface Message object
	 */
	public function from( string $email, ?string $name = null ) : Iface
	{
		if( $email ) {
			$this->object->from( new \Symfony\Component\Mime\Address( $email, (string) $name ) );
		}

		return $this;
	}


	/**
	 * Adds a destination e-mail address of the target user mailbox.
	 *
	 * @param string $email Destination address of the target mailbox
	 * @param string|null $name Name of the user owning the target mailbox or null for no name
	 * @return \Aimeos\Base\Mail\Message\Iface Message object
	 */
	public function to( string $email, ?string $name = null ) : Iface
	{
		if( $email ) {
			$this->object->to( new \Symfony\Component\Mime\Address( $email, (string) $name ) );
		}

		return $this;
	}


	/**
	 * Adds a destination e-mail address for a copy of the message.
	 *
	 * @param string $email Destination address for a copy
	 * @param string|null $name Name of the user owning the target mailbox or null for no name
	 * @return \Aimeos\Base\Mail\Message\Iface Message object
	 */
	public function cc( string $email, ?string $name = null ) : Iface
	{
		if( $email ) {
			$this->object->cc( new \Symfony\Component\Mime\Address( $email, (string) $name ) );
		}

		return $this;
	}


	/**
	 * Adds a destination e-mail address for a hidden copy of the message.
	 *
	 * @param array|string $email Destination address for a hidden copy
	 * @return \Aimeos\Base\Mail\Message\Iface Message object
	 */
	public function bcc( $email ) : Iface
	{
		if( !empty( $email ) )
		{
			foreach( (array) $email as $addr ) {
				$this->object->bcc( new \Symfony\Component\Mime\Address( $addr ) );
			}
		}

		return $this;
	}


	/**
	 * Adds the return e-mail address for the message.
	 *
	 * @param string $email E-mail address which should receive all replies
	 * @param string|null $name Name of the user which should receive all replies or null for no name
	 * @return \Aimeos\Base\Mail\Message\Iface Message object
	 */
	public function replyTo( string $email, ?string $name = null ) : Iface
	{
		if( $email ) {
			$this->object->replyTo( new \Symfony\Component\Mime\Address( $email, (string) $name ) );
		}

		return $this;
	}


	/**
	 * Adds a custom header to the message.
	 *
	 * @param string $name Name of the custom e-mail header
	 * @param string $value Text content of the custom e-mail header
	 * @return \Aimeos\Base\Mail\Message\Iface Message object
	 */
	public function header( string $name, string $value ) : Iface
	{
		if( $name ) {
			$this->object->getHeaders()->add( new \Symfony\Component\Mime\Header\UnstructuredHeader( $name, $value ) );
		}

		return $this;
	}


	/**
	 * Sends the e-mail message to the mail server.
	 *
	 * @return \Aimeos\Base\Mail\Message\Iface Message object
	 */
	public function send() : Iface
	{
		$this->mailer->send( $this->object );
		return $this;
	}


	/**
	 * Sets the e-mail address and name of the sender of the message (higher precedence than "From").
	 *
	 * @param string $email Source e-mail address
	 * @param string|null $name Name of the user who sent the message or null for no name
	 * @return \Aimeos\Base\Mail\Message\Iface Message object
	 */
	public function sender( string $email, ?string $name = null ) : Iface
	{
		if( $email ) {
			$this->object->sender( new \Symfony\Component\Mime\Address( $email, (string) $name ) );
		}

		return $this;
	}


	/**
	 * Sets the subject of the message.
	 *
	 * @param string $subject Subject of the message
	 * @return \Aimeos\Base\Mail\Message\Iface Message object
	 */
	public function subject( string $subject ) : Iface
	{
		if( $subject ) {
			$this->object->subject( $subject );
		}

		return $this;
	}


	/**
	 * Sets the text body of the message.
	 *
	 * @param string $message Text body of the message
	 * @return \Aimeos\Base\Mail\Message\Iface Message object
	 */
	public function text( string $message ) : Iface
	{
		if( $message ) {
			$this->object->text( $message, $this->charset );
		}

		return $this;
	}


	/**
	 * Sets the HTML body of the message.
	 *
	 * @param string $message HTML body of the message
	 * @return \Aimeos\Base\Mail\Message\Iface Message object
	 */
	public function html( string $message ) : Iface
	{
		if( $message ) {
			$this->object->html( $message, $this->charset );
		}

		return $this;
	}


	/**
	 * Adds an attachment to the message.
	 *
	 * @param string|null $data Binary or string @author nose
	 * @param string|null $filename Name of the attached file (or null if inline disposition is used)
	 * @param string|null $mimetype Mime type of the attachment (e.g. "text/plain", "application/octet-stream", etc.)
	 * @param string $disposition Type of the disposition ("attachment" or "inline")
	 * @return \Aimeos\Base\Mail\Message\Iface Message object
	 */
	public function attach( ?string $data, ?string $filename = null, ?string $mimetype = null, string $disposition = 'attachment' ) : Iface
	{
		if( $data )
		{
			$mimetype = $mimetype ?: (new \finfo( FILEINFO_MIME_TYPE ))->buffer( $data );
			$filename = $filename ?: md5( $data );

			$this->object->attach( $data, $filename, $mimetype );
		}

		return $this;
	}


	/**
	 * Embeds an attachment into the message and returns its reference.
	 *
	 * @param string|null $data Binary or string
	 * @param string|null $filename Name of the attached file
	 * @param string|null $mimetype Mime type of the attachment (e.g. "text/plain", "application/octet-stream", etc.)
	 * @return string Content ID for referencing the attachment in the HTML body
	 */
	public function embed( ?string $data, ?string $filename = null, ?string $mimetype = null ) : string
	{
		if( $data )
		{
			$mimetype = $mimetype ?: (new \finfo( FILEINFO_MIME_TYPE ))->buffer( $data );
			$filename = $filename ?: md5( $data );

			$this->object->embed( $data, $filename, $mimetype );
			return 'cid:' . $filename;
		}

		return '';
	}


	/**
	 * Returns the internal Symfony mail message object.
	 *
	 * @return \Symfony\Component\Mime\Email Symfony mail message object
	 */
	public function object() : \Symfony\Component\Mime\Email
	{
		return $this->object;
	}


	/**
	 * Clones the internal objects.
	 */
	public function __clone()
	{
		$this->object = clone $this->object;
	}
}
