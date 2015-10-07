<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2014
 */


namespace Aimeos\MW\Setup\Task;


/**
 * Adds default records to tables.
 */
class TablesAddFosUserTestData extends \Aimeos\MW\Setup\Task\Base
{
	/**
	 * Returns the list of task names which this task depends on.
	 *
	 * @return array List of task names
	 */
	public function getPreDependencies()
	{
		return array();
	}


	/**
	 * Returns the list of task names which depends on this task.
	 *
	 * @return array List of task names
	 */
	public function getPostDependencies()
	{
		return array();
	}


	/**
	 * Executes the task for MySQL databases.
	 */
	protected function mysql()
	{
		$this->msg('Setting up Aimeos Fos user bundle test data', 0);
		$this->status('');

		$file = __DIR__ . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'mysql.sql';
		$this->process( $file );
	}


	/**
	 * Insert records from file containing the SQL records.
	 *
	 * @param string $filename Name of the file
	 */
	protected function process( $filename )
	{
		$this->msg(sprintf('Adding records from "%1$s"', basename($filename)), 1);

		if( ( $content = file_get_contents( $filename ) ) === false ) {
			throw new \Aimeos\MW\Setup\Exception( sprintf( 'Unable to get content from file "%1$s"', $filename ) );
		}

		$this->execute( $content );
		$this->status( 'done' );
	}
}
