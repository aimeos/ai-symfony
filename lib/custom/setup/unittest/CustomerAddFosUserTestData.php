<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2014
 */


/**
 * Adds Laravel customer test data.
 */
class MW_Setup_Task_CustomerAddFosUserTestData extends MW_Setup_Task_CustomerAddTestData
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
	protected function _process()
	{
		$iface = 'MShop_Context_Item_Interface';
		if( !( $this->_additional instanceof $iface ) ) {
			throw new MW_Setup_Exception( sprintf( 'Additionally provided object is not of type "%1$s"', $iface ) );
		}

		$this->_msg( 'Adding Fos user bundle customer test data', 0 );
		$this->_additional->setEditor( 'ai-symfony:unittest' );

		$parentIds = array();
		$ds = DIRECTORY_SEPARATOR;
		$path = __DIR__ . $ds . 'data' . $ds . 'customer.php';

		if( ( $testdata = include( $path ) ) == false ){
			throw new MShop_Exception( sprintf( 'No file "%1$s" found for customer domain', $path ) );
		}


		$customerManager = MShop_Customer_Manager_Factory::createManager( $this->_additional, 'FosUser' );
		$customerAddressManager = $customerManager->getSubManager( 'address', 'FosUser' );

		foreach( $customerManager->searchItems( $customerManager->createSearch() ) as $id => $item ) {
			$parentIds[ 'customer/' . $item->getCode() ] = $id;
		}

		$this->_conn->begin();

		$this->_addCustomerAddressData( $testdata, $customerAddressManager, $parentIds );

		$this->_conn->commit();


		$this->_status( 'done' );
	}
}
