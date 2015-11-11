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
	 * @return bool validation result
	 */
	public function validateRequired($name, $value) {
		if (is_null($value)) {
			$this->errors[] = "$name is required";
			return false;
		}
		return true;
	}

	/**
	 * Check string min length
	 *
	 * @param string $name
	 * @param mixed $value
	 * @param int $length
	 * @return bool validation result
	 */
	public function validateMinLength($name, $value, $length) {
		if (is_null($value) || strlen($value) < $length) {
			$this->errors[] = "$name must be at least"
				. " $length characters long";
			return false;
		}
		return true;
	}

	/**
	 * Check string max length
	 *
	 * @param string $name
	 * @param mixed $value
	 * @param int $length
	 * @return bool validation result
	 */
	public function validateMaxLength($name, $value, $length) {
		if (is_null($value) || strlen($value) > $length) {
			$this->errors[] = "$name length must not exceed"
				. " $length characters";
			return false;
		}
		return true;
	}

	/**
	 * @param string $name
	 * @param mixed $value
	 * @return bool validation result
	 */
	public function validateInt($name, $value) {
		$result = filter_var($value, FILTER_VALIDATE_INT);
		if ($result === false) {
			$this->errors[] = "$name must be an integer";
			return false;
		}
		return true;
	}

	/**
	 * @param string $name
	 * @param mixed $value
	 * @return bool validation result
	 */
	public function validateFloat($name, $value) {
		$result = filter_var($value, FILTER_VALIDATE_FLOAT);
		if ($result === false) {
			$this->errors[] = "$name must be a floating-point number";
			return false;
		}
		return true;
	}

	/**
	 * @param string $name
	 * @param mixed $value
	 * @return bool validation result
	 */
	public function validateDate($name, $value) {
		$result = preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', $value, $matches);
		if (is_null($result) || $result === 0) {
			$this->errors[] = "$name must be in the format YYYY-MMM-DD";
			return false;
		}
		if (!checkdate($matches[2], $matches[3], $matches[1])) {
			$this->errors[] = "$name is an invalid date";
			return false;
		}
		return true;
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
