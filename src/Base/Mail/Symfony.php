<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2023
 * @package MW
 * @subpackage Session
 */


namespace Aimeos\Base\Mail;


/**
 * Implementation using Symfony sessions.
 *
 * @package MW
 * @subpackage Session
 */
class Symfony extends Base implements \Aimeos\Base\Mail\Iface
{
	private \Closure $closure;

	/**
	 * Initializes the instance of the class.
	 *
	 * @param \Closure $closure Closure generating TYPO3 mail message objects
	 */
	public function __construct( \Closure $closure )
	{
		$this->closure = $closure;
	}


	/**
	 * Creates a new e-mail message object.
	 *
	 * @param string $charset Default charset of the message
	 * @return \Aimeos\Base\Mail\Message\Iface E-mail message object
	 */
	public function create( string $charset = 'UTF-8' ) : \Aimeos\Base\Mail\Message\Iface
	{
		$closure = $this->closure;
		return new \Aimeos\Base\Mail\Message\Symfony( $closure(), new \Symfony\Component\Mime\Email(), $charset );
	}


	/**
	 * Sends the e-mail message to the mail server.
	 *
	 * @param \Aimeos\Base\Mail\Message\Iface $message E-mail message object
	 */
	public function send( \Aimeos\Base\Mail\Message\Iface $message ) : Iface
	{
		$closure = $this->closure;
		$closure()->send( $message->object() );

		return $this;
	}
}
