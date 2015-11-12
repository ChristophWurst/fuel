<?php

/**
 * ownCloud - fuel
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author Christoph Wurst <christoph@winzerhof-wurst.at>
 * @copyright Christoph Wurst 2015
 */

namespace OCA\Fuel\Test\Unit;

use PHPUnit_Framework_TestCase;
use OCA\Fuel\Validation\ValidationException;
use OCA\Fuel\Validation\IValidator;

class ValidationExceptionTest extends PHPUnit_Framework_TestCase {

	private $validator;
	private $exception;

	protected function setUp() {
		parent::setUp();

		$this->validator = $this->getMockBuilder(IValidator::class)
			->disableOriginalConstructor()
			->getMock();

		$this->exception = new ValidationException($this->validator);
	}

	public function testGetException() {
		$this->assertSame($this->validator, $this->exception->getValidator());
	}

}
