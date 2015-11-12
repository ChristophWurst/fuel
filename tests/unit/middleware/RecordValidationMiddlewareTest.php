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
use OCP\IL10N;
use OCP\IRequest;
use OCA\Fuel\Validation\IValidator;
use OCA\Fuel\Middleware\RecordValidationMiddleware;

class RecordValidationMiddlewareTest extends PHPUnit_Framework_TestCase {

	private $reflector;
	private $l10n;
	private $request;
	private $validator;
	private $middleware;

	protected function setUp() {
		parent::setUp();

		$this->reflector = $this->getMockBuilder(IControllerMethodReflector::class)
			->disableOriginalConstructor()
			->getMock();
		$this->l10n = $this->getMockBuilder(IL10N::class)
			->disableOriginalConstructor()
			->getMock();
		$this->request = $this->getMockBuilder(IRequest::class)
			->disableOriginalConstructor()
			->getMock();
		$this->validator = $this->getMockBuilder(IValidator::class)
			->disableOriginalConstructor()
			->getMock();
		$this->middleware = new RecordValidationMiddleware($this->reflector,
			$this->request, $this->validator, $this->l10n);
	}

	public function testNoAnnotation() {
		$this->reflector->expects($this->once())
			->method('hasAnnotation')
			->will($this->returnValue(false));

		$this->middleware->beforeController(null, null);
	}

	public function testValidData() {
		$odo = '12315';
		$date = '2015-10-11';
		$fuel = '65.5';
		$price = '82.1';
		$data = [
			['odo' => $odo],
			['date' => $date],
			['fuel' => $fuel],
			['price' => $price],
		];

		$this->reflector->expects($this->once())
			->method('hasAnnotation')
			->will($this->returnValue(true));
		$this->request->expects($this->any())
			->method('getParam')
			->will($this->returnValueMap($data));
		$this->validator->expects($this->exactly(4))
			->method('validateRequired')
			->will($this->returnValue(true));
		$this->validator->expects($this->once())
			->method('validateInt');
		$this->validator->expects($this->once())
			->method('validateDate');
		$this->validator->expects($this->exactly(2))
			->method('validateFloat');
		$this->validator->expects($this->once())
			->method('fails')
			->will($this->returnValue(false));

		$this->middleware->beforeController(null, null);
	}

	/**
	 * @expectedException \OCA\Fuel\Validation\ValidationException
	 */
	public function testInvalidData() {
		$odo = 'abc';
		$date = '2015-33-11';
		$fuel = null;
		$price = null;
		$data = [
			['odo' => $odo],
			['date' => $date],
			['fuel' => $fuel],
			['price' => $price],
		];

		$this->reflector->expects($this->once())
			->method('hasAnnotation')
			->will($this->returnValue(true));
		$this->request->expects($this->any())
			->method('getParam')
			->will($this->returnValueMap($data));
		$this->validator->expects($this->exactly(4))
			->method('validateRequired')
			->will($this->returnValue(true));
		$this->validator->expects($this->once())
			->method('validateInt');
		$this->validator->expects($this->once())
			->method('validateDate');
		$this->validator->expects($this->exactly(2))
			->method('validateFloat');
		$this->validator->expects($this->once())
			->method('fails')
			->will($this->returnValue(true));

		$this->middleware->beforeController(null, null);
	}

	/**
	 * @expectedException \OCA\Fuel\Validation\ValidationException
	 */
	public function testNoData() {
		$odo = null;
		$date = null;
		$fuel = null;
		$price = null;
		$data = [
			['odo' => $odo],
			['date' => $date],
			['fuel' => $fuel],
			['price' => $price],
		];

		$this->reflector->expects($this->once())
			->method('hasAnnotation')
			->will($this->returnValue(true));
		$this->request->expects($this->any())
			->method('getParam')
			->will($this->returnValueMap($data));
		$this->validator->expects($this->exactly(4))
			->method('validateRequired')
			->will($this->returnValue(false));
		$this->validator->expects($this->never())
			->method('validateInt');
		$this->validator->expects($this->never())
			->method('validateDate');
		$this->validator->expects($this->never())
			->method('validateFloat');
		$this->validator->expects($this->once())
			->method('fails')
			->will($this->returnValue(true));

		$this->middleware->beforeController(null, null);
	}

}
