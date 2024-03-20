<?php

namespace MaximumSlider\Tests;

use MaximumSlider\ImportData as ImportData;

/**
 * The Import class.
 *
 * This class is responsible for importing data.
 */
class Import extends \WP_UnitTestCase {

	/**
	 * A single example test.
	 */
	public function start(): void
	{
		$import = new ImportData();
		$import->init();

		// Replace this with some actual testing code.
		$this->assertTrue( true );
	}
}
