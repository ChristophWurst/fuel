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

class Validator implements IValidator {

	private $errors;

	public function __construct() {
		$this->errors = [];
	}

	/**
	 * Check if value is not null
	 *
	 * @param string $name
	 * @param mixed $value
	 */
	public function validateRequired($name, $value) {
		if (is_null($value)) {
			$this->errors[] = "$name is required";
		}
		return $this;
	}

	/**
	 * Check string min length
	 *
	 * @param string $name
	 * @param mixed $value
	 * @param int $length
	 */
	public function validateMinLength($name, $value, $length) {
		if (is_null($value) || strlen($value) < $length) {
			$this->errors[] = "$name must be at least"
				. " $length characters long";
		}
		return $this;
	}

	/**
	 * Check string max length
	 *
	 * @param string $name
	 * @param mixed $value
	 * @param int $length
	 */
	public function validateMaxLength($name, $value, $length) {
		if (is_null($value) || strlen($value) > $length) {
			$this->errors[] = "$name length must not exceed"
				. " $length characters";
		}
		return $this;
	}

	/**
	 * Get all validation errors
	 *
	 * @return array
	 */
	public function getErrors() {
		return $this->errors;
	}

	/**
	 * Returns whether all validation rules passed
	 *
	 * @return bool
	 */
	public function passes() {
		return count($this->errors) === 0;
	}

	/**
	 * Returns whether validation rules failed
	 *
	 * @return bool
	 */
	public function fails() {
		return !$this->passes();
	}

}
