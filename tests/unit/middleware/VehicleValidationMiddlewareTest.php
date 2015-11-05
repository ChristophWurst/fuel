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

namespace OCA\Fuel\Test\Unit\Middleware;

use PHPUnit_Framework_TestCase;
use OCP\AppFramework\Utility\IControllerMethodReflector;
use OCP\IRequest;
use OCA\Fuel\Validation\IValidator;
use OCA\Fuel\Validation\ValidatorFactory;
use OCA\Fuel\Validation\ValidationException;
use OCA\Fuel\Validation\ValidationResponse;
use OCA\Fuel\Middleware\VehicleValidationMiddleware;

class VehicleValidationMiddlewareTest extends PHPUnit_Framework_TestCase {

	private $reflector;
	private $request;
	private $validatorFactory;
	private $validator;
	private $middleware;

	protected function setUp() {
		parent::setUp();

		$this->reflector = $this->getMockBuilder(IControllerMethodReflector::class)
			->disableOriginalConstructor()
			->getMock();
		$this->request = $this->getMockBuilder(IRequest::class)
			->disableOriginalConstructor()
			->getMock();
		$this->validatorFactory = $this->getMockBuilder(ValidatorFactory::class)
			->disableOriginalConstructor()
			->getMock();
		$this->validator = $this->getMockBuilder(IValidator::class)
			->disableOriginalConstructor()
			->getMock();

		$this->middleware = new VehicleValidationMiddleware($this->reflector,
			$this->request, $this->validatorFactory);
	}

	public function testBeforeControllerNoAnnotation() {
		$this->reflector->expects($this->once())
			->method('hasAnnotation')
			->will($this->returnValue(false));

		// Nothing to test, simply run the method
		$this->middleware->beforeController(null, null);
	}

	private function prepareBeforeControllerTest() {
		$name = "My Car";

		$this->reflector->expects($this->once())
			->method('hasAnnotation')
			->will($this->returnValue(true));
		$this->request->expects($this->once())
			->method('getParam')
			->with("name")
			->will($this->returnValue($name));
		$this->validatorFactory->expects($this->once())
			->method('newValidator')
			->will($this->returnValue($this->validator));
		$this->validator->expects($this->once())
			->method('validateRequired');
		$this->validator->expects($this->once())
			->method('validateMinLength');
		$this->validator->expects($this->once())
			->method('validateMaxLength');
	}

	public function testBeforeControllerValidRequest() {
		$this->prepareBeforeControllerTest();

		$this->validator->expects($this->once())
			->method('fails')
			->will($this->returnValue(false));

		$this->middleware->beforeController(null, null);
	}

	/**
	 * @expectedException \OCA\Fuel\Validation\ValidationException
	 */
	public function testBeforeControllerInvalidRequest() {
		$this->prepareBeforeControllerTest();

		$this->validator->expects($this->once())
			->method('fails')
			->will($this->returnValue(true));

		$this->middleware->beforeController(null, null);
	}

	public function testAfterExceptionOtherException() {
		// Nothing should happen
		$this->middleware->afterException(null, null, new \Exception());
	}

	public function testAfterException() {
		$ve = new ValidationException($this->validator);

		$expected = new ValidationResponse($this->validator);
		$actual = $this->middleware->afterException(null, null, $ve);

		$this->assertEquals($expected, $actual);
	}

}
