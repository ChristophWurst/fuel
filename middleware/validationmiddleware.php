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

abstract class ValidationMiddleware extends Middleware {

	/**
	 * @var string
	 */
	private $annotation;

	/**
	 * @var ControllerMethodReflector
	 */
	protected $reflector;

	/**
	 * @var IRequest
	 */
	protected $request;

	/**
	 * @var IValidator
	 */
	protected $validator;

	/**
	 * @param string $annotation
	 * @param IControllerMethodReflector $reflector
	 * @param IRequest $request
	 * @param IValidator $validator
	 */
	public function __construct($annotation, IControllerMethodReflector $reflector,
		IRequest $request, IValidator $validator) {
		$this->annotation = $annotation;
		$this->reflector = $reflector;
		$this->request = $request;
		$this->validator = $validator;
	}

	/**
	 * Validate the request data an return the validtion result
	 *
	 * @return bool
	 */
	protected abstract function validate();

	/**
	 * Validate vehicle data if @ValidateVehicle is used
	 *
	 * @param type $controller
	 * @param type $methodName
	 */
	public function beforeController($controller, $methodName) {
		if ($this->reflector->hasAnnotation($this->annotation)) {
			$this->validate();
			if ($this->validator->fails()) {
				throw new ValidationException($this->validator);
			}
		}
	}

	public function afterException($controller, $methodName, Exception $exception) {
		if ($exception instanceof ValidationException) {
			return new ValidationResponse($exception->getValidator());
		}
	}

}
