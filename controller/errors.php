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
use Exception;
use OCP\AppFramework\Http;
use OCP\AppFramework\Http\DataResponse;
use OCA\Fuel\Service\NotFoundException;

trait Errors {

	protected function handleNotFound(Closure $callback) {
		try {
			return new DataResponse($callback());
		} catch (NotFoundException $e) {
			return new DataResponse($e, Http::STATUS_NOT_FOUND);
		} catch (Exception $e) {
			$message = [
				'message' => $e->getMessage(),
			];
			return new DataResponse($message, Http::STATUS_NOT_FOUND);
		}
	}

}
