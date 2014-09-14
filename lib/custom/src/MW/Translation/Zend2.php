<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @package MW
 * @subpackage Translation
 */


/**
 * Translation using Zend\I18n\Translator\Translator
 *
 * @package MW
 * @subpackage Translation
 */
class MW_Translation_Zend2
	extends MW_Translation_Abstract
	implements MW_Translation_Interface
{
	private $_adapter;
	private $_options;
	private $_translationSources;
	private $_translations = array();


	/**
	 * Initializes the translation object using Zend_Translate.
	 * This implementation only accepts files as source for the Zend_Translate_Adapter.
	 *
	 * @param array $translationSources Associative list of translation domains and lists of translation directories.
	 * 	Translations from the first file aren't overwritten by the later ones
	 * as key and the directory where the translation files are located as value.
	 * @param string $adapter Name of the Zend translation adapter
	 * @param string $locale ISO language name, like "en" or "en_US"
	 * @param string $options Associative array containing additional options for Zend\I18n\Translator\Translator
	 *
	 * @link http://framework.zend.com/manual/2.3/en/modules/zend.i18n.translating.html
	 */
	public function __construct( array $translationSources, $adapter, $locale, array $options = array() )
	{
		parent::__construct( $locale );

		$this->_adapter = $adapter;
		$this->_options = $options;
		$this->_options['locale'] = (string) $locale;
		$this->_translationSources = $translationSources;
	}


	/**
	 * Returns the translated string for the given domain.
	 *
	 * @param string $domain Translation domain
	 * @param string $singular String to be translated
	 * @return string The translated string
	 * @throws MW_Translation_Exception Throws exception on initialization of the translation
	 */
	public function dt( $domain, $singular )
	{
		try
		{
			$locale = $this->getLocale();

			foreach( $this->_getTranslations( $domain ) as $object )
			{
				if( ( $string = $object->translate( $singular, $domain, $locale ) ) != $singular ) {
					return $string;
				}
			}
		}
		catch( Exception $e ) { ; } // Discard errors, return original string instead

		return (string) $singular;
	}


	/**
	 * Returns the translated singular or plural form of the string depending on the given number.
	 *
	 * @param string $domain Translation domain
	 * @param string $singular String in singular form
	 * @param string $plural String in plural form
	 * @param integer $number Quantity to choose the correct plural form for languages with plural forms
	 * @return string Returns the translated singular or plural form of the string depending on the given number
	 * @throws MW_Translation_Exception Throws exception on initialization of the translation
	 *
	 * @link http://framework.zend.com/manual/en/zend.translate.plurals.html
	 */
	public function dn( $domain, $singular, $plural, $number )
	{
		try
		{
			$locale = $this->getLocale();

			foreach( $this->_getTranslations( $domain ) as $object )
			{
				if( ( $string = $object->translatePlural( $singular, $plural, $number, $domain, $locale ) ) != $singular ) {
					return $string;
				}
			}
		}
		catch( Exception $e ) { ; } // Discard errors, return original string instead

		if( $this->_getPluralIndex( $number, $this->getLocale() ) > 0 ) {
			return (string) $plural;
		}

		return (string) $singular;
	}


	/**
	 * Returns all locale string of the given domain.
	 *
	 * @param string $domain Translation domain
	 * @return array Associative list with original string as key and associative list with index => translation as value
	 */
	public function getAll( $domain )
	{
		$messages = array();
		$locale = $this->getLocale();

		foreach( $this->_getTranslations( $domain ) as $object ) {
			$messages = $messages + (array) $object->getMessages( $domain, $locale );
		}

		return $messages;
	}


	/**
	 * Returns the initialized Zend translation object which contains the translations.
	 *
	 * @param string $domain Translation domain
	 * @return array List of translation objects implementing Zend_Translate
	 * @throws MW_Translation_Exception If initialization fails
	 */
	protected function _getTranslations( $domain )
	{
		if( !isset( $this->_translations[$domain] ) )
		{
			if ( !isset( $this->_translationSources[$domain] ) )
			{
				$msg = sprintf( 'No translation directory for domain "%1$s" available', $domain );
				throw new MW_Translation_Exception( $msg );
			}

			$locale = $this->getLocale();
			// Reverse locations so the former gets not overwritten by the later
			$locations = array_reverse( $this->_getTranslationFileLocations( $this->_translationSources[$domain], $locale ) );

			foreach( $locations as $location )
			{
				$translator = \Zend\I18n\Translator\MwTranslator::factory( $this->_options );
				$translator->addTranslationFile( $this->_adapter, $location, $domain, $locale );

				$this->_translations[$domain][$location] = $translator;
			}
		}

		return ( isset( $this->_translations[$domain] ) ? $this->_translations[$domain] : array() );
	}

}
