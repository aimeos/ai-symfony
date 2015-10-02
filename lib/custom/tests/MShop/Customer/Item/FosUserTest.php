<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015
 */


/**
 * Test class for MShop_Customer_Item_FosUser.
 */
class MShop_Customer_Item_FosUserTest extends MW_Unittest_Testcase
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
			'refid' => 'referenceid',
			'pos' => 1,
		);

		$address = new MShop_Common_Item_Address_Default( 'common.address.', $addressValues );

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
			'salutation' => MShop_Common_Item_Address_Abstract::SALUTATION_MR,
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

		$this->object = new MShop_Customer_Item_FosUser( $address, $values, array(), array(), 'mshop', null );
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
