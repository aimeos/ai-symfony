<?php

/**
 * @license LGPLv3, https://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2024
 * @package Base
 * @subpackage Mail
 */


namespace Aimeos\Base\Mail\Manager;


/**
 * Symfony mail manager
 *
 * @package Base
 * @subpackage Mail
 */
class Symfony implements Iface
{
	private \Closure $closure;


	/**
	 * Initializes the instance of the class.
	 *
	 * @param \Closure $closure Closure generating mail message objects
	 */
	public function __construct( \Closure $closure )
	{
		$this->closure = $closure;
	}


	/**
	 * Returns the mailer for the given name
	 *
	 * @param string|null $name Key for the mailer
	 * @return \Aimeos\Base\Mail\Iface Mail object
	 */
	public function get( ?string $name = null ) : \Aimeos\Base\Mail\Iface
	{
		return new \Aimeos\Base\Mail\Symfony( $this->closure );
	}
}
