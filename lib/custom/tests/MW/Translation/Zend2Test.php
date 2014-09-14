<?php

/**
 * Test class for MW_Translation_Zend2Test.
 *
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 */
class MW_Translation_Zend2Test extends MW_Unittest_Testcase
{
	private $_object;


	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 *
	 * @access protected
	 */
	protected function setUp()
	{
		if( !class_exists( '\Zend\I18n\Translator\Translator' ) ) {
			$this->markTestSkipped( '\Zend\I18n\Translator\Translator is not available' );
		}

		$ds = DIRECTORY_SEPARATOR;

		$this->_translationSources = array(
			'testDomain' => array( __DIR__ . $ds . 'testfiles' . $ds . 'case1' ),
			'otherTestDomain' => array( __DIR__ . $ds . 'testfiles' . $ds . 'case2' ),
			'thirdTestDomain' => array( __DIR__ . $ds . 'testfiles' . $ds . 'case3' ),
		);

		$this->_object = new MW_Translation_Zend2( $this->_translationSources, 'PhpArray', 'ru_ZD' );
	}


	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 *
	 * @access protected
	 */
	protected function tearDown()
	{
		$this->_object = null;
	}


	public function testDt()
	{
		$this->assertEquals( 'singular translation', $this->_object->dt( 'testDomain', 'File' ) );
		$this->assertEquals( 'Test default return', $this->_object->dt( 'otherTestDomain', 'Test default return' ) );
		$this->assertEquals( 'test', $this->_object->dt( 'invalidTestDomain', 'test' ) );
	}


	public function testDn()
	{
		/*
		 * plural for RU: 3 pl forms
		 * 0, if $n == 1, 21, 31, 41, ...
		 * 1, if $n == 2..4, 22..24, 32..34, ...
		 * 2, if $n == 5..20, 25..30, 35..40, .
		 */
		$this->assertEquals( 'plural 2 translation', $this->_object->dn( 'otherTestDomain', 'File', 'Files', 0 ) );
		$this->assertEquals( 'singular translation', $this->_object->dn( 'otherTestDomain', 'File', 'Files', 1 ) );
		$this->assertEquals( 'plural 1 translation', $this->_object->dn( 'otherTestDomain', 'File', 'Files', 2 ) );
		$this->assertEquals( 'plural 2 translation', $this->_object->dn( 'otherTestDomain', 'File', 'Files', 5 ) );

		$this->assertEquals( 'plural 1 translation', $this->_object->dn( 'otherTestDomain', 'File', 'Files', 22 ) );
		$this->assertEquals( 'plural 2 translation', $this->_object->dn( 'otherTestDomain', 'File', 'Files', 25 ) );
		$this->assertEquals( 'singular translation', $this->_object->dn( 'otherTestDomain', 'File', 'Files', 31 ) );

		$this->assertEquals( 'tests', $this->_object->dn( 'invalidTestDomain', 'test', 'tests', 2 ) );
	}


	// test using the testfiles/case1/ka_GE file; lang: german
	public function testAdapterGettext()
	{
		$object = new MW_Translation_Zend2( $this->_translationSources, 'gettext', 'ka_GE', array('disableNotices'=>true) );

		$this->assertEquals( 'Aktualisierung', $object->dt( 'testDomain', 'Update' ) );

		$this->assertEquals( 'Autos', $object->dn( 'testDomain', 'Car', 'Cars', 0 ) );
		$this->assertEquals( 'Datei', $object->dn( 'testDomain', 'File', 'Files', 1 ) );
	}


	public function testDnOverwriteFile()
	{
		$ds = DIRECTORY_SEPARATOR;

		$translationSources = array(
			'testDomain' => array(
				__DIR__ . $ds . 'testfiles' . $ds . 'case2',
				__DIR__ . $ds . 'testfiles' . $ds . 'case3',
			),
		);

		$object = new MW_Translation_Zend2( $translationSources, 'PhpArray', 'ru_ZD' );

		$this->assertEquals( 'plural 11 translation', $object->dn( 'testDomain', 'File', 'Files', 25 ) );
	}


	public function testDnOverwriteGettextSingular()
	{
		$ds = DIRECTORY_SEPARATOR;

		$translationSources = array(
			'testDomain' => array(
				__DIR__ . $ds . 'testfiles' . $ds . 'case1',
				__DIR__ . $ds . 'testfiles' . $ds . 'case2',
			),
		);

		$object = new MW_Translation_Zend2( $translationSources, 'gettext', 'ka_GE' );
		$this->assertEquals( 'Neue Version', $object->dt( 'testDomain', 'Update' ) );
	}


	public function testDnOverwriteGettextPlural()
	{
		$ds = DIRECTORY_SEPARATOR;

		$translationSources = array(
			'testDomain' => array(
				__DIR__ . $ds . 'testfiles' . $ds . 'case1',
				__DIR__ . $ds . 'testfiles' . $ds . 'case2',
			),
		);

		$object = new MW_Translation_Zend2( $translationSources, 'gettext', 'ka_GE' );
		$this->assertEquals( 'KFZs', $object->dn( 'testDomain', 'Car', 'Cars', 25 ) );
	}


	public function testGetAll()
	{
		$ds = DIRECTORY_SEPARATOR;

		$translationSources = array(
			'testDomain' => array(
				__DIR__ . $ds . 'testfiles' . $ds . 'case1',
				__DIR__ . $ds . 'testfiles' . $ds . 'case2',
			),
		);

		$object = new MW_Translation_Zend2( $translationSources, 'gettext', 'ka_GE' );
		$result = $object->getAll( 'testDomain' );

		$this->assertArrayHasKey( 'Car', $result );
		$this->assertEquals( 'KFZ', $result['Car'][0] );
		$this->assertEquals( 'KFZs', $result['Car'][1] );
		$this->assertArrayHasKey( 'File', $result );
		$this->assertEquals( 'Datei mehr', $result['File'][0] );
		$this->assertEquals( 'Dateien mehr', $result['File'][1] );
		$this->assertArrayHasKey( 'Update', $result );
		$this->assertEquals( 'Neue Version', $result['Update'] );
	}

}
