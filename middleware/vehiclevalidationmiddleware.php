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

use OCP\AppFramework\Utility\IControllerMethodReflector;
use OCP\IRequest;
use OCA\Fuel\Validation\IValidator;

class VehicleValidationMiddleware extends ValidationMiddleware {

	/**
	 * @param IControllerMethodReflector $reflector
	 * @param IRequest $request
	 * @param IValidator $validator
	 */
	public function __construct(IControllerMethodReflector $reflector,
		IRequest $request, IValidator $validator) {
		parent::__construct("ValidateVehicle", $reflector, $request, $validator);
	}

	private function validateName($name) {
		$this->validator->validateRequired("Name", $name);
		$this->validator->validateMinLength("Name", $name, 3);
		$this->validator->validateMaxLength("Name", $name, 25);
	}

	protected function validate() {
		$name = $this->request->getParam("name");

		$this->validateName($name);
	}

}
