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

namespace OCA\Fuel\Validation;

use Exception;

class ValidationException extends Exception {

	/**
	 * @var Validator
	 */
	private $validator;

	/**
	 * @param \OCA\Fuel\Validation\IValidator $validator
	 */
	public function __construct(IValidator $validator) {
		parent::__construct("Validation error");
		$this->validator = $validator;
	}

	/**
	 * Get the validator that contains the validation errors
	 *
	 * @return IValidator
	 */
	public function getValidator() {
		return $this->validator;
	}

}
