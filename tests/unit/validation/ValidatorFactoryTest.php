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
use PHPUnit_Framework_TestCase;
use OCP\IL10N;
use OCA\Fuel\Validation\ValidatorFactory;
use OCA\Fuel\Validation\IValidator;

class ValidatorFactoryTest extends PHPUnit_Framework_TestCase {

	private $l10n;
	private $factory;

	protected function setUp() {
		parent::setUp();

		$this->l10n = $this->getMockBuilder(IL10N::class)
			->disableOriginalConstructor()
			->getMock();

		$this->factory = new ValidatorFactory($this->l10n);
	}

	public function testNewValidator() {
		$this->assertInstanceOf(IValidator::class, $this->factory->newValidator());
	}

}
