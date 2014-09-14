<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @package MW
 * @subpackage Logger
 */


/**
 * Log messages using Monolog.
 *
 * @package MW
 * @subpackage Logger
 */
class MW_Logger_Monolog
	extends MW_Logger_Abstract
	implements MW_Logger_Interface
{
	private $_logger = null;


	/**
	 * Initializes the logger object.
	 *
	 * @param Monolog\Logger $logger Monolog logger object
	 */
	public function __construct( \Monolog\Logger $logger )
	{
		$this->_logger = $logger;
	}


	/**
	 * Writes a message to the configured log facility.
	 *
	 * @param string $message Message text that should be written to the log facility
	 * @param integer $priority Priority of the message for filtering
	 * @param string $facility Facility for logging different types of messages (e.g. message, auth, user, changelog)
	 * @throws MW_Logger_Exception If an error occurs in Zend_Log
	 * @see MW_Logger_Abstract for available log level constants
	 */
	public function log( $message, $priority = MW_Logger_Abstract::ERR, $facility = 'message' )
	{
		try
		{
			if( !is_scalar( $message ) ) {
				$message = json_encode( $message );
			}

			$this->_logger->log( $this->_translatePriority( $priority ), $message );
		}
		catch( Exception $e )	{
			throw new MW_Logger_Exception( $e->getMessage(), $e->getCode(), $e );
		}
	}


	/**
	 * Translates the log priority to the log levels of Monolog.
	 *
	 * @param integer $priority Log level from MW_Logger_Abstract
	 * @return integer Log level from Monolog\Logger
	 * @throws MW_Logger_Exception If log level is unknown
	 */
	protected function _translatePriority( $priority )
	{
		switch( $priority )
		{
			case MW_Logger_Abstract::EMERG:
				return \Monolog\Logger::EMERGENCY;
			case MW_Logger_Abstract::ALERT:
				return \Monolog\Logger::ALERT;
			case MW_Logger_Abstract::CRIT:
				return \Monolog\Logger::CRITICAL;
			case MW_Logger_Abstract::ERR:
				return \Monolog\Logger::ERROR;
			case MW_Logger_Abstract::WARN:
				return \Monolog\Logger::WARNING;
			case MW_Logger_Abstract::NOTICE:
				return \Monolog\Logger::NOTICE;
			case MW_Logger_Abstract::INFO:
				return \Monolog\Logger::INFO;
			case MW_Logger_Abstract::DEBUG:
				return \Monolog\Logger::DEBUG;
			default:
				throw new MW_Logger_Exception( 'Invalid log level' );
		}
	}
}