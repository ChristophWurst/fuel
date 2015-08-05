<?php

namespace OCA\Fuel\Service;

/**
 * ownCloud - fuel
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author Christoph Wurst <christoph@winzerhof-wurst.at>
 * @copyright Christoph Wurst 2015
 */
use OCP\AppFramework\Db\DoesNotExistException;
use OCP\AppFramework\Db\MultipleObjectsReturnedException;

trait ExceptionHandler {

	protected function handleException($e) {
		if ($e instanceof DoesNotExistException || $e instanceof MultipleObjectsReturnedException) {
			throw new DoesNotExistException($e->getMessage());
		} else {
			throw $e;
		}
	}

}
