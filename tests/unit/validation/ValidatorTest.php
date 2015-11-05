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

namespace OCA\Fuel\Test\Unit\Validation;

use PHPUnit_Framework_TestCase;
use OCA\Fuel\Validation\Validator;

class ValidatorTest extends PHPUnit_Framework_TestCase {

	private $validator;

	protected function setUp() {
		parent::setUp();

		$this->validator = new Validator();
	}

	public function testHasNoErrorsByDefault() {
		$this->assertEmpty($this->validator->getErrors());
	}

	public function testPassesByDefault() {
		$this->assertTrue($this->validator->passes());
		$this->assertFalse($this->validator->fails());
	}

	public function testValidateRequireExisting() {
		$value = "Test";

		$this->validator->validateRequired("my variable", $value);

		$this->assertTrue($this->validator->passes());
		$this->assertFalse($this->validator->fails());
		$this->assertEmpty($this->validator->getErrors());
	}

	public function testValidateRequireMissing() {
		$value = null;

		$this->validator->validateRequired("my non-existing variable", $value);

		$this->assertFalse($this->validator->passes());
		$this->assertTrue($this->validator->fails());
		$this->assertEquals(1, count($this->validator->getErrors()));
	}
	
	public function testValidateMinLengthPass() {
		$value = "my very long value";

		$this->validator->validateMinLength("my variable", $value, 10);

		$this->assertTrue($this->validator->passes());
		$this->assertFalse($this->validator->fails());
		$this->assertEmpty($this->validator->getErrors());
	}

	public function testValidateMinLengthError() {
		$value = "too short";

		$this->validator->validateMinLength("my variable", $value, 10);

		$this->assertFalse($this->validator->passes());
		$this->assertTrue($this->validator->fails());
		$this->assertEquals(1, count($this->validator->getErrors()));
	}
	
	public function testValidateMaxLengthPass() {
		$value = "ttttest";

		$this->validator->validateMaxLength("my variable", $value, 10);

		$this->assertTrue($this->validator->passes());
		$this->assertFalse($this->validator->fails());
		$this->assertEmpty($this->validator->getErrors());
	}

	public function testValidateMaxLengthError() {
		$value = "this might be too long";

		$this->validator->validateMaxLength("my variable", $value, 10);

		$this->assertFalse($this->validator->passes());
		$this->assertTrue($this->validator->fails());
		$this->assertEquals(1, count($this->validator->getErrors()));
	}
	
}
