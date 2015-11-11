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

use OCP\AppFramework\Http\JSONResponse;
use OCP\AppFramework\Http;

class ValidationResponse extends JSONResponse {

	/**
	 * @param \OCA\Fuel\Validation\IValidator $validator
	 */
	public function __construct(IValidator $validator) {
		parent::__construct([
			"errors" => $validator->getErrors()
		], Http::STATUS_UNPROCESSABLE_ENTITY);
	}

}
