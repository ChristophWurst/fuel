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

interface IValidator {

	/**
	 * Check if value is not null
	 *
	 * @param string $name
	 * @param mixed $value
	 */
	public function validateRequired($name, $value);

	/**
	 * Check string min length
	 *
	 * @param string $name
	 * @param mixed $value
	 * @param int $length
	 */
	public function validateMinLength($name, $value, $length);

	/**
	 * Check string max length
	 *
	 * @param string $name
	 * @param mixed $value
	 * @param int $length
	 */
	public function validateMaxLength($name, $value, $length);

	/**
	 * Get all validation errors
	 *
	 * @return array
	 */
	public function getErrors();

	/**
	 * Returns whether all validation rules passed
	 *
	 * @return bool
	 */
	public function passes();

	/**
	 * Returns whether validation rules failed
	 *
	 * @return bool
	 */
	public function fails();
}
