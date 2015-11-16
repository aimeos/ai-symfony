<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015
 */


namespace Aimeos\MShop\Customer\Item;


/**
 * Test class for \Aimeos\MShop\Customer\Item\FosUser.
 */
class FosUserTest extends \PHPUnit_Framework_TestCase
{
	private $object;


	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 *
	 * @access protected
	 */
	protected function setUp()
	{
		$addressValues = array(
			'parentid' => 'referenceid',
			'pos' => 1,
		);

		$address = new \Aimeos\MShop\Common\Item\Address\Standard( 'common.address.', $addressValues );

		$values = array(
			'id' => 541,
			'siteid' => 123,
			'label' => 'unitObject',
			'code' => '12345ABCDEF',
			'birthday' => '2010-01-01',
			'status' => 1,
			'password' => '',
			'vdate' => null,
			'company' => 'unitCompany',
			'vatid' => 'DE999999999',
			'salutation' => \Aimeos\MShop\Common\Item\Address\Base::SALUTATION_MR,
			'title' => 'Dr.',
			'firstname' => 'firstunit',
			'lastname' => 'lastunit',
			'address1' => 'unit str.',
			'address2' => ' 166',
			'address3' => '4.OG',
			'postal' => '22769',
			'city' => 'Hamburg',
			'state' => 'Hamburg',
			'countryid' => 'de',
			'langid' => 'de',
			'telephone' => '05554433221',
			'email' => 'unit.test@example.com',
			'telefax' => '05554433222',
			'website' => 'www.example.com',
			'mtime'=> '2010-01-05 00:00:05',
			'ctime'=> '2010-01-01 00:00:00',
			'editor' => 'unitTestUser',
			'roles' => array( 'ROLE_ADMIN' ),
		);

		$this->object = new \Aimeos\MShop\Customer\Item\FosUser( $address, $values, array(), array(), 'mshop', null );
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 *
	 * @access protected
	 */
	protected function tearDown()
	{
		unset( $this->object );
	}

	public function testGetRoles()
	{
		$this->assertEquals( array( 'ROLE_ADMIN' ), $this->object->getRoles() );
	}

	public function testSetRoles()
	{
		$this->object->setRoles( array( 'ROLE_USER' ) );
		$this->assertTrue( $this->object->isModified() );
		$this->assertEquals( array( 'ROLE_USER' ), $this->object->getRoles() );
	}

	public function testIsModified()
	{
		$this->assertFalse( $this->object->isModified() );
	}
}
