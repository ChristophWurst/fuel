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

class ValidatorFactory {

	/**
	 * @var \OCP\IL10N
	 */
	private $l10n;

	/**
	 * @param \OCP\IL10N $L10n
	 */
	public function __construct($L10n) {
		$this->l10n = $L10n;
	}

	/**
	 * Get a new Validator instance
	 *
	 * @return \OCA\Fuel\Validation\IValidator
	 */
	public function newValidator() {
		return new Validator($this->l10n);
	}

}
