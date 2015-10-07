<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2014
 */


namespace Aimeos\MW\Setup\Task;


/**
 * Adds Laravel customer test data.
 */
class CustomerAddFosUserTestData extends \Aimeos\MW\Setup\Task\CustomerAddTestData
{
	/**
	 * Returns the list of task names which this task depends on.
	 *
	 * @return string[] List of task names
	 */
	public function getPreDependencies()
	{
		return array( 'TablesAddFosUserTestData' );
	}


	/**
	 * Adds customer TYPO3 test data.
	 */
	protected function process()
	{
		$iface = '\\Aimeos\\MShop\\Context\\Item\\Iface';
		if( !( $this->additional instanceof $iface ) ) {
			throw new \Aimeos\MW\Setup\Exception( sprintf( 'Additionally provided object is not of type "%1$s"', $iface ) );
		}

		$this->msg( 'Adding Fos user bundle customer test data', 0 );
		$this->additional->setEditor( 'ai-symfony:unittest' );

		$parentIds = array();
		$ds = DIRECTORY_SEPARATOR;
		$path = __DIR__ . $ds . 'data' . $ds . 'customer.php';

		if( ( $testdata = include( $path ) ) === false ){
			throw new \Aimeos\MShop\Exception( sprintf( 'No file "%1$s" found for customer domain', $path ) );
		}


		$customerManager = \Aimeos\MShop\Customer\Manager\Factory::createManager( $this->additional, 'FosUser' );
		$customerAddressManager = $customerManager->getSubManager( 'address', 'FosUser' );

		foreach( $customerManager->searchItems( $customerManager->createSearch() ) as $id => $item ) {
			$parentIds[ 'customer/' . $item->getCode() ] = $id;
		}

		$this->conn->begin();

		$this->addCustomerAddressData( $testdata, $customerAddressManager, $parentIds );

		$this->conn->commit();


		$this->status( 'done' );
	}
}
