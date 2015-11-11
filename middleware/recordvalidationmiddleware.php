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
use OCP\IL10N;
use OCP\IRequest;
use OCA\Fuel\Validation\IValidator;

class RecordValidationMiddleware extends ValidationMiddleware {

	/**
	 * @var IL10N
	 */
	private $l10n;

	public function __construct(IControllerMethodReflector $reflector,
		IRequest $request, IValidator $validator, $L10n) {
		parent::__construct("ValidateRecord", $reflector, $request, $validator);
		$this->l10n = $L10n;
	}

	private function validateOdo() {
		$odo = $this->request->getParam("odo");
		$name = $this->l10n->t("Odometer");
		if (!$this->validator->validateRequired($name, $odo)) {
			return;
		}
		$this->validator->validateInt($name, $odo);
	}

	private function validateDate() {
		$date = $this->request->getParam("date");
		$name = $this->l10n->t("Date");
		if (!$this->validator->validateRequired($name, $date)) {
			return;
		}
		$this->validator->validateDate($name, $date);
	}

	private function validateFuel() {
		$fuel = $this->request->getParam("fuel");
		$name = $this->l10n->t("Fuel");
		if (!$this->validator->validateRequired($name, $fuel)) {
			return;
		}
		$this->validator->validateFloat($name, $fuel);
	}

	private function validatePrice() {
		$price = $this->request->getParam("price");
		$name = $this->l10n->t("Price");
		if (!$this->validator->validateRequired($name, $price)) {
			return;
		}
		$this->validator->validateFloat($name, $price);
	}

	protected function validate() {
		$this->validateOdo();
		$this->validateDate();
		$this->validateFuel();
		$this->validatePrice();
	}

}
