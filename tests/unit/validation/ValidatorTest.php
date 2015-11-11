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

		$result = $this->validator->validateRequired("my variable", $value);

		$this->assertTrue($result);
		$this->assertTrue($this->validator->passes());
		$this->assertFalse($this->validator->fails());
		$this->assertEmpty($this->validator->getErrors());
	}

	public function testValidateRequireMissing() {
		$value = null;

		$result = $this->validator->validateRequired("my non-existing variable",
			$value);

		$this->assertFalse($result);
		$this->assertFalse($this->validator->passes());
		$this->assertTrue($this->validator->fails());
		$this->assertEquals(1, count($this->validator->getErrors()));
	}

	public function testValidateMinLengthPass() {
		$value = "my very long value";

		$result = $this->validator->validateMinLength("my variable", $value, 10);

		$this->assertTrue($result);
		$this->assertTrue($this->validator->passes());
		$this->assertFalse($this->validator->fails());
		$this->assertEmpty($this->validator->getErrors());
	}

	public function testValidateMinLengthError() {
		$value = "too short";

		$result = $this->validator->validateMinLength("my variable", $value, 10);

		$this->assertFalse($result);
		$this->assertFalse($this->validator->passes());
		$this->assertTrue($this->validator->fails());
		$this->assertEquals(1, count($this->validator->getErrors()));
	}

	public function testValidateMaxLengthPass() {
		$value = "ttttest";

		$result = $this->validator->validateMaxLength("my variable", $value, 10);

		$this->assertTrue($result);
		$this->assertTrue($this->validator->passes());
		$this->assertFalse($this->validator->fails());
		$this->assertEmpty($this->validator->getErrors());
	}

	public function testValidateMaxLengthError() {
		$value = "this might be too long";

		$result = $this->validator->validateMaxLength("my variable", $value, 10);

		$this->assertFalse($result);
		$this->assertFalse($this->validator->passes());
		$this->assertTrue($this->validator->fails());
		$this->assertCount(1, $this->validator->getErrors());
	}

	public function validateIntDataProvider() {
		return [
			[null,
				false],
			[123,
				true],
			['213',
				true],
			[' 2',
				true],
		];
	}

	/**
	 * @dataProvider validateIntDataProvider
	 */
	public function testValidateInt($value, $expected) {
		$result = $this->validator->validateInt("my var", $value);

		$this->assertEquals($expected, $result);
		$this->assertEquals($expected, $this->validator->passes());
		$this->assertEquals(!$expected, $this->validator->fails());
		$this->assertCount($expected ? 0 : 1, $this->validator->getErrors());
	}

	public function validateFloatDataProvider() {
		return [
			[null,
				false],
			[123,
				true],
			[123.4,
				true],
			['213',
				true],
			['123.4',
				true],
			[' 2',
				true],
		];
	}

	/**
	 * @dataProvider validateFloatDataProvider
	 */
	public function testValidateFloat($value, $expected) {
		$result = $this->validator->validateFloat("my var", $value);

		$this->assertEquals($expected, $result);
		$this->assertEquals($expected, $this->validator->passes());
		$this->assertEquals(!$expected, $this->validator->fails());
		$this->assertCount($expected ? 0 : 1, $this->validator->getErrors());
	}

	public function validateDateDataProvider() {
		return [
			[null,
				false],
			['2015-11-08T14:30:06.694Z',
				false],
			['2015/9/3',
				false],
			['15/9/3',
				false],
			['2015-09-03',
				true],
			['2015-12-32',
				false]
		];
	}

	/**
	 * @dataProvider validateDateDataProvider
	 */
	public function testValidateDate($value, $expected) {
		$result = $this->validator->validateDate("my var", $value);

		$this->assertEquals($expected, $result);
		$this->assertEquals($expected, $this->validator->passes());
		$this->assertEquals(!$expected, $this->validator->fails());
		$this->assertCount($expected ? 0 : 1, $this->validator->getErrors());
	}

}
