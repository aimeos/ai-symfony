<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2014-2025
 * @package MW
 * @subpackage Session
 */


namespace Aimeos\Base\Session;


/**
 * Implementation using Symfony sessions.
 *
 * @package MW
 * @subpackage Session
 */
class Symfony extends Base implements \Aimeos\Base\Session\Iface
{
	private \Symfony\Component\HttpFoundation\Session\SessionInterface $object;


	/**
	 * Initializes the object.
	 *
	 * @param \Symfony\Component\HttpFoundation\Session\SessionInterface $object Symfony session object
	 */
	public function __construct( \Symfony\Component\HttpFoundation\Session\SessionInterface $object )
	{
		$this->object = $object;
	}


	/**
	 * Remove the given key from the session.
	 *
	 * @param string $name Key of the requested value in the session
	 * @return \Aimeos\Base\Session\Iface Session instance for method chaining
	 */
	public function del( string $name ) : Iface
	{
		$this->object->remove( $name );
		return $this;
	}


	/**
	 * Returns the value of the requested session key.
	 *
	 * If the returned value wasn't a string, it's decoded from its string representation.
	 *
	 * @param string $name Key of the requested value in the session
	 * @param mixed $default Value returned if requested key isn't found
	 * @return mixed Value associated to the requested key
	 */
	public function get( string $name, $default = null )
	{
		return $this->object->get( $name, $default );
	}


	/**
	 * Sets the value for the specified key.
	 *
	 * If the value isn't a string, it's serialized and decoded again when using the get() method.
	 *
	 * @param string $name Key to the value which should be stored in the session
	 * @param mixed $value Value that should be associated with the given key
	 * @return \Aimeos\Base\Session\Iface Session instance for method chaining
	 */
	public function set( string $name, $value ) : Iface
	{
		$this->object->set( $name, $value );
		return $this;
	}
}
