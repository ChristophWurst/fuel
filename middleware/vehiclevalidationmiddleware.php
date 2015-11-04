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

namespace OCA\Fuel\Middleware;

use Exception;
use OCP\AppFramework\Middleware;
use OCP\AppFramework\Utility\IControllerMethodReflector;
use OCP\IRequest;
use OCA\Fuel\Validation\IValidator;
use OCA\Fuel\Validation\ValidationException;
use OCA\Fuel\Validation\ValidationResponse;
use OCA\Fuel\Validation\ValidatorFactory;

class VehicleValidationMiddleware extends Middleware {

	/**
	 * @var ControllerMethodReflector
	 */
	private $reflector;

	/**
	 * @var IRequest
	 */
	private $request;

	/**
	 * @var ValidatorFactory
	 */
	private $validatorFactory;

	public function __construct(IControllerMethodReflector $reflector,
		IRequest $request, ValidatorFactory $validatorFactory) {
		$this->reflector = $reflector;
		$this->request = $request;
		$this->validatorFactory = $validatorFactory;
	}

	private function validateName(IValidator $validator, $name) {
		$validator->validateRequired("Name", $name);
		$validator->validateMinLength("Name", $name, 3);
		$validator->validateMaxLength("Name", $name, 25);
	}

	/**
	 * Validate vehicle data if @ValidateVehicle is used
	 *
	 * @param type $controller
	 * @param type $methodName
	 */
	public function beforeController($controller, $methodName) {
		if ($this->reflector->hasAnnotation('ValidateVehicle')) {
			$name = $this->request->getParam("name");

			$validator = $this->validatorFactory->newValidator();
			$this->validateName($validator, $name);

			if ($validator->fails()) {
				throw new ValidationException($validator);
			}
		}
	}

	public function afterException($controller, $methodName, Exception $exception) {
		if ($exception instanceof ValidationException) {
			return new ValidationResponse($exception->getValidator());
		}
	}

}
