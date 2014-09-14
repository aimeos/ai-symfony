<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @package MW
 * @subpackage Translation
 */


namespace Zend\I18n\Translator;
use Zend\I18n\Translator\Translator;


/**
 * Zend\I18n\Translator\Translator with ability to return all messages
 *
 * @package Zend
 * @subpackage I18n
 */
class MwTranslator extends Translator
{
	/**
	 * Returns all message strings and translations.
	 *
	 * @param string $domain Translation domain
	 * @param string $locale $locale ISO language name, like "en" or "en_US"
	 * @return Zend\I18n\Translator\TextDomain Array like TextDomain object
	 */
	public function getMessages( $domain = 'default', $locale = null )
	{
		if( $locale === null ) {
			$locale = $this->getLocale();
		}

		if( !isset( $this->messages[$domain][$locale] ) ) {
			$this->loadMessages( $domain, $locale );
		}

		return $this->messages[$domain][$locale];
	}
}