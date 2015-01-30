<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015
 * @package MShop
 * @subpackage Customer
 */


/**
 * Customer DTO object for the FosUserBundle.
 *
 * @package MShop
 * @subpackage Customer
 */
class MShop_Customer_Item_FosUser
	extends MShop_Customer_Item_Default
{
	private $_roles;


	/**
	 * Returns the associated user roles
	 *
	 * @return array List of Symfony roles
	 */
	public function getRoles()
	{
		if( isset( $this->_roles ) ) {
			return $this->_roles;
		}

		$values = $this->_getRawValues();
		return ( isset( $values['roles'] ) ? (array) $values['roles'] : array() );
	}


	/**
	 * Sets the associated user roles
	 *
	 * @param array $roles List of Symfony roles
	 */
	public function setRoles( array $roles )
	{
		$this->_roles = $roles;
		$this->setModified();
	}
}