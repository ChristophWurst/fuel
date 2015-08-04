<?php

namespace OCA\Fuel\Controller;

/**
 * ownCloud - fuel
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author Christoph Wurst <christoph@winzerhof-wurst.at>
 * @copyright Christoph Wurst 2015
 */
use Closure;
use OCP\AppFramework\Http;
use OCP\AppFramework\Http\DataResponse;

trait Errors {

	protected function handleNotFound(Closure $callback) {
		try {
			return new DataResponse($callback());
		} catch (Exception $e) {
			$message = [
				'message' => $e->getMessage(),
			];
			return new DataResponse($message, Http::STATUS_NOT_FOUND);
		}
	}

}
